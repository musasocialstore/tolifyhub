# TolifyHub

A fresh rebuild of the Musa Social Store idea as a new store — **TolifyHub**.
Clean light professional store. Sells ONLY two things:

1. **Social Accounts** — TikTok, YouTube, Instagram, Facebook
2. **Premium Accounts** — Canva Pro, CapCut Pro, Google One, Netflix, Spotify, ChatGPT Plus (admin can add more)

No courses, no services/SMM, no web development, nothing else is sold here.

## Firebase project (live)

- **Project ID: `tolifyhub-90375`** — Spark (free) plan, region `asia-south1`.
- **Auth ON:** Email/Password + Google.
- **Firestore ON:** production mode, rules in `firestore.rules`.
- **Cloud Storage OFF:** Storage is NOT set up. On new Firebase projects Storage needs the paid Blaze billing plan, and this project will never pay for it — so do NOT try to enable Storage.
- **Images are URL-paste instead:** the admin pastes an image link for every logo / banner / screenshot (`logoURL`, `imageURL`, `screenshots[]`), and users paste a link for their profile photo (`photoURL`). There is no file-upload code anywhere in this repo. The user panel already renders `logoURL` live from Firestore, including the store logo fixed at the top of the login/register page.

## UI v2 (locked design)

- Clean light professional store: background `#f4f6fb`, white cards, navy `#0f172a` + indigo `#4f46e5`, soft shadows, rounded 16px, gradient navy hero.
- Logo: navy square with white **T** + **TolifyHub** (Hub in indigo). On the login/register page the logo is fixed centred at the top; if the admin sets a logo in Settings (paste its image URL), that logo image is shown instead.
- **NO EMOJIS ANYWHERE** in the UI — buttons, cards, nav and the WhatsApp button use Font Awesome / inline SVG icons only. (Standing rule from Zaib, 2026-11-20.)
- **Real logos, real-time:** every Social/Premium product has a `logoURL` field in Firestore. The admin pastes the real brand logo link (TikTok, YouTube, Instagram, Facebook, Canva, CapCut, Google) and the user panel loads that `logoURL` live. Inline SVG brand marks are used **only as fallback** when `logoURL` is empty — never emoji.
- Buttons are solid navy pill buttons (`border-radius: 999px`, proper padding). Buy Now / Login / Browse Accounts are navy pills; icons are Font Awesome / SVG only.
- Home: gradient navy hero — "Real Accounts. Real Premium.", wallet pill top-right, Social Accounts in a 2-column card grid (price in indigo), Premium Accounts in a 3-column grid, floating green WhatsApp button bottom-right on every page, bottom nav: Home / Accounts / Premium / Orders / Profile.

## Files

| File | What it is |
|---|---|
| `index.php` | User panel — login/register, home, accounts, premium, wallet, orders, notifications, profile (DP = pasted photo URL) |
| `admin.php` | Admin panel — dashboard, users, funds, accounts, purchases, transactions, banners, notifications, settings (all images = pasted URLs) |
| `firebase.js` | Shared Firebase init (Auth + Firestore only), JS SDK 10.14.1 — live config for `tolifyhub-90375` already injected |
| `firestore.rules` | Firestore security rules — only TolifyHub collections |
| `storage.rules` | **NOT DEPLOYED** — Storage is not enabled on this project; kept in the repo only as a reference, do not publish it |
| `Dockerfile` | Railway deploy — `php:8.2-apache`, serves the repo on port 80 |
| `README.md` | This file |

## Stack

- **PHP** serves the pages (`index.php`, `admin.php`). PHP only renders the shell — all data/auth logic is client-side.
- **Firebase JS SDK 10.14.1** is the backend: Auth (email + Google) and Firestore. No Storage SDK, no Storage calls.
- **No ImgBB.** The old store embedded an ImgBB API key in code and it leaked. TolifyHub never uses ImgBB and never embeds an upload key — images are links the admin/user pastes.
- **No secrets in code.** `firebase.js` already contains the live web-app config for `tolifyhub-90375`. Do not replace it and do not copy it into any other file.

## Deploy — GitHub → Railway

1. Push this repo to GitHub: **`musa00-ctrl/tolifyhub`**.
2. In Railway, create a new project → **Deploy from GitHub repo** → pick `musa00-ctrl/tolifyhub`. Railway detects the `Dockerfile` and builds `php:8.2-apache`.
3. Railway gives the site a public domain (or add a custom domain in Railway → Settings → Domains). That URL is the live store. `index.php` is the store, `admin.php` is the admin panel. No build step, no environment variables needed.
4. Firestore rules: in the Firebase Console, **Firestore Database → Rules** → paste `firestore.rules` → Publish. (Skip Storage rules entirely — `storage.rules` is NOT deployed.)

## First admin (bootstrap)

There is no hardcoded admin email in the code. After creating your Firebase user (register on the site, or create it in Authentication):

- **Option A (recommended):** in Firestore, create document `admins/<your-uid>` with `{ active: true }`.
- **Option B:** in Firestore, create/set `settings/config` with field `adminEmail` = your email.

Then sign in at `admin.php`. The admin check (`isAdminUser` in `firebase.js`) accepts either method.

## Admin: first-run checklist (in the admin panel → Settings)

1. **Store logo** — paste its image link (Logo Image URL). It appears fixed at the top of the login/register page.
2. **WhatsApp number** — e.g. `923001234567` (country code, no `+`). Powers the floating WhatsApp support button on every page and the fund-request flow.
3. **Social links** — TikTok / Instagram / YouTube / Facebook URLs. Shown in the footer and the drawer.
4. **Admin email** — the email that may sign in to the admin panel (Option B above).
5. Add your first **Social Accounts** and **Premium Accounts** — each with its **real brand logo** (paste the logo image link), price, and login details (saved to `accountSecrets`, visible only to the buyer + admin).

## How buying works

- User tops up the wallet via **Add Fund** (Easypaisa / JazzCash / Bank Transfer / Other) → a `fundRequests` doc is created and the user is sent to WhatsApp with the payment proof → admin approves in **Add Funds** → balance is credited in a transaction (never by the user themself).
- **Buy Now** runs a Firestore transaction: balance check → debit wallet → mark the account `sold` → create `accountPurchases` (doc id = account id) → write a `walletTransactions` debit entry. If two people buy at once, only one wins.
- **Premium price is pro-rata:** `(days left / total days) × original price`, recalculated every minute.
- **My Orders → View Login Details** reads `accountSecrets/{accountId}` — rules allow this only for the buyer and admin.

## Firestore collections (the only ones TolifyHub uses)

`users`, `admins`, `settings`, `banners`, `socialAccounts`, `premiumAccounts`, `accountPurchases`, `premiumPurchases`, `walletTransactions`, `fundRequests`, `notifications`, `accountSecrets`.

Key rules (`firestore.rules`):

- Default deny; everything not listed is blocked.
- A user can never raise their own balance; only admin credit actions do.
- Purchase amounts are verified against the real product price in Firestore (social: exact price; premium: `0 < amount ≤ originalPrice` — exact pro-rata enforcement would need a Cloud Function, see the note in the rules file).
- `accountSecrets` are readable only by the admin and the user who bought that exact account.
- `settings/config` is **publicly readable on purpose** — it holds only public store info (logo URL, WhatsApp number, social links, store name) and must load on the login page **before** sign-in. Only admin can write it. It holds no secrets.

## Images — URL paste, no Storage

There is no Storage bucket and no upload path in this project:

- Store logo → admin pastes a link in Settings → saved as `settings/config.logoURL`.
- Product logo → admin pastes a link in the product form → saved as `logoURL`.
- Product screenshots → admin pastes one link per line → saved as `screenshots[]`.
- Banner → admin pastes a link → saved as `banners/{id}.imageURL`.
- Profile photo → user pastes a link in Change DP → saved as `users/{uid}.photoURL`. Empty = the initial-letter avatar (existing fallback, unchanged).

Any image host works (Imgur, Postimages, the brand's own CDN, etc.) as long as the link loads directly. Nothing is uploaded from the site.

## What was NOT done (needs a human / browser)

- Nothing deployed and nothing uploaded to GitHub yet — files + Dockerfile only, as requested. No Firebase console changes in this patch.
- Not live-tested against the real Firebase project yet. After deploy, test: register → add fund → approve → buy a test account → check login details appear only for the buyer. Also paste a logo URL in Settings and confirm it shows fixed at the top of the login page.
