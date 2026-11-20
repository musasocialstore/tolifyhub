<?php
// ============================================================================
//  TolifyHub — index.php  (User panel) — UI v5 (Musa shell + lilac idea colours)
//  Musa Social Store structure (topbar, hero, wallet card, platform tiles,
//  section headers, list rows, drawer, bottom nav) with the idea's soft
//  colours: lilac #f3f0ff, purple #6d5ae0, frosted white cards, radius 24px,
//  Plus Jakarta Sans, soft shadows. PKR only. The Reminder App image was
//  ONLY an idea for colour/layout — no reminder screens, no demo data.
//  TolifyHub branding — NOT Musa name, NO hero photo (navy gradient).
//  NO EMOJIS ANYWHERE — icons are Font Awesome / inline SVG only.
//  PHP serves the page; Firebase JS SDK 10.14.1 is the backend (firebase.js).
//  Sell ONLY: Social Accounts (TikTok, YouTube, Instagram, Facebook) and
//  Premium Accounts (Canva Pro, CapCut Pro, Google One, ...).
//  NO courses, NO services/SMM, NO web-dev — nothing else is sold here.
//  Product logos: REAL logoURL from Firestore (admin pastes the real brand
//  logo link as a URL). Inline SVG brand marks are FALLBACK ONLY
//  when logoURL is empty.
// ============================================================================
$STORE_NAME = 'TolifyHub';
$STORE_TAG  = 'Real Accounts. Real Premium.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo $STORE_NAME; ?> — <?php echo $STORE_TAG; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
/* ============ TOLIFYHUB v5 — MUSA SHELL, LILAC COLOURS ============
   Purple #6d5ae0, purple-dark #5a48d6, navy #221d4d / #312e81,
   blue #2563eb, bg-soft #f3f0ff, frosted white cards, Plus Jakarta Sans,
   radius 24px, soft shadows. Same shell as Musa Social Store,
   TolifyHub branding, NO hero photo — lilac gradient banner instead.
   NO EMOJIS ANYWHERE — Font Awesome / inline SVG icons only. */
:root{
  --royal:#6d5ae0; --royal-dark:#5a48d6; --navy:#221d4d; --navy-2:#312e81;
  --yellow:#8b7cf6; --yellow-2:#7c6cf0; --bg:#ffffff; --bg-soft:#f3f0ff;
  --text:#221d4d; --muted:#6b7a99; --border:#e4e9f2; --danger:#e53935; --success:#16a34a;
  --indigo:#6d5ae0; --indigo-dark:#5a48d6;
  --green:#25d366; --gold:#d97706;
  --shadow:0 8px 30px rgba(34,29,77,.08); --shadow-lg:0 20px 50px rgba(34,29,77,.14);
  --radius:18px; --radius-sm:12px;
}
*{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
html,body{height:100%}
body{font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:var(--bg-soft);color:var(--text);-webkit-font-smoothing:antialiased;overflow-x:hidden}
button{font-family:inherit;cursor:pointer;border:none;background:none;color:inherit}
input,textarea,select{font-family:inherit}
img{display:block;max-width:100%}
a{color:inherit;text-decoration:none}
.hidden{display:none !important}

/* ---- Logo mark: royal square, white "T" + TolifyHub (Hub in royal) ---- */
.logo-mark{display:inline-flex;align-items:center;gap:10px}
.logo-sq{width:40px;height:40px;border-radius:11px;background:linear-gradient(135deg,var(--royal),var(--royal-dark));color:#fff;font-weight:800;font-size:22px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 16px rgba(109,90,224,.3)}
.logo-word{font-weight:900;font-size:21px;letter-spacing:-.4px;color:var(--navy);white-space:nowrap}
.logo-word b{color:var(--royal);font-weight:900}

/* ============ AUTH (Musa style: navy gradient page, white card) ============ */
#authScreen{min-height:100vh;background:linear-gradient(160deg,#221d4d 0%,#4c3fd6 55%,#6d5ae0 100%);display:flex;align-items:center;justify-content:center;padding:24px 16px;position:relative;overflow:hidden}
#authScreen::before,#authScreen::after{content:"";position:absolute;border-radius:50%;background:radial-gradient(circle,rgba(255,193,7,.22),transparent 70%);width:420px;height:420px;filter:blur(10px)}
#authScreen::before{top:-160px;right:-120px}
#authScreen::after{bottom:-180px;left:-140px;background:radial-gradient(circle,rgba(255,255,255,.12),transparent 70%)}
.auth-card{width:100%;max-width:440px;background:#fff;border-radius:26px;padding:34px 26px 30px;box-shadow:var(--shadow-lg);position:relative;z-index:2;animation:fadeUp .5s ease}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
/* Logo FIXED centred at top (90px): settings logoURL if set, else royal-T mark */
.auth-logo{width:90px;height:90px;border-radius:20px;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;background:transparent}
.auth-logo .logo-sq{width:90px;height:90px;border-radius:20px;font-size:46px}
.auth-logo img.auth-logo-img{width:90px;height:90px;object-fit:contain;filter:drop-shadow(0 0 8px rgba(109,90,224,.4)) drop-shadow(0 0 16px rgba(255,193,7,.3));transition:filter .3s ease}
.auth-title{text-align:center;font-weight:800;font-size:22px;color:var(--navy)}
.auth-tag{text-align:center;color:var(--muted);font-size:13px;margin-top:4px;letter-spacing:.4px;font-weight:600}
.auth-tabs{display:flex;background:var(--bg-soft);border-radius:14px;padding:4px;margin:22px 0 18px}
.auth-tab{flex:1;padding:11px;border-radius:11px;font-weight:700;font-size:14px;color:var(--muted);transition:.2s}
.auth-tab.active{background:#fff;color:var(--royal);box-shadow:0 4px 14px rgba(34,29,77,.08)}
.field{margin-bottom:14px}
.field label{display:block;font-size:12.5px;font-weight:700;color:var(--navy);margin-bottom:7px}
.input-wrap{position:relative}
.input-wrap i.lead{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:14px}
.input-wrap input,.input-wrap textarea,.input-wrap select{width:100%;padding:14px 44px 14px 42px;border:1.6px solid var(--border);border-radius:14px;font-size:14.5px;background:#fbfcff;color:var(--text);transition:.18s;font-weight:500;outline:none}
.input-wrap textarea{padding-left:42px;min-height:92px;resize:vertical}
.input-wrap.no-icon input,.input-wrap.no-icon textarea,.input-wrap.no-icon select{padding-left:15px}
.input-wrap input:focus,.input-wrap textarea:focus,.input-wrap select:focus{border-color:var(--royal);background:#fff;box-shadow:0 0 0 4px rgba(109,90,224,.1)}
.toggle-pass{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:15px;padding:6px}
.row-between{display:flex;align-items:center;justify-content:space-between;gap:8px;margin:2px 0 16px}
.checkbox{display:flex;align-items:center;gap:7px;font-size:13px;color:var(--muted);font-weight:600;cursor:pointer}
.checkbox input{width:16px;height:16px;accent-color:var(--royal)}
.link{color:var(--royal);font-weight:700;font-size:13px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 18px;border-radius:14px;font-weight:800;font-size:14.5px;transition:.18s;width:100%}
.btn-primary{background:linear-gradient(135deg,var(--royal),var(--royal-dark));color:#fff;box-shadow:0 8px 20px rgba(109,90,224,.32)}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 12px 26px rgba(109,90,224,.4)}
.btn-navy{background:linear-gradient(135deg,var(--royal),var(--royal-dark));color:#fff;box-shadow:0 8px 20px rgba(109,90,224,.32)}
.btn-navy:hover{transform:translateY(-1px);box-shadow:0 12px 26px rgba(109,90,224,.4)}
.btn-indigo{background:var(--royal);color:#fff}
.btn-yellow{background:linear-gradient(135deg,var(--yellow),var(--yellow-2));color:var(--navy);box-shadow:0 8px 20px rgba(255,193,7,.4)}
.btn-outline{background:#fff;border:1.6px solid var(--border);color:var(--navy)}
.btn-ghost{background:var(--bg-soft);color:var(--navy)}
.btn-google{background:#fff;border:1.6px solid var(--border);color:var(--navy);font-weight:700}
.divider{display:flex;align-items:center;gap:12px;color:var(--muted);font-size:12px;font-weight:700;margin:18px 0}
.divider::before,.divider::after{content:"";flex:1;height:1px;background:var(--border)}
.err-msg{color:var(--danger);font-size:12.5px;font-weight:600;margin-top:8px;text-align:center;min-height:16px}
.btn:disabled{opacity:.6;cursor:not-allowed;transform:none !important}

/* ============ APP SHELL (Musa style) ============ */
#app{display:none;min-height:100vh;padding-bottom:78px;background:var(--bg-soft)}
#app.visible{display:block}
.topbar{position:sticky;top:0;z-index:40;background:#fff;padding:12px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--border);box-shadow:0 2px 12px rgba(34,29,77,.04)}
.icon-btn{width:42px;height:42px;border-radius:13px;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:16px;transition:.15s;position:relative;flex-shrink:0}
.icon-btn:active{transform:scale(.94)}
.brand{display:flex;flex-direction:column;flex:1;min-width:0}
.brand-name{font-weight:900;font-size:15px;color:var(--navy);letter-spacing:-.2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.brand-tag{font-size:10.5px;color:var(--muted);font-weight:700;letter-spacing:.6px;text-transform:uppercase}
.wallet-pill{display:flex;align-items:center;gap:7px;background:var(--royal);color:#fff;font-weight:800;font-size:13px;padding:9px 13px;border-radius:999px;white-space:nowrap;box-shadow:0 6px 16px rgba(109,90,224,.3)}
.wallet-pill i{font-size:13px}
.badge-dot{position:absolute;top:6px;right:6px;min-width:17px;height:17px;padding:0 4px;border-radius:20px;background:var(--danger);color:#fff;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;border:2px solid #fff}
.avatar{width:42px;height:42px;border-radius:50%;object-fit:cover;background:var(--royal);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:15px;border:2px solid var(--border);flex-shrink:0;overflow:hidden}
.avatar img{width:100%;height:100%;object-fit:cover}
#profileBtn{position:relative}
#profileBtn::after{content:"";position:absolute;bottom:1px;right:1px;width:11px;height:11px;border-radius:50%;background:#22c55e;border:2px solid #fff;z-index:2}

/* Hero banner — navy gradient, crown, yellow Explore button (NO photo) */
.hero{margin:16px 16px 4px;border-radius:var(--radius);padding:26px 20px;background:linear-gradient(135deg,#221d4d 0%,#4c3fd6 55%,#6d5ae0 100%);color:#fff;position:relative;overflow:hidden;box-shadow:0 16px 34px rgba(34,29,77,.28)}
.hero::after{content:"";position:absolute;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(255,193,7,.35),transparent 65%);top:-90px;right:-60px}
.hero-crown{position:relative;z-index:2;margin-bottom:6px}
.hero h1{font-size:24px;font-weight:900;letter-spacing:-.5px;position:relative;z-index:2;line-height:1.2}
.hero h1 .hy{color:var(--yellow)}
.hero p{font-size:13px;opacity:.85;margin-top:8px;position:relative;z-index:2;font-weight:500;line-height:1.55}
.hero .hero-cta{margin-top:16px;display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--yellow),var(--yellow-2));color:var(--navy);font-weight:800;font-size:13.5px;padding:11px 18px;border-radius:12px;position:relative;z-index:2;box-shadow:0 8px 18px rgba(255,193,7,.35)}

/* Banner slider (admin banners) */
.banner-wrap{margin:16px 16px 4px;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);position:relative;background:var(--navy);min-height:170px}
.banner-track{display:flex;transition:transform .45s cubic-bezier(.4,0,.2,1)}
.banner-slide{min-width:100%;position:relative;min-height:170px;cursor:pointer}
.banner-slide img{width:100%;height:190px;object-fit:cover;display:block}
.banner-dots{position:absolute;bottom:12px;left:0;right:0;display:flex;gap:6px;justify-content:center;z-index:3}
.banner-dots .dot{width:7px;height:7px;border-radius:20px;background:rgba(255,255,255,.5);transition:.2s}
.banner-dots .dot.active{background:#fff;width:20px}

/* Wallet card (Musa style) */
.wallet-card{margin:16px 16px 0;background:linear-gradient(135deg,var(--navy) 0%,var(--royal) 100%);border-radius:var(--radius);padding:22px;color:#fff;position:relative;overflow:hidden;box-shadow:0 16px 34px rgba(34,29,77,.28)}
.wallet-card::after{content:"";position:absolute;width:220px;height:220px;border-radius:50%;background:rgba(255,193,7,.16);top:-100px;right:-80px}
.wallet-card::before{content:"";position:absolute;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,.06);bottom:-70px;left:-40px}
.wallet-card .wlabel{font-size:12.5px;font-weight:700;opacity:.8;letter-spacing:.5px;text-transform:uppercase;position:relative;z-index:2}
.wallet-card .wamount{font-size:32px;font-weight:900;margin:6px 0 2px;letter-spacing:-1px;position:relative;z-index:2}
.wallet-card .wsub{font-size:12px;opacity:.75;position:relative;z-index:2}
.wallet-card .add-fund{margin-top:16px;background:var(--yellow);color:var(--navy);padding:11px 18px;border-radius:12px;font-weight:800;font-size:13.5px;display:inline-flex;align-items:center;gap:8px;position:relative;z-index:2;box-shadow:0 8px 18px rgba(255,193,7,.35)}

/* Section header */
.sec-head{display:flex;align-items:center;justify-content:space-between;padding:22px 16px 12px}
.sec-head h3{font-size:17px;font-weight:900;color:var(--navy);letter-spacing:-.3px}
.sec-head h3 i{color:var(--royal);margin-right:7px}
.sec-head .see{font-size:12.5px;font-weight:800;color:var(--royal);cursor:pointer}

/* Quick platform tiles (Musa social buttons) */
.chips{display:flex;gap:8px;padding:2px 16px 6px;overflow-x:auto}
.chips::-webkit-scrollbar{display:none}
.tiles{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;padding:4px 16px 8px}
.chip{padding:9px 15px;border-radius:999px;background:#fff;border:1.6px solid var(--border);font-weight:700;font-size:12.5px;color:var(--navy);white-space:nowrap}
.chip.active{background:var(--royal);color:#fff;border-color:var(--royal)}
.tile{display:flex;flex-direction:column;align-items:center;gap:7px;padding:13px 4px 11px;background:#fff;border:1.6px solid transparent;border-radius:16px;box-shadow:var(--shadow);font-size:10.5px;font-weight:800;color:var(--navy);cursor:pointer;transition:.15s;text-align:center;line-height:1.2}
.tile:hover{border-color:var(--royal);transform:translateY(-2px)}
.tile.active{border-color:var(--royal);box-shadow:0 0 0 3px rgba(109,90,224,.14)}
.tile-ico{width:38px;height:38px;border-radius:10px;overflow:hidden;display:flex;align-items:center;justify-content:center;font-size:17px;color:#fff;flex-shrink:0}
.tile-ico svg{width:100%;height:100%;display:block}

/* Product LIST ROWS (Musa mockup style: logo + name + detail, blue price pill + Buy) */
.acc-list{display:flex;flex-direction:column;gap:10px;padding:4px 16px 8px}
.grid-2,.grid-3{display:flex;flex-direction:column;gap:10px;padding:4px 16px 8px}
.acc-row{display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:16px;padding:12px 14px;box-shadow:var(--shadow);cursor:pointer;transition:.15s}
.acc-row:hover{border-color:var(--royal);transform:translateY(-1px)}
.acc-row .p-ico{width:52px;height:52px;border-radius:13px;flex-shrink:0;overflow:hidden;background:var(--bg-soft);display:flex;align-items:center;justify-content:center}
.acc-row .p-ico img{width:100%;height:100%;object-fit:contain}
.acc-row .p-ico svg{width:100%;height:100%;display:block}
.acc-info{flex:1;min-width:0}
.acc-info .p-name{font-weight:800;font-size:14px;color:var(--navy);display:flex;align-items:center;gap:5px}
.acc-info .p-name i{color:var(--royal);font-size:13px}
.acc-info .p-sub{font-size:11.5px;color:var(--muted);font-weight:600;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.acc-side{display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0}
.p-price-pill{background:var(--royal);color:#fff;font-weight:800;font-size:12.5px;padding:7px 12px;border-radius:999px;white-space:nowrap}
.p-buy-sm{background:linear-gradient(135deg,var(--yellow),var(--yellow-2));color:var(--navy);font-weight:800;font-size:11px;padding:6px 12px;border-radius:999px}
.p-ico{width:52px;height:52px;border-radius:13px;flex-shrink:0;overflow:hidden;background:var(--bg-soft);display:flex;align-items:center;justify-content:center}
.p-ico img{width:100%;height:100%;object-fit:contain}
.p-ico svg{width:100%;height:100%;display:block}
.p-name{font-weight:800;font-size:14px;color:var(--navy)}
.p-sub{font-size:11.5px;color:var(--muted);font-weight:600}

/* Rows, sheets, modal */
.row-item{background:#fff;border:1px solid var(--border);border-radius:15px;padding:14px;margin-bottom:11px;box-shadow:var(--shadow)}
.row-item .ri-top{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:6px}
.row-item .ri-title{font-weight:800;font-size:13.5px;line-height:1.3;color:var(--navy)}
.row-item .ri-sub{font-size:11.5px;color:var(--muted);font-weight:600;margin-bottom:6px}
.row-item .ri-amt{font-weight:800;font-size:14px;white-space:nowrap;color:var(--royal)}
.row-item .ri-amt.debit{color:var(--danger)}
.row-item .ri-amt.credit{color:#16a34a}
.ri-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:10.5px;font-weight:800;margin-top:4px}
.badge-pending{background:#fef3c7;color:#92400e}
.badge-approved,.badge-completed{background:#e9e5ff;color:var(--royal)}
.badge-rejected{background:#fee2e2;color:#991b1b}
.modal{position:fixed;inset:0;background:rgba(34,29,77,.55);z-index:90;display:none;align-items:flex-end;justify-content:center;backdrop-filter:blur(3px)}
.modal.show{display:flex}
@media(min-width:640px){.modal{align-items:center}}
.sheet{background:#fff;width:100%;max-width:520px;border-radius:24px 24px 0 0;max-height:88vh;overflow-y:auto}
@media(min-width:640px){.sheet{border-radius:24px;max-height:82vh}}
.sheet-head{padding:18px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:#fff;z-index:3}
.sheet-head h3{font-size:16.5px;font-weight:800;color:var(--navy)}
.sheet-close{width:34px;height:34px;border-radius:11px;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;font-size:15px}
.sheet-body{padding:18px 20px 26px}
.form-group{margin-bottom:14px}
.form-group label{display:block;font-size:12.5px;font-weight:700;margin-bottom:7px;color:var(--navy)}
.form-group input,.form-group textarea,.form-group select{width:100%;padding:13px 14px;border:1.6px solid var(--border);border-radius:12px;font-size:14px;background:#fbfcff;color:var(--text);outline:none;font-weight:500}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:var(--royal);box-shadow:0 0 0 3px rgba(109,90,224,.1)}
.form-group textarea{min-height:88px;resize:vertical}
.cred-row{display:flex;align-items:center;gap:8px;background:var(--bg-soft);border:1px solid var(--border);border-radius:12px;padding:11px 12px;margin-bottom:10px;font-size:13px;word-break:break-all}
.cred-row b{display:block;font-size:10.5px;color:var(--muted);text-transform:uppercase}
.cred-row button{margin-left:auto;color:var(--royal);font-size:15px;padding:4px 8px}
.detail-price{font-weight:900;font-size:24px;color:var(--royal);margin-bottom:16px}
.detail-desc{font-size:13.5px;line-height:1.65;color:var(--text);margin-bottom:14px}
.empty{text-align:center;padding:40px 20px;color:var(--muted)}
.empty i{font-size:38px;color:var(--border);margin-bottom:12px;display:block}
.empty p{font-size:13.5px;font-weight:600}
.toast{position:fixed;bottom:100px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--navy);color:#fff;padding:12px 20px;border-radius:13px;font-weight:700;font-size:13px;z-index:200;opacity:0;pointer-events:none;transition:.25s;box-shadow:var(--shadow-lg);max-width:90vw;text-align:center}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}
.toast.success{background:#16a34a}
.toast.error{background:var(--danger)}
.loader{display:inline-block;width:16px;height:16px;border:2.5px solid rgba(255,255,255,.35);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}
.loader.dark{border-color:rgba(109,90,224,.25);border-top-color:var(--royal)}
@keyframes spin{to{transform:rotate(360deg)}}

/* Drawer (Musa style) */
.overlay{position:fixed;inset:0;background:rgba(34,29,77,.55);z-index:60;opacity:0;pointer-events:none;transition:.25s;backdrop-filter:blur(2px)}
.overlay.show{opacity:1;pointer-events:auto}
.drawer{position:fixed;top:0;left:0;height:100%;width:295px;max-width:86vw;background:#fff;z-index:70;transform:translateX(-100%);transition:.3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;overflow-y:auto;box-shadow:12px 0 40px rgba(34,29,77,.2)}
.drawer.show{transform:none}
.drawer-head{padding:22px 18px;background:linear-gradient(135deg,var(--navy),var(--royal));color:#fff;display:flex;flex-direction:column;gap:10px}
.drawer-head .avatar{width:60px;height:60px;font-size:22px;border-color:rgba(255,255,255,.4)}
.drawer-head .dn{font-weight:800;font-size:16px}
.drawer-head .de{font-size:12px;opacity:.85;word-break:break-all}
.drawer-head .dw{font-size:12px;font-weight:700;margin-top:4px;background:rgba(255,255,255,.15);padding:5px 10px;border-radius:20px;align-self:flex-start}
.drawer-nav{padding:12px 10px;flex:1}
.drawer-item{display:flex;align-items:center;gap:13px;padding:13px 14px;border-radius:13px;font-weight:700;font-size:14px;color:var(--navy);transition:.15s;cursor:pointer}
.drawer-item i{width:22px;text-align:center;color:var(--royal);font-size:15px}
.drawer-item:hover,.drawer-item.active{background:var(--bg-soft);color:var(--royal)}
.drawer-item.danger{color:var(--danger);background:#fde8e8}
.drawer-item.danger i{color:var(--danger)}
.drawer-item .pill{margin-left:auto;background:var(--danger);color:#fff;font-size:10px;font-weight:800;padding:2px 8px;border-radius:20px}
.drawer-social{padding:14px 18px;border-top:1px solid var(--border)}
.drawer-social .ds-title{font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:10px}
.ds-icons{display:flex;gap:10px}
.ds-icons a{width:40px;height:40px;border-radius:12px;background:var(--bg-soft);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:17px;color:var(--navy)}
.ds-icons a:hover{border-color:var(--royal);color:var(--royal)}
.drawer-promo{margin:12px 14px 18px;border-radius:var(--radius);padding:18px;background:linear-gradient(135deg,#221d4d,#6d5ae0);color:#fff;position:relative;overflow:hidden}
.drawer-promo::after{content:"";position:absolute;width:130px;height:130px;border-radius:50%;background:radial-gradient(circle,rgba(255,193,7,.4),transparent 65%);top:-50px;right:-40px}
.dp-title{font-weight:900;font-size:16px;position:relative;z-index:2}
.dp-title span{color:var(--yellow)}
.dp-sub{font-size:11.5px;opacity:.85;margin:5px 0 12px;position:relative;z-index:2;line-height:1.5}
.dp-btn{background:linear-gradient(135deg,var(--yellow),var(--yellow-2));color:var(--navy);font-weight:800;font-size:12.5px;padding:10px 16px;border-radius:999px;position:relative;z-index:2;display:inline-flex;align-items:center;gap:7px}

/* Bottom nav */
.bottom-nav{position:fixed;bottom:0;left:0;right:0;background:#fff;border-top:1px solid var(--border);display:flex;padding:8px 6px 12px;z-index:50;max-width:640px;margin:0 auto}
.bottom-nav .bn-item{flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;padding:6px 4px;border-radius:12px;color:var(--muted);font-size:10px;font-weight:700;cursor:pointer}
.bottom-nav .bn-item i{font-size:18px}
.bottom-nav .bn-item.active{color:var(--royal)}
.bottom-nav .bn-item.active::after{content:"";width:22px;height:3px;border-radius:3px;background:var(--royal);margin-top:1px}

/* Floating WhatsApp button — every page (SVG/Font Awesome icon only, never emoji) */
.wa-float{position:fixed;right:16px;bottom:86px;width:56px;height:56px;border-radius:50%;background:#25d366;color:#fff;display:flex;align-items:center;justify-content:center;font-size:28px;z-index:55;box-shadow:0 10px 24px rgba(37,211,102,.45)}
.wa-float:hover{transform:scale(1.06)}

/* Profile + notifs */
.page-view{padding:16px}
.page-view h2{font-size:20px;font-weight:800;margin-bottom:14px;color:var(--navy)}
.profile-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:22px;text-align:center;margin-bottom:16px;box-shadow:var(--shadow)}
.profile-card .avatar{width:84px;height:84px;font-size:32px;margin:0 auto 12px}
.profile-card .pn{font-weight:800;font-size:18px;color:var(--navy)}
.profile-card .pe{font-size:13px;color:var(--muted);margin-top:3px;word-break:break-all}
.profile-card .pid{font-size:11px;color:var(--muted);margin-top:6px;font-family:monospace;background:var(--bg-soft);padding:4px 10px;border-radius:20px;display:inline-block}
.profile-actions{display:flex;gap:8px;margin-top:16px}
.profile-actions .btn{flex:1;padding:11px;font-size:13px}
.notif-item{background:#fff;border:1px solid var(--border);border-radius:14px;padding:14px;margin-bottom:10px;display:flex;gap:12px;box-shadow:var(--shadow)}
.notif-item.unread{border-color:var(--royal)}
.notif-item .ni-icon{width:38px;height:38px;border-radius:11px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:15px;background:#e9e5ff;color:var(--royal)}
.notif-item .ni-title{font-weight:800;font-size:13.5px;margin-bottom:3px;color:var(--navy)}
.notif-item .ni-body{font-size:12.5px;color:var(--muted);line-height:1.5}
.notif-item .ni-time{font-size:10.5px;color:var(--muted);margin-top:6px;font-weight:600}
.chip-amt{padding:9px 16px;border-radius:11px;background:#fff;border:1.5px solid var(--border);font-weight:800;font-size:12.5px;color:var(--navy)}
.chip-amt.active{background:#e9e5ff;color:var(--royal);border-color:var(--royal)}
.pm-grid{display:grid;grid-template-columns:1fr 1fr;gap:9px;margin-bottom:14px}
.pm-btn{padding:14px;border-radius:13px;border:1.6px solid var(--border);background:#fff;font-weight:800;font-size:13px;color:var(--navy);display:flex;flex-direction:column;align-items:center;gap:6px}
.pm-btn i{font-size:18px;color:var(--royal)}
.pm-btn.active{border-color:var(--royal);background:#efecff}
footer.site-foot{padding:26px 20px 10px;text-align:center;color:var(--muted);font-size:12px;font-weight:600}
footer.site-foot .ds-icons{justify-content:center;margin-bottom:12px}
@media(max-width:380px){.hero h1{font-size:21px}.tiles{grid-template-columns:repeat(5,1fr);gap:7px}.tile{font-size:9.5px}}

/* ============ TOLIFYHUB v5 — LILAC GLASS (Musa shell + idea colours, PKR) ============ */
body{background:#f3f0ff;background-image:radial-gradient(640px 420px at 8% -4%,rgba(109,90,224,.20),transparent 62%),radial-gradient(560px 420px at 96% 12%,rgba(37,99,235,.16),transparent 60%),radial-gradient(560px 520px at 50% 108%,rgba(236,72,153,.10),transparent 62%);background-attachment:fixed}
#app{background:transparent}
.topbar{background:rgba(255,255,255,.82);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,.7);border-radius:0 0 24px 24px;box-shadow:0 8px 30px rgba(109,90,224,.10)}
.icon-btn{background:#efecff;color:#221d4d}
.brand-name{color:#221d4d}
.wallet-pill{background:linear-gradient(135deg,#6d5ae0,#5a48d6);box-shadow:0 8px 18px rgba(109,90,224,.35)}
.avatar{background:linear-gradient(135deg,#6d5ae0,#2563eb)}
#authScreen{background:linear-gradient(160deg,#ede9fe 0%,#ddd6fe 50%,#c7d2fe 100%)}
#authScreen::before{background:radial-gradient(circle,rgba(109,90,224,.28),transparent 70%)}
#authScreen::after{background:radial-gradient(circle,rgba(37,99,235,.18),transparent 70%)}
.auth-card{background:rgba(255,255,255,.88);backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,.75);border-radius:28px}
.auth-tab.active{color:#6d5ae0;box-shadow:0 4px 14px rgba(109,90,224,.12)}
.btn-navy,.btn-primary{background:linear-gradient(135deg,#6d5ae0,#5a48d6);box-shadow:0 10px 24px rgba(109,90,224,.35)}
.btn-yellow{background:linear-gradient(135deg,#6d5ae0,#5a48d6);color:#fff;box-shadow:0 10px 24px rgba(109,90,224,.35)}
.link{color:#6d5ae0}
.input-wrap input:focus{border-color:#6d5ae0;box-shadow:0 0 0 4px rgba(109,90,224,.12)}
.hero{background:linear-gradient(135deg,#ffffff 0%,#ede9fe 60%,#dbeafe 100%);color:#221d4d;box-shadow:0 16px 34px rgba(109,90,224,.14)}
.hero::after{background:radial-gradient(circle,rgba(109,90,224,.22),transparent 65%)}
.hero h1{color:#221d4d}
.hero h1 .hy{color:#6d5ae0}
.hero p{color:#55517a;opacity:1}
.hero .hero-cta{background:linear-gradient(135deg,#6d5ae0,#5a48d6);color:#fff;box-shadow:0 8px 18px rgba(109,90,224,.35)}
.wallet-card{background:linear-gradient(135deg,#6d5ae0 0%,#4c3fd6 100%);color:#fff;box-shadow:0 16px 34px rgba(109,90,224,.35);border-radius:24px;border:none}
.wallet-card::before,.wallet-card::after{display:none}
.wallet-card .wlabel{color:rgba(255,255,255,.85)}
.wallet-card .wamount{color:#fff}
.wallet-card .wsub{color:rgba(255,255,255,.8)}
.wallet-card .add-fund{background:#fff;color:#5a48d6;box-shadow:0 8px 18px rgba(0,0,0,.2)}
.acc-row,.row-item,.notif-item,.profile-card{background:rgba(255,255,255,.88);backdrop-filter:blur(14px);border:1px solid rgba(255,255,255,.75);border-radius:24px;box-shadow:0 10px 26px rgba(109,90,224,.10)}
.acc-row .p-ico{border-radius:16px;box-shadow:0 6px 14px rgba(109,90,224,.12)}
.p-price-pill{background:#2563eb;box-shadow:0 6px 14px rgba(37,99,235,.3)}
.p-buy-sm{background:linear-gradient(135deg,#6d5ae0,#5a48d6);color:#fff}
.sec-head h3{color:#221d4d}
.sec-head h3 i{color:#6d5ae0}
.sec-head .see{color:#6d5ae0}
.tile{background:rgba(255,255,255,.88);border:1px solid rgba(255,255,255,.75);border-radius:18px;box-shadow:0 8px 20px rgba(109,90,224,.10)}
.tile.active{border-color:#6d5ae0;box-shadow:0 0 0 3px rgba(109,90,224,.14)}
.chip{background:rgba(255,255,255,.88);border:1.6px solid rgba(255,255,255,.75)}
.chip.active{background:#6d5ae0;border-color:#6d5ae0}
.banner-wrap{border-radius:24px}
.bottom-nav{background:rgba(255,255,255,.88);backdrop-filter:blur(18px);border-top:1px solid rgba(255,255,255,.7);border-radius:24px 24px 0 0;box-shadow:0 -8px 30px rgba(109,90,224,.10);padding:10px 10px 14px}
.bottom-nav .bn-item{color:#8b87b3}
.bottom-nav .bn-item.active{color:#6d5ae0}
.bottom-nav .bn-item.active::after{background:#6d5ae0}
.drawer{background:rgba(255,255,255,.94);backdrop-filter:blur(18px);border-radius:0 28px 28px 0}
.drawer-head{background:linear-gradient(135deg,#6d5ae0,#4c3fd6)}
.drawer-item{color:#221d4d}
.drawer-item i{color:#6d5ae0}
.drawer-item:hover,.drawer-item.active{background:#efecff;color:#6d5ae0}
.drawer-promo{background:linear-gradient(135deg,#221d4d,#4c3fd6)}
.dp-title span{color:#a78bfa}
.dp-btn{background:linear-gradient(135deg,#f59e0b,#f97316);color:#fff}
.sheet{background:rgba(255,255,255,.96);backdrop-filter:blur(18px);border-radius:28px 28px 0 0}
.modal{background:rgba(34,29,77,.45)}
</style>
</head>
<body>

<!-- ============ AUTH SCREEN ============ -->
<div id="authScreen">
  <div class="auth-card">
    <!-- Logo FIXED centred at top (90px): settings logoURL if set, else royal-T mark -->
    <div class="auth-logo" id="authLogoWrap">
      <span class="logo-sq">T</span>
    </div>
    <div class="auth-title">TolifyHub</div>
    <div class="auth-tag">Real Accounts. Real Premium.</div>

    <div class="auth-tabs">
      <button class="auth-tab active" data-auth="login">Login</button>
      <button class="auth-tab" data-auth="register">Register</button>
    </div>

    <form id="loginForm">
      <div class="field">
        <label>Email Address</label>
        <div class="input-wrap">
          <i class="fa-solid fa-envelope lead"></i>
          <input type="email" id="loginEmail" placeholder="you@example.com" required autocomplete="email">
        </div>
      </div>
      <div class="field">
        <label>Password</label>
        <div class="input-wrap">
          <i class="fa-solid fa-lock lead"></i>
          <input type="password" id="loginPassword" placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="toggle-pass" data-target="loginPassword"><i class="fa-solid fa-eye"></i></button>
        </div>
      </div>
      <div class="row-between">
        <label class="checkbox"><input type="checkbox" id="rememberMe"> Remember Me</label>
        <a href="#" class="link" id="forgotLink">Forgot Password?</a>
      </div>
      <button type="submit" class="btn btn-navy" id="loginBtn"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
      <div class="divider">OR</div>
      <button type="button" class="btn btn-google" id="googleLoginBtn">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="18" height="18" alt=""> Continue with Google
      </button>
      <div class="err-msg" id="loginErr"></div>
    </form>

    <form id="registerForm" class="hidden">
      <div class="field">
        <label>Username</label>
        <div class="input-wrap">
          <i class="fa-solid fa-user lead"></i>
          <input type="text" id="regUsername" placeholder="Choose a username" required autocomplete="username">
        </div>
      </div>
      <div class="field">
        <label>Email Address</label>
        <div class="input-wrap">
          <i class="fa-solid fa-envelope lead"></i>
          <input type="email" id="regEmail" placeholder="you@example.com" required autocomplete="email">
        </div>
      </div>
      <div class="field">
        <label>Password</label>
        <div class="input-wrap">
          <i class="fa-solid fa-lock lead"></i>
          <input type="password" id="regPassword" placeholder="Min 6 characters" required minlength="6" autocomplete="new-password">
          <button type="button" class="toggle-pass" data-target="regPassword"><i class="fa-solid fa-eye"></i></button>
        </div>
      </div>
      <div class="field">
        <label>Confirm Password</label>
        <div class="input-wrap">
          <i class="fa-solid fa-lock lead"></i>
          <input type="password" id="regConfirm" placeholder="Re-enter password" required minlength="6" autocomplete="new-password">
          <button type="button" class="toggle-pass" data-target="regConfirm"><i class="fa-solid fa-eye"></i></button>
        </div>
      </div>
      <button type="submit" class="btn btn-navy" id="registerBtn"><i class="fa-solid fa-user-plus"></i> Register Now</button>
      <div class="divider">OR</div>
      <button type="button" class="btn btn-google" id="googleRegisterBtn">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="18" height="18" alt=""> Continue with Google
      </button>
      <div class="err-msg" id="registerErr"></div>
    </form>
  </div>
</div>

<!-- ============ APP ============ -->
<div id="app">
  <div class="topbar">
    <button class="icon-btn" id="burgerBtn"><i class="fa-solid fa-bars"></i></button>
    <div class="brand"><span class="brand-name">TolifyHub</span><span class="brand-tag">Real Accounts. Real Premium.</span></div>
    <button class="wallet-pill" id="walletPillTop"><i class="fa-solid fa-wallet"></i><span id="walletTopAmt">Rs. 0</span></button>
    <button class="icon-btn" id="notifBtn">
      <i class="fa-regular fa-bell"></i>
      <span class="badge-dot hidden" id="notifBadge">0</span>
    </button>
    <button class="icon-btn" id="profileBtn" style="padding:0;background:transparent;border:none">
      <div class="avatar" id="topAvatar">U</div>
    </button>
  </div>

  <!-- HOME VIEW -->
  <div id="homeView">
    <div class="banner-wrap hidden" id="bannerWrap">
      <div class="banner-track" id="bannerTrack"></div>
      <div class="banner-dots" id="bannerDots"></div>
    </div>

    <div class="hero">
      <div class="hero-crown"><svg width="34" height="26" viewBox="0 0 34 26" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="crown"><path d="M2 23 L0 6 L9 12 L17 2 L25 12 L34 6 L32 23 Z" fill="#8b7cf6" stroke="#7c6cf0" stroke-width="1.4" stroke-linejoin="round"/></svg></div>
      <h1><span class="hy">TolifyHub</span><br>Real Accounts. Real Premium.</h1>
      <p>Trusted TikTok, YouTube, Instagram &amp; Facebook accounts — plus Canva Pro, CapCut Pro &amp; Google One.</p>
      <button class="hero-cta" id="heroShopBtn">Explore Now <i class="fa-solid fa-arrow-right"></i></button>
    </div>

    <div class="wallet-card">
      <div class="wlabel">My Wallet Balance</div>
      <div class="wamount" id="walletAmount">Rs. 0</div>
      <div class="wsub">Top up anytime — instant delivery on every account</div>
      <button class="add-fund" id="addFundBtn"><i class="fa-solid fa-plus"></i> Add Fund</button>
    </div>

    <div class="tiles" id="platformChips">
      <button class="chip tile active" data-plat="all"><span class="tile-ico" style="background:var(--royal)"><i class="fa-solid fa-border-all"></i></span>All</button>
      <button class="chip tile" data-plat="tiktok"><span class="tile-ico"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="10" fill="#000000"/><ellipse cx="19" cy="34" rx="5" ry="4" fill="#ffffff" transform="rotate(-15 19 34)"/><rect x="23.4" y="11" width="2.6" height="23" fill="#ffffff"/><path d="M26 11c4.5 1 7 3.5 7.5 8.5-2.5-.5-4.5-2-5.5-4.5" fill="none" stroke="#ffffff" stroke-width="2.6" stroke-linecap="round"/></svg></span>TikTok</button>
      <button class="chip tile" data-plat="youtube"><span class="tile-ico"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="10" fill="#FF0000"/><polygon points="20,15 33,24 20,33" fill="#ffffff"/></svg></span>YouTube</button>
      <button class="chip tile" data-plat="instagram"><span class="tile-ico"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="igTileGrad" x1="0" y1="1" x2="1" y2="0"><stop offset="0" stop-color="#f09433"/><stop offset=".5" stop-color="#dc2743"/><stop offset="1" stop-color="#bc1888"/></linearGradient></defs><rect width="48" height="48" rx="10" fill="url(#igTileGrad)"/><rect x="12" y="12" width="24" height="24" rx="8" fill="none" stroke="#ffffff" stroke-width="2.6"/><circle cx="24" cy="24" r="6" fill="none" stroke="#ffffff" stroke-width="2.6"/><circle cx="31.5" cy="16.5" r="1.8" fill="#ffffff"/></svg></span>Instagram</button>
      <button class="chip tile" data-plat="facebook"><span class="tile-ico"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="10" fill="#1877F2"/><text x="24" y="33" text-anchor="middle" font-family="Arial, sans-serif" font-size="28" font-weight="800" fill="#ffffff">f</text></svg></span>Facebook</button>
    </div>

    <div class="sec-head"><h3><i class="fa-solid fa-users"></i>Social Accounts</h3><span class="see" id="seeSocial">View All <i class="fa-solid fa-arrow-right"></i></span></div>
    <div class="acc-list" id="socialGrid"></div>

    <div class="sec-head"><h3><i class="fa-solid fa-crown"></i>Premium Accounts</h3><span class="see" id="seePremium">View All <i class="fa-solid fa-arrow-right"></i></span></div>
    <div class="acc-list" id="premiumGrid"></div>
  </div>

  <!-- CONTENT VIEW -->
  <div id="contentView" class="hidden"></div>

  <footer class="site-foot" id="siteFoot"></footer>

  <div class="bottom-nav">
    <div class="bn-item active" data-nav="home"><i class="fa-solid fa-house"></i><span>Home</span></div>
    <div class="bn-item" data-nav="accounts"><i class="fa-solid fa-user-tag"></i><span>Accounts</span></div>
    <div class="bn-item" data-nav="premium"><i class="fa-solid fa-crown"></i><span>Premium</span></div>
    <div class="bn-item" data-nav="wallet"><i class="fa-solid fa-wallet"></i><span>Wallet</span></div>
    <div class="bn-item" data-nav="profile"><i class="fa-solid fa-user"></i><span>Profile</span></div>
  </div>
</div>

<!-- DRAWER -->
<div class="overlay" id="overlay"></div>
<div class="drawer" id="drawer">
  <div class="drawer-head">
    <div class="avatar" id="drawerAvatar">U</div>
    <div class="dn" id="drawerName">User</div>
    <div class="de" id="drawerEmail">user@example.com</div>
    <div class="dw" id="drawerWallet">Rs. 0</div>
  </div>
  <div class="drawer-nav">
    <div class="drawer-item" data-drawer="profile"><i class="fa-solid fa-user"></i> My Profile</div>
    <div class="drawer-item" data-drawer="wallet"><i class="fa-solid fa-wallet"></i> Wallet Balance</div>
    <div class="drawer-item" data-drawer="notifications"><i class="fa-regular fa-bell"></i> Notifications <span class="pill hidden" id="drawerNotifPill">0</span></div>
    <div class="drawer-item" data-drawer="orders"><i class="fa-solid fa-user-tag"></i> My Accounts</div>
    <div class="drawer-item" data-drawer="premium"><i class="fa-solid fa-crown"></i> Premium Accounts</div>
    <div class="drawer-item" data-drawer="orders"><i class="fa-solid fa-bag-shopping"></i> My Orders</div>
    <div class="drawer-item" data-drawer="profile"><i class="fa-solid fa-gear"></i> Settings</div>
    <div class="drawer-item" data-drawer="support"><i class="fa-solid fa-headset"></i> Help &amp; Support</div>
    <div class="drawer-item" data-drawer="support"><i class="fa-brands fa-whatsapp"></i> WhatsApp Support</div>
    <div class="drawer-item danger" data-drawer="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</div>
  </div>
  <div class="drawer-promo">
    <div class="dp-title"><span>Grow Your</span><br>Social Media</div>
    <div class="dp-sub">Real accounts, instant delivery, trusted deals.</div>
    <button class="dp-btn" id="drawerPromoBtn">Join Now <i class="fa-solid fa-arrow-right"></i></button>
  </div>
  <div class="drawer-social">
    <div class="ds-title">Follow TolifyHub</div>
    <div class="ds-icons" id="drawerSocial"></div>
  </div>
</div>

<!-- Floating WhatsApp support — every page -->
<a class="wa-float hidden" id="waFloat" href="#" target="_blank" rel="noopener" aria-label="WhatsApp support"><i class="fa-brands fa-whatsapp"></i></a>

<!-- MODAL -->
<div class="modal" id="modal">
  <div class="sheet" id="sheet">
    <div class="sheet-head">
      <h3 id="sheetTitle">Title</h3>
      <button class="sheet-close" id="sheetClose"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="sheet-body" id="sheetBody"></div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script type="module">
import {
  auth, db,
  onAuthStateChanged, signOut,
  signInWithEmailAndPassword, createUserWithEmailAndPassword,
  sendPasswordResetEmail, GoogleAuthProvider, signInWithPopup,
  doc, getDoc, setDoc, updateDoc, addDoc, collection, query, where,
  orderBy, limit, onSnapshot, serverTimestamp, getDocs, runTransaction,
  increment, deleteDoc, Timestamp, writeBatch,
  loadPublicSettings, whatsappLink
} from './firebase.js';

/* ============ STATE ============ */
let currentUser = null, userData = null;
let unsubUser = null, unsubNotifs = null, unsubBanners = null;
let unsubSocial = null, unsubPremium = null, unsubMyAcc = null;
let unsubTxns = null, unsubFunds = null;
let settingsCache = {};
let bannersCache = [], socialCache = [], premiumCache = [];
let myAccCache = [], txnsCache = [], fundsCache = [];
let currentViewName = 'home', currentPlat = 'all', currentBannerIdx = 0, bannerTimer = null;
const $ = id => document.getElementById(id);

/* ============ HELPERS ============ */
function fmt(n){ if(typeof n !== 'number') n = Number(n)||0; return 'Rs. ' + n.toLocaleString('en-PK'); }
function esc(s){ return String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
function toast(msg, type=''){ const t=$('toast'); t.textContent=msg; t.className='toast show '+type; clearTimeout(t._to); t._to=setTimeout(()=>t.classList.remove('show'),2800); }
function msOf(ts){ if(!ts) return Date.now(); if(ts.toMillis) return ts.toMillis(); if(ts.seconds) return ts.seconds*1000; return Number(ts)||Date.now(); }
function byNew(a,b){ return msOf(b.createdAt||b.purchasedAt)-msOf(a.createdAt||a.purchasedAt); }
function timeAgo(ts){ if(!ts) return ''; const diff=Date.now()-msOf(ts); const s=Math.floor(diff/1000); if(s<60) return 'just now'; const m=Math.floor(s/60); if(m<60) return m+'m ago'; const h=Math.floor(m/60); if(h<24) return h+'h ago'; const d=Math.floor(h/24); if(d<7) return d+'d ago'; return new Date(msOf(ts)).toLocaleDateString(); }
function openSheet(title, html){ $('sheetTitle').textContent=title; $('sheetBody').innerHTML=html; $('modal').classList.add('show'); }
function closeSheet(){ $('modal').classList.remove('show'); }
$('sheetClose').onclick = closeSheet;
$('modal').onclick = (e)=>{ if(e.target===$('modal')) closeSheet(); };

/* Premium pro-rata price: (daysLeft / totalDays) * originalPrice */
function premCalc(a){
  const total = Math.max(1, Number(a.validDays)||30);
  const elapsed = Math.floor((Date.now()-msOf(a.createdAt))/86400000);
  const daysLeft = Math.max(0, total-elapsed);
  return { daysLeft, total, price: Math.round(daysLeft/total*(Number(a.originalPrice)||0)) };
}

/* ============ INLINE SVG BRAND MARKS — FALLBACK ONLY ============
   Used ONLY when a product has no logoURL. The real logo always comes
   from Firestore logoURL (admin pastes the real brand logo link).
   No emoji anywhere — these are code-drawn SVG glyphs. */
let __svgUid = 0;
function svgBrand(p){
  p=(p||'').toLowerCase();
  const uid = 'g'+(++__svgUid);
  const open = '<svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="'+esc(p)+'">';
  const close = '</svg>';
  const txt = (ch, fill)=>'<text x="24" y="33" text-anchor="middle" font-family="Arial, sans-serif" font-size="28" font-weight="800" fill="'+fill+'">'+ch+'</text>';
  if(p.includes('tiktok')) return open
    + '<rect width="48" height="48" rx="12" fill="#000000"/>'
    + '<ellipse cx="19" cy="34" rx="5" ry="4" fill="#ffffff" transform="rotate(-15 19 34)"/>'
    + '<rect x="23.4" y="11" width="2.6" height="23" fill="#ffffff"/>'
    + '<path d="M26 11c4.5 1 7 3.5 7.5 8.5-2.5-.5-4.5-2-5.5-4.5" fill="none" stroke="#ffffff" stroke-width="2.6" stroke-linecap="round"/>'
    + close;
  if(p.includes('youtube')) return open
    + '<rect width="48" height="48" rx="12" fill="#FF0000"/>'
    + '<polygon points="20,15 33,24 20,33" fill="#ffffff"/>'
    + close;
  if(p.includes('instagram')) return open
    + '<defs><linearGradient id="'+uid+'" x1="0" y1="1" x2="1" y2="0"><stop offset="0" stop-color="#f09433"/><stop offset=".5" stop-color="#dc2743"/><stop offset="1" stop-color="#bc1888"/></linearGradient></defs>'
    + '<rect width="48" height="48" rx="12" fill="url(#'+uid+')"/>'
    + '<rect x="12" y="12" width="24" height="24" rx="8" fill="none" stroke="#ffffff" stroke-width="2.6"/>'
    + '<circle cx="24" cy="24" r="6" fill="none" stroke="#ffffff" stroke-width="2.6"/>'
    + '<circle cx="31.5" cy="16.5" r="1.8" fill="#ffffff"/>'
    + close;
  if(p.includes('facebook')) return open
    + '<rect width="48" height="48" rx="12" fill="#1877F2"/>' + txt('f','#ffffff') + close;
  if(p.includes('canva')) return open
    + '<rect width="48" height="48" rx="12" fill="#00C4CC"/>' + txt('C','#ffffff') + close;
  if(p.includes('capcut')) return open
    + '<rect width="48" height="48" rx="12" fill="#111111"/>'
    + '<circle cx="18" cy="17" r="3.6" fill="none" stroke="#ffffff" stroke-width="2.4"/>'
    + '<circle cx="18" cy="31" r="3.6" fill="none" stroke="#ffffff" stroke-width="2.4"/>'
    + '<path d="M21 19.5 33 30M21 28.5 33 18" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round"/>'
    + close;
  if(p.includes('google')) return open
    + '<rect x="1" y="1" width="46" height="46" rx="12" fill="#ffffff" stroke="#e4e9f2" stroke-width="2"/>' + txt('G','#4285F4') + close;
  return open + '<rect width="48" height="48" rx="12" fill="#6d5ae0"/>' + txt('T','#ffffff') + close;
}
/* Real logo first (logoURL, loaded live from Firestore); SVG fallback only. */
function accIconHTML(a){
  if(a.logoURL) return '<div class="p-ico"><img src="'+esc(a.logoURL)+'" alt="'+esc(a.platform||'logo')+'"></div>';
  return '<div class="p-ico">'+svgBrand(a.platform)+'</div>';
}

/* Read an image file as a downscaled data URL (no Firebase Storage — free plan).
   Keeps Firestore docs small: max dimension + JPEG quality. Rejects oversize. */
function readImageDataURL(file, maxDim, quality){
  return new Promise((resolve,reject)=>{
    if(!file) return resolve('');
    const rd=new FileReader();
    rd.onerror=()=>reject(new Error('Could not read file'));
    rd.onload=()=>{
      const img=new Image();
      img.onerror=()=>reject(new Error('Not a valid image'));
      img.onload=()=>{
        const scale=Math.min(1, maxDim/Math.max(img.width,img.height));
        const w=Math.max(1,Math.round(img.width*scale)), h=Math.max(1,Math.round(img.height*scale));
        const cv=document.createElement('canvas'); cv.width=w; cv.height=h;
        cv.getContext('2d').drawImage(img,0,0,w,h);
        const url=cv.toDataURL('image/jpeg', quality||0.82);
        if(url.length>700000) return reject(new Error('Image too large — use a smaller image'));
        resolve(url);
      };
      img.src=rd.result;
    };
    rd.readAsDataURL(file);
  });
}

/* ============ PUBLIC SETTINGS (logo, WhatsApp, social links) ============ */
async function applyPublicSettings(){
  settingsCache = await loadPublicSettings();
  // Logo FIXED at top of login/register: settings logo if set, else navy-T mark.
  if(settingsCache.logoURL){
    $('authLogoWrap').innerHTML = '<img class="auth-logo-img" src="'+esc(settingsCache.logoURL)+'" alt="TolifyHub">';
  }
  renderSupportLinks();
}
function supportNumber(){ return settingsCache.whatsappNumber || ''; }
function renderSupportLinks(){
  // Floating WhatsApp button — every page.
  const num = supportNumber();
  const wa = $('waFloat');
  if(num){ wa.href = whatsappLink(num, 'Hi TolifyHub, I need support.'); wa.classList.remove('hidden'); }
  else { wa.classList.add('hidden'); }
  // Social links (admin-set) in drawer + footer.
  const links = settingsCache.socialLinks || {};
  const defs = [
    ['whatsapp', num ? whatsappLink(num) : '', 'fa-brands fa-whatsapp'],
    ['tiktok', links.tiktok||'', 'fa-brands fa-tiktok'],
    ['instagram', links.instagram||'', 'fa-brands fa-instagram'],
    ['youtube', links.youtube||'', 'fa-brands fa-youtube'],
    ['facebook', links.facebook||'', 'fa-brands fa-facebook']
  ].filter(d=>d[1]);
  const html = defs.map(d=>'<a href="'+esc(d[1])+'" target="_blank" rel="noopener" aria-label="'+d[0]+'"><i class="'+d[2]+'"></i></a>').join('');
  $('drawerSocial').innerHTML = html || '<span style="font-size:12px;color:var(--muted)">Social links coming soon</span>';
  $('siteFoot').innerHTML = '<div class="ds-icons">'+html+'</div><div>&copy; TolifyHub — Real Accounts. Real Premium.</div>';
}
applyPublicSettings();

/* ============ AUTH TABS / FORMS ============ */
document.querySelectorAll('.auth-tab').forEach(tab=>{
  tab.onclick = ()=>{
    document.querySelectorAll('.auth-tab').forEach(t=>t.classList.remove('active'));
    tab.classList.add('active');
    const isLogin = tab.dataset.auth === 'login';
    $('loginForm').classList.toggle('hidden', !isLogin);
    $('registerForm').classList.toggle('hidden', isLogin);
  };
});
document.querySelectorAll('.toggle-pass').forEach(btn=>{
  btn.onclick = ()=>{
    const inp = $(btn.dataset.target);
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
  };
});
function friendlyAuthError(ex){
  const c = ex?.code || '';
  const map = {
    'auth/invalid-email':'Invalid email address',
    'auth/user-not-found':'No account found with this email',
    'auth/wrong-password':'Incorrect password',
    'auth/invalid-credential':'Invalid email or password',
    'auth/email-already-in-use':'Email already in use',
    'auth/weak-password':'Password too weak (min 6 chars)',
    'auth/too-many-requests':'Too many attempts. Try again later',
    'auth/popup-closed-by-user':'Sign-in cancelled',
    'auth/network-request-failed':'Network error. Check connection'
  };
  return map[c] || (ex.message || 'Something went wrong');
}
$('loginForm').onsubmit = async (e)=>{
  e.preventDefault();
  const btn=$('loginBtn'), err=$('loginErr');
  err.textContent=''; btn.disabled=true; btn.innerHTML='<span class="loader"></span> Logging in...';
  try { await signInWithEmailAndPassword(auth, $('loginEmail').value.trim(), $('loginPassword').value); }
  catch(ex){ err.textContent=friendlyAuthError(ex); btn.disabled=false; btn.innerHTML='<i class="fa-solid fa-right-to-bracket"></i> Login'; }
};
$('registerForm').onsubmit = async (e)=>{
  e.preventDefault();
  const btn=$('registerBtn'), err=$('registerErr');
  err.textContent='';
  const p1=$('regPassword').value, p2=$('regConfirm').value;
  if(p1!==p2){ err.textContent='Passwords do not match'; return; }
  if(p1.length<6){ err.textContent='Password must be at least 6 characters'; return; }
  const uname=$('regUsername').value.trim();
  if(!uname){ err.textContent='Username required'; return; }
  btn.disabled=true; btn.innerHTML='<span class="loader"></span> Creating...';
  try {
    const cred = await createUserWithEmailAndPassword(auth, $('regEmail').value.trim(), p1);
    await createUserDoc(cred.user, uname);
  } catch(ex){ err.textContent=friendlyAuthError(ex); btn.disabled=false; btn.innerHTML='<i class="fa-solid fa-user-plus"></i> Register Now'; }
};
async function createUserDoc(u, username){
  const ref = doc(db,'users',u.uid);
  const snap = await getDoc(ref);
  if(snap.exists()) return;
  await setDoc(ref, {
    uid: u.uid,
    username: username || (u.displayName || u.email.split('@')[0]),
    fullName: u.displayName || '',
    email: u.email,
    photoURL: u.photoURL || '',
    balance: 0, isAdmin: false, blocked: false,
    createdAt: serverTimestamp(), lastActive: serverTimestamp()
  });
}
async function signInWithGoogle(){
  const provider = new GoogleAuthProvider();
  try {
    const cred = await signInWithPopup(auth, provider);
    const snap = await getDoc(doc(db,'users',cred.user.uid));
    if(!snap.exists()) await createUserDoc(cred.user, cred.user.displayName || cred.user.email.split('@')[0]);
  } catch(ex){ toast(friendlyAuthError(ex),'error'); }
}
$('googleLoginBtn').onclick = signInWithGoogle;
$('googleRegisterBtn').onclick = signInWithGoogle;
$('forgotLink').onclick = async (e)=>{
  e.preventDefault();
  const email = $('loginEmail').value.trim();
  if(!email){ toast('Enter your email first','error'); return; }
  try { await sendPasswordResetEmail(auth, email); toast('Password reset email sent','success'); }
  catch(ex){ toast(friendlyAuthError(ex),'error'); }
};

/* ============ AUTH STATE ============ */
onAuthStateChanged(auth, async (user)=>{
  cleanupListeners();
  if(!user){
    currentUser=null; userData=null;
    $('app').classList.remove('visible');
    $('authScreen').style.display='flex';
    return;
  }
  currentUser=user;
  const snap = await getDoc(doc(db,'users',user.uid));
  if(!snap.exists()) await createUserDoc(user);
  updateDoc(doc(db,'users',user.uid), { lastActive: serverTimestamp() }).catch(()=>{});
  await applyPublicSettings();
  $('authScreen').style.display='none';
  $('app').classList.add('visible');
  attachUserListener(user.uid);
  attachGlobalListeners();
  showView('home');
});
function attachUserListener(uid){
  unsubUser = onSnapshot(doc(db,'users',uid), (snap)=>{
    if(!snap.exists()) return;
    userData = { id: snap.id, ...snap.data() };
    if(userData.blocked){ toast('Your account has been blocked by admin','error'); signOut(auth); return; }
    updateUserUI();
  });
}
function updateUserUI(){
  if(!userData) return;
  $('walletAmount').textContent = fmt(userData.balance||0);
  $('walletTopAmt').textContent = fmt(userData.balance||0);
  $('drawerWallet').textContent = fmt(userData.balance||0);
  $('drawerName').textContent = userData.fullName || userData.username || 'User';
  $('drawerEmail').textContent = userData.email || '';
  const initial = (userData.username || userData.fullName || 'U').charAt(0).toUpperCase();
  const av=$('topAvatar'), dav=$('drawerAvatar');
  if(userData.photoURL){
    av.innerHTML='<img src="'+esc(userData.photoURL)+'" alt="">';
    dav.innerHTML='<img src="'+esc(userData.photoURL)+'" alt="">';
  } else { av.textContent=initial; dav.textContent=initial; }
}

/* ============ GLOBAL LISTENERS ============ */
function attachGlobalListeners(){
  onSnapshot(doc(db,'settings','config'), (snap)=>{
    settingsCache = snap.exists() ? snap.data() : {};
    renderSupportLinks();
  });
  unsubNotifs = onSnapshot(query(collection(db,'notifications'), where('userId','==',currentUser.uid)), (snap)=>{
    const notifs = snap.docs.map(d=>({id:d.id,...d.data()})).sort(byNew).slice(0,60);
    const unread = notifs.filter(n=>!n.read).length;
    $('notifBadge').textContent = unread;
    $('notifBadge').classList.toggle('hidden', unread===0);
    $('drawerNotifPill').textContent = unread;
    $('drawerNotifPill').classList.toggle('hidden', unread===0);
    if(currentViewName==='notifications') renderNotificationsView(notifs);
  }, (err)=>console.warn('notif listen', err.message));
  unsubBanners = onSnapshot(query(collection(db,'banners'), where('active','==',true)), (snap)=>{
    bannersCache = snap.docs.map(d=>({id:d.id,...d.data()}));
    renderBanners();
  });
  unsubSocial = onSnapshot(query(collection(db,'socialAccounts'), where('sold','==',false)), (snap)=>{
    socialCache = snap.docs.map(d=>({id:d.id,...d.data()}));
    renderHomeSocial();
    if(currentViewName==='accounts') renderAccountsView();
  });
  unsubPremium = onSnapshot(query(collection(db,'premiumAccounts'), where('sold','==',false)), (snap)=>{
    premiumCache = snap.docs.map(d=>({id:d.id,...d.data()}));
    renderHomePremium();
    if(currentViewName==='premium') renderPremiumView();
  });
  unsubMyAcc = onSnapshot(query(collection(db,'accountPurchases'), where('userId','==',currentUser.uid)), (snap)=>{
    myAccCache = snap.docs.map(d=>({id:d.id,...d.data()})).sort(byNew);
    if(currentViewName==='orders') renderOrdersView();
  });
  unsubTxns = onSnapshot(query(collection(db,'walletTransactions'), where('userId','==',currentUser.uid)), (snap)=>{
    txnsCache = snap.docs.map(d=>({id:d.id,...d.data()})).sort(byNew).slice(0,100);
    if(currentViewName==='wallet') renderWalletView();
  });
  unsubFunds = onSnapshot(query(collection(db,'fundRequests'), where('userId','==',currentUser.uid)), (snap)=>{
    fundsCache = snap.docs.map(d=>({id:d.id,...d.data()})).sort(byNew);
    if(currentViewName==='wallet') renderWalletView();
  });
}
function cleanupListeners(){
  [unsubUser,unsubNotifs,unsubBanners,unsubSocial,unsubPremium,unsubMyAcc,unsubTxns,unsubFunds]
    .forEach(fn=>{ if(typeof fn==='function') try{fn();}catch(e){} });
  unsubUser=unsubNotifs=unsubBanners=unsubSocial=unsubPremium=unsubMyAcc=unsubTxns=unsubFunds=null;
}

/* ============ BANNERS ============ */
function renderBanners(){
  const wrap=$('bannerWrap'), track=$('bannerTrack'), dots=$('bannerDots');
  if(!bannersCache.length){ wrap.classList.add('hidden'); return; }
  wrap.classList.remove('hidden');
  track.innerHTML = bannersCache.map((b,i)=>'<div class="banner-slide" data-idx="'+i+'"><img src="'+esc(b.imageURL||'')+'" alt="Banner"></div>').join('');
  dots.innerHTML = bannersCache.map((_,i)=>'<div class="dot'+(i===0?' active':'')+'" data-dot="'+i+'"></div>').join('');
  currentBannerIdx=0; track.style.transform='translateX(0)';
  track.querySelectorAll('.banner-slide').forEach(el=>{
    el.onclick=()=>{ const b=bannersCache[Number(el.dataset.idx)]; if(b) openSheet(b.title||'Banner','<p class="detail-desc">'+esc(b.description||'')+'</p>'); };
  });
  dots.querySelectorAll('.dot').forEach(d=>{ d.onclick=(e)=>{ e.stopPropagation(); goToBanner(Number(d.dataset.dot)); }; });
  if(bannerTimer) clearInterval(bannerTimer);
  if(bannersCache.length>1) bannerTimer=setInterval(()=>goToBanner(currentBannerIdx+1),4500);
}
function goToBanner(idx){
  if(!bannersCache.length) return;
  currentBannerIdx=(idx+bannersCache.length)%bannersCache.length;
  $('bannerTrack').style.transform='translateX(-'+(currentBannerIdx*100)+'%)';
  document.querySelectorAll('#bannerDots .dot').forEach((d,i)=>d.classList.toggle('active', i===currentBannerIdx));
}

/* ============ PRODUCT CARDS ============ */
function socialCardHTML(a){
  return '<div class="acc-row" data-acc="'+esc(a.id)+'" data-type="social">'
    + accIconHTML(a)
    + '<div class="acc-info"><div class="p-name">'+esc(a.platform||'Account')+' <i class="fa-solid fa-circle-check"></i></div>'
    + '<div class="p-sub">'+esc(a.username?('@'+a.username):'')+' '+(a.followers?('• '+esc(a.followers)+' followers'):'')+(a.country?(' • '+esc(a.country)):'')+'</div></div>'
    + '<div class="acc-side"><div class="p-price-pill">'+fmt(a.price||0)+'</div><div class="p-buy-sm">View</div></div></div>';
}
function premiumCardHTML(a){
  const c = premCalc(a);
  const renew = new Date(msOf(a.createdAt)+c.total*86400000).toLocaleDateString('en-PK',{month:'short',day:'numeric',year:'numeric'});
  return '<div class="acc-row" data-acc="'+esc(a.id)+'" data-type="premium">'
    + accIconHTML(a)
    + '<div class="acc-info"><div class="p-name">'+esc(a.platform||'Premium')+' <i class="fa-solid fa-circle-check"></i></div>'
    + '<div class="p-sub">Premium • Renews '+renew+' • '+(a.username?esc(a.username):c.daysLeft+' of '+c.total+' days left')+'</div></div>'
    + '<div class="acc-side"><div class="p-price-pill">'+fmt(c.price)+'</div><div class="p-buy-sm">View</div></div></div>';
}
function bindCards(root){
  root.querySelectorAll('[data-acc]').forEach(el=> el.onclick=()=>openAccountDetail(el.dataset.type, el.dataset.acc));
}
function filteredSocial(){
  if(currentPlat==='all') return socialCache;
  return socialCache.filter(a=>(a.platform||'').toLowerCase().includes(currentPlat));
}
function renderHomeSocial(){
  const box=$('socialGrid'); if(!box) return;
  const list=filteredSocial().slice(0,8);
  box.innerHTML = list.length ? list.map(socialCardHTML).join('') : '<div class="empty" style="grid-column:1/-1"><p>No accounts available right now</p></div>';
  bindCards(box);
}
function renderHomePremium(){
  const box=$('premiumGrid'); if(!box) return;
  const list=premiumCache.filter(a=>premCalc(a).daysLeft>0).slice(0,6);
  box.innerHTML = list.length ? list.map(premiumCardHTML).join('') : '<div class="empty" style="grid-column:1/-1"><p>No premium accounts right now</p></div>';
  bindCards(box);
}
document.querySelectorAll('#platformChips .chip').forEach(c=>{
  c.onclick=()=>{
    document.querySelectorAll('#platformChips .chip').forEach(x=>x.classList.remove('active'));
    c.classList.add('active');
    currentPlat=c.dataset.plat;
    renderHomeSocial();
  };
});
$('seeSocial').onclick=()=>showView('accounts');
$('seePremium').onclick=()=>showView('premium');
$('heroShopBtn').onclick=()=>showView('accounts');

/* ============ ACCOUNT DETAIL + BUY ============ */
function openAccountDetail(type,id){
  const prem = type==='premium';
  const a=(prem?premiumCache:socialCache).find(x=>x.id===id);
  if(!a){ toast('Account no longer available','error'); return; }
  const c=prem?premCalc(a):null, price=prem?c.price:(Number(a.price)||0);
  const shots=a.screenshots||[];
  const renew = prem ? new Date(msOf(a.createdAt)+c.total*86400000).toLocaleDateString('en-PK',{month:'short',day:'numeric',year:'numeric'}) : '';
  openSheet(a.platform||'Account',
    '<div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">'+accIconHTML(a)
    +'<div><div style="font-weight:900;font-size:17px;color:var(--navy)">'+esc(a.platform||'')+'</div>'
    +'<div style="font-size:12px;color:var(--muted);font-weight:600;margin-top:2px">'+(prem?('Premium • '+c.daysLeft+' of '+c.total+' days left • Renews '+renew):((a.followers||'—')+' Followers • '+(a.country||'Global')))+'</div></div></div>'
    +'<div class="detail-price">'+fmt(price)+(prem?' <span style="font-size:13px;color:var(--muted);font-weight:700">/ per month</span>':'')+'</div>'
    +(a.description?'<p class="detail-desc">'+esc(a.description)+'</p>':'')
    +'<div class="cred-row" style="margin-bottom:14px"><div><b>Your wallet balance</b>'+fmt(userData?.balance||0)+'</div></div>'
    +'<button class="btn btn-navy" id="buyAccBtn"><i class="fa-solid fa-cart-shopping"></i> Buy Now — '+fmt(price)+'</button>'
    +'<button class="btn btn-outline" id="cancelDetailBtn" style="margin-top:10px">Cancel</button>'
    +(shots.length?'<div style="display:flex;gap:8px;overflow-x:auto;margin-top:14px">'+shots.map(x=>'<img src="'+esc(x)+'" style="height:110px;border-radius:16px;flex-shrink:0" alt="">').join('')+'</div>':''));
  $('buyAccBtn').onclick=()=>buyAccount(type,id);
  $('cancelDetailBtn').onclick=closeSheet;
}
async function buyAccount(type,id){
  if(!currentUser||!userData) return;
  const prem=type==='premium', col=prem?'premiumAccounts':'socialAccounts';
  const btn=$('buyAccBtn'); btn.disabled=true; btn.innerHTML='<span class="loader"></span> Processing...';
  let paid=0;
  try{
    const txnId=doc(collection(db,'walletTransactions')).id;
    await runTransaction(db, async tx=>{
      const uRef=doc(db,'users',currentUser.uid), aRef=doc(db,col,id);
      const uS=await tx.get(uRef), aS=await tx.get(aRef);
      if(!aS.exists()||aS.data().sold) throw new Error('SOLD');
      const a={id:id,...aS.data()};
      let price=Number(a.price)||0, expiresAt=null;
      if(prem){
        const c=premCalc(a); if(c.daysLeft<=0) throw new Error('EXPIRED');
        price=c.price; expiresAt=Timestamp.fromMillis(Date.now()+c.daysLeft*86400000);
      }
      const bal=uS.data().balance||0;
      // BUY GATE: balance kam ho to transaction yahin fail hoti hai — koi debit
      // nahi, koi purchase record nahi, koi login access nahi.
      if(bal<price) throw new Error('INSUFFICIENT');
      paid=price;
      tx.update(uRef,{balance:bal-price});
      tx.update(aRef,{sold:true,soldTo:currentUser.uid,soldAt:serverTimestamp()});
      tx.set(doc(db,'accountPurchases',id),{purchaseId:id,accountId:id,type:type,userId:currentUser.uid,platform:a.platform||'',username:a.username||'',logoURL:a.logoURL||'',amount:price,expiresAt:expiresAt,purchasedAt:serverTimestamp()});
      tx.set(doc(db,'walletTransactions',txnId),{transactionId:txnId,userId:currentUser.uid,type:'debit',category:prem?'premium_account':'social_account',amount:price,balanceAfter:bal-price,referenceId:id,description:(prem?'Premium':'Social')+' Account: '+(a.platform||'')+' '+(a.username||''),createdAt:serverTimestamp()});
    });
    closeSheet(); toast('Purchase successful! '+fmt(paid)+' deducted','success'); showView('orders');
  }catch(ex){
    btn.disabled=false; btn.innerHTML='<i class="fa-solid fa-cart-shopping"></i> Buy Now';
    const m=String(ex.message);
    if(m.includes('INSUFFICIENT')) toast('Balance kam hai, pehle deposit karein.','error');
    else if(m.includes('SOLD')) toast('Sorry, this account was just sold','error');
    else if(m.includes('EXPIRED')) toast('This account has expired','error');
    else toast('Failed: '+m,'error');
  }
}

/* ============ VIEWS / NAV ============ */
function showView(name){
  currentViewName=name;
  document.querySelectorAll('.bn-item').forEach(x=>x.classList.toggle('active', x.dataset.nav===name));
  closeDrawer();
  const home=$('homeView'), content=$('contentView');
  if(name==='home'){ home.classList.remove('hidden'); content.classList.add('hidden'); renderHomeSocial(); renderHomePremium(); return; }
  home.classList.add('hidden'); content.classList.remove('hidden');
  if(name==='accounts') renderAccountsView();
  else if(name==='premium') renderPremiumView();
  else if(name==='orders') renderOrdersView();
  else if(name==='wallet') renderWalletView();
  else if(name==='notifications') renderNotificationsView();
  else if(name==='profile') renderProfileView();
  else if(name==='support') openSupport();
}
document.querySelectorAll('.bn-item').forEach(x=> x.onclick=()=>showView(x.dataset.nav));
$('walletPillTop').onclick=()=>showView('wallet');
$('addFundBtn').onclick=()=>openAddFund();
$('notifBtn').onclick=()=>showView('notifications');
$('profileBtn').onclick=()=>showView('profile');
$('burgerBtn').onclick=()=>{ $('drawer').classList.add('show'); $('overlay').classList.add('show'); };
function closeDrawer(){ $('drawer').classList.remove('show'); $('overlay').classList.remove('show'); }
$('overlay').onclick=closeDrawer;
const _dpb=$('drawerPromoBtn'); if(_dpb) _dpb.onclick=()=>showView('accounts');
document.querySelectorAll('.drawer-item').forEach(item=>{
  item.onclick=()=>{
    const d=item.dataset.drawer;
    if(d==='logout'){ signOut(auth); return; }
    if(d==='support'){ openSupport(); return; }
    showView(d);
  };
});
function openSupport(){
  const num=supportNumber();
  if(!num){ toast('WhatsApp support number not set yet','error'); return; }
  window.open(whatsappLink(num,'Hi TolifyHub, I need support.'),'_blank');
}

function renderAccountsView(){
  const view=$('contentView');
  const list=filteredSocial();
  view.innerHTML='<div class="page-view"><h2>Social Accounts</h2>'
    +'<div class="chips" style="padding:0 0 12px">'
    +['all','tiktok','youtube','instagram','facebook'].map(p=>'<button class="chip'+(currentPlat===p?' active':'')+'" data-plat2="'+p+'">'+(p==='all'?'All':p.charAt(0).toUpperCase()+p.slice(1))+'</button>').join('')
    +'</div>'
    +(list.length?'<div class="acc-list" style="padding:0">'+list.map(socialCardHTML).join('')+'</div>':'<div class="empty"><i class="fa-solid fa-user-tag"></i><p>No accounts available right now</p></div>')
    +'</div>';
  view.querySelectorAll('[data-plat2]').forEach(c=>{ c.onclick=()=>{ currentPlat=c.dataset.plat2; document.querySelectorAll('#platformChips .chip').forEach(x=>x.classList.toggle('active', x.dataset.plat===currentPlat)); renderAccountsView(); renderHomeSocial(); }; });
  bindCards(view);
}
function renderPremiumView(){
  const view=$('contentView');
  const list=premiumCache.filter(a=>premCalc(a).daysLeft>0);
  view.innerHTML='<div class="page-view"><h2>Premium Accounts</h2>'
    +'<p style="color:var(--muted);font-size:13px;margin-bottom:14px">Canva Pro, CapCut Pro, Google One and more — price drops as days pass.</p>'
    +(list.length?'<div class="acc-list" style="padding:0">'+list.map(premiumCardHTML).join('')+'</div>':'<div class="empty"><i class="fa-solid fa-crown"></i><p>No premium accounts right now</p></div>')
    +'</div>';
  bindCards(view);
}
function renderOrdersView(){
  const view=$('contentView');
  view.innerHTML='<div class="page-view"><h2>My Orders</h2>'
    +(myAccCache.length?myAccCache.map(p=>
      '<div class="row-item"><div class="ri-top"><div class="ri-title">'+esc(p.platform||'Account')+(p.username?' · '+esc(p.username):'')+'</div><div class="ri-amt debit">'+fmt(p.amount||0)+'</div></div>'
      +'<div class="ri-sub">'+(p.type==='premium'?'Premium':'Social')+' · '+timeAgo(p.purchasedAt)+(p.expiresAt?' · Expires '+new Date(msOf(p.expiresAt)).toLocaleDateString():'')+'</div>'
      +'<button class="btn btn-navy" style="margin-top:10px;padding:10px" data-login="'+esc(p.id)+'"><i class="fa-solid fa-key"></i> View Login Details</button></div>'
    ).join(''):'<div class="empty"><i class="fa-solid fa-bag-shopping"></i><p>You haven\'t bought any account yet</p></div>')
    +'</div>';
  view.querySelectorAll('[data-login]').forEach(b=>b.onclick=()=>showLoginDetails(b.dataset.login));
}
async function showLoginDetails(id){
  try{
    const s=await getDoc(doc(db,'accountSecrets',id));
    if(!s.exists()){ toast('Login details not added by admin yet','error'); return; }
    const d=s.data();
    const row=(l,v)=>'<div class="cred-row"><div><b>'+l+'</b>'+esc(v||'—')+'</div><button data-copy="'+esc(v||'')+'"><i class="fa-regular fa-copy"></i></button></div>';
    openSheet('Login Details', row('Email / Username',d.loginEmail)+row('Password',d.loginPassword)+(d.accountLink?row('Account Link',d.accountLink):'')+(d.loginNote?row('Note',d.loginNote):''));
    $('sheetBody').querySelectorAll('[data-copy]').forEach(b=>b.onclick=()=>{ navigator.clipboard?.writeText(b.dataset.copy); toast('Copied','success'); });
  }catch(ex){ toast('Cannot load details: '+ex.message,'error'); }
}

/* ============ WALLET + ADD FUND ============ */
function renderWalletView(){
  const view=$('contentView');
  view.innerHTML='<div class="page-view"><h2>Wallet</h2>'
    +'<div class="wallet-card" style="margin:0 0 18px"><div class="wlabel">My Wallet Balance</div><div class="wamount">'+fmt(userData?.balance||0)+'</div><div class="wsub">Available balance</div><button class="add-fund" id="addFundBtn2"><i class="fa-solid fa-plus"></i> Add Fund</button></div>'
    +'<h3 style="font-size:16px;font-weight:800;color:var(--navy);margin-bottom:10px">Fund Requests</h3>'
    +(fundsCache.length?fundsCache.map(r=>'<div class="row-item"><div class="ri-top"><div class="ri-title">'+fmt(r.amount)+'</div><span class="ri-badge badge-'+(r.status||'pending')+'">'+esc(r.status||'Pending')+'</span></div><div class="ri-sub">'+esc(r.paymentMethod||'')+' · '+timeAgo(r.createdAt)+'</div></div>').join(''):'<div class="empty"><p>No fund requests yet</p></div>')
    +'<h3 style="font-size:16px;font-weight:800;color:var(--navy);margin:16px 0 10px">Transactions</h3>'
    +(txnsCache.length?txnsCache.map(t=>'<div class="row-item"><div class="ri-top"><div class="ri-title">'+esc(t.description||t.category||'Transaction')+'</div><div class="ri-amt '+(t.type==='credit'?'credit':'debit')+'">'+(t.type==='credit'?'+':'−')+fmt(t.amount)+'</div></div><div class="ri-sub">'+timeAgo(t.createdAt)+' · Balance after: '+fmt(t.balanceAfter||0)+'</div></div>').join(''):'<div class="empty"><p>No transactions yet</p></div>')
    +'</div>';
  $('addFundBtn2').onclick=()=>openAddFund();
}
function openAddFund(){
  openSheet('Add Fund',
    '<div class="form-group"><label>Amount (Rs.)</label><input type="number" id="fundAmount" placeholder="Enter amount" min="1"></div>'
    +'<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">'
    +[500,1000,2000,5000].map(v=>'<button class="chip-amt" data-amt="'+v+'">'+v+'</button>').join('')+'</div>'
    +'<div class="form-group"><label>Payment Method</label><div class="pm-grid" id="pmGrid">'
    +'<button class="pm-btn active" data-pm="Easypaisa"><i class="fa-solid fa-mobile-screen"></i> Easypaisa</button>'
    +'<button class="pm-btn" data-pm="JazzCash"><i class="fa-solid fa-money-bill-wave"></i> JazzCash</button>'
    +'<button class="pm-btn" data-pm="Bank Transfer"><i class="fa-solid fa-building-columns"></i> Bank Transfer</button>'
    +'<button class="pm-btn" data-pm="Other"><i class="fa-solid fa-wallet"></i> Other</button>'
    +'</div></div>'
    +'<div class="form-group"><label>Payment Screenshot</label><input type="file" id="fundShotFile" accept="image/*"><div style="font-size:11.5px;color:var(--muted);margin-top:5px;font-weight:600">Payment ka screenshot upload karein (file) ya neeche link paste karein.</div><input type="url" id="fundShotURL" placeholder="https://.../screenshot.png" style="margin-top:8px"><img id="fundShotPreview" class="hidden" src="" style="max-height:120px;border-radius:12px;margin-top:10px"></div>'
    +'<div style="background:#fef3c7;border:1px solid #fde68a;padding:12px;border-radius:12px;font-size:12px;color:#92400e;margin-bottom:14px;line-height:1.55"><strong>Note:</strong> Admin aapka payment proof verify karke fund request approve karega — approval ke baad balance add ho jayega.</div>'
    +'<button class="btn btn-navy" id="submitFundBtn"><i class="fa-brands fa-whatsapp"></i> Submit &amp; Send on WhatsApp</button>');
  let selectedPM='Easypaisa';
  let fundShotDataURL='';
  $('fundShotFile').onchange=async e=>{ const f=e.target.files[0]; if(!f) return; try{ fundShotDataURL=await readImageDataURL(f,800,0.82); const pv=$('fundShotPreview'); pv.src=fundShotDataURL; pv.classList.remove('hidden'); toast('Screenshot attached','success'); }catch(ex){ toast(ex.message,'error'); e.target.value=''; } };
  $('fundShotURL').oninput=e=>{ const u=e.target.value.trim(); const pv=$('fundShotPreview'); if(u){ pv.src=u; pv.classList.remove('hidden'); } else if(!fundShotDataURL){ pv.classList.add('hidden'); } };
  document.querySelectorAll('.chip-amt').forEach(c=>{ c.onclick=()=>{ $('fundAmount').value=c.dataset.amt; document.querySelectorAll('.chip-amt').forEach(x=>x.classList.remove('active')); c.classList.add('active'); }; });
  document.querySelectorAll('#pmGrid .pm-btn').forEach(b=>{ b.onclick=()=>{ document.querySelectorAll('#pmGrid .pm-btn').forEach(x=>x.classList.remove('active')); b.classList.add('active'); selectedPM=b.dataset.pm; }; });
  $('submitFundBtn').onclick=async()=>{
    const amt=Number($('fundAmount').value);
    if(!amt||amt<=0){ toast('Enter a valid amount','error'); return; }
    const btn=$('submitFundBtn'); btn.disabled=true; btn.innerHTML='<span class="loader"></span> Submitting...';
    try{
      const reqId=doc(collection(db,'fundRequests')).id;
      await setDoc(doc(db,'fundRequests',reqId), { requestId:reqId, userId:currentUser.uid, username:userData.username||'', email:userData.email||'', amount:amt, paymentMethod:selectedPM, screenshotURL:(fundShotDataURL || $('fundShotURL').value.trim()), status:'pending', createdAt:serverTimestamp(), reviewedAt:null, reviewedBy:null, note:'' });
      const num=supportNumber();
      if(num){
        const msg='TolifyHub — Add Fund Request\n\nUsername: '+userData.username+'\nEmail: '+userData.email+'\nUser ID: '+currentUser.uid+'\nAmount: Rs. '+amt+'\nPayment Method: '+selectedPM+'\nRequest ID: '+reqId+'\n\nPlease verify and approve.';
        window.open(whatsappLink(num,msg),'_blank');
      }
      closeSheet(); toast('Fund request submitted. Complete it on WhatsApp.','success');
    }catch(ex){ btn.disabled=false; btn.innerHTML='<i class="fa-brands fa-whatsapp"></i> Submit &amp; Send on WhatsApp'; toast('Failed: '+ex.message,'error'); }
  };
}

/* ============ NOTIFICATIONS ============ */
async function renderNotificationsView(notifs){
  const view=$('contentView');
  let list=notifs;
  if(!list){
    const snap=await getDocs(query(collection(db,'notifications'), where('userId','==',currentUser.uid)));
    list=snap.docs.map(d=>({id:d.id,...d.data()})).sort(byNew).slice(0,60);
  }
  view.innerHTML='<div class="page-view"><h2>Notifications</h2>'
    +(list.length?list.map(n=>'<div class="notif-item'+(n.read?'':' unread')+'" data-nid="'+esc(n.id)+'"><div class="ni-icon"><i class="fa-regular fa-bell"></i></div><div><div class="ni-title">'+esc(n.title||'')+'</div><div class="ni-body">'+esc(n.body||'')+'</div><div class="ni-time">'+timeAgo(n.createdAt)+'</div></div></div>').join(''):'<div class="empty"><i class="fa-regular fa-bell"></i><p>No notifications yet</p></div>')
    +'</div>';
  view.querySelectorAll('[data-nid]').forEach(el=>{ el.onclick=()=>{ updateDoc(doc(db,'notifications',el.dataset.nid),{read:true}).catch(()=>{}); el.classList.remove('unread'); }; });
}

/* ============ PROFILE (DP via pasted image URL) ============ */
function renderProfileView(){
  const view=$('contentView');
  if(!userData) return;
  const initial=(userData.username||'U').charAt(0).toUpperCase();
  view.innerHTML='<div class="page-view"><h2>My Profile</h2>'
    +'<div class="profile-card"><div class="avatar" id="profileAvatar">'+(userData.photoURL?'<img src="'+esc(userData.photoURL)+'" alt="">':initial)+'</div>'
    +'<div class="pn">'+esc(userData.fullName||userData.username||'User')+'</div>'
    +'<div class="pe">'+esc(userData.email||'')+'</div>'
    +'<div class="pid">ID: '+esc(userData.id||'')+'</div>'
    +'<div class="profile-actions"><button class="btn btn-navy" id="uploadDpBtn"><i class="fa-solid fa-camera"></i> Change DP</button><button class="btn btn-outline" id="editProfileBtn"><i class="fa-solid fa-pen"></i> Edit</button></div>'
    +'</div>'
    +'<div style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:6px;margin-bottom:14px;box-shadow:var(--shadow)">'
    +'<div style="padding:14px 16px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between"><span style="font-weight:700;color:var(--muted);font-size:13px">Wallet Balance</span><span style="font-weight:800;color:var(--indigo);font-size:15px">'+fmt(userData.balance||0)+'</span></div>'
    +'<div style="padding:14px 16px;display:flex;justify-content:space-between"><span style="font-weight:700;color:var(--muted);font-size:13px">Member Since</span><span style="font-weight:700;font-size:12.5px">'+(userData.createdAt?new Date(msOf(userData.createdAt)).toLocaleDateString():'—')+'</span></div></div>'
    +'<h3 style="font-size:16px;font-weight:800;color:var(--navy);margin:16px 0 12px">My Orders ('+myAccCache.length+')</h3>'
    +(myAccCache.length?myAccCache.slice(0,5).map(p=>'<div class="row-item"><div class="ri-top"><div class="ri-title">'+esc(p.platform||'Account')+(p.username?' · '+esc(p.username):'')+'</div><div class="ri-amt debit">'+fmt(p.amount||0)+'</div></div><div class="ri-sub">'+timeAgo(p.purchasedAt)+'</div></div>').join(''):'<div class="empty"><p>No orders yet</p></div>')
    +'<button class="btn btn-outline" id="logoutBtn2" style="margin-top:16px;color:var(--danger);border-color:var(--danger)"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>'
    +'</div>';
  $('uploadDpBtn').onclick=()=>{
    openSheet('Change Profile Photo',
      '<div class="form-group"><label>Profile Photo URL (paste image link)</label><input type="url" id="dpUrlInput" value="'+esc(userData.photoURL||'')+'" placeholder="https://.../photo.png"></div>'
      +'<p style="font-size:12px;color:var(--muted);margin-bottom:12px">Paste an image link (for example Imgur, Postimages or your own site). No file upload — Cloud Storage is not enabled on the free plan. Leave it empty to go back to your initial letter.</p>'
      +'<button class="btn btn-navy" id="saveDpBtn">Save Photo</button>');
    $('saveDpBtn').onclick=async()=>{
      const url=$('dpUrlInput').value.trim();
      if(url && !/^https?:\/\//i.test(url)){ toast('Paste a full image link starting with http:// or https://','error'); return; }
      try{
        await updateDoc(doc(db,'users',currentUser.uid), { photoURL: url });
        closeSheet(); toast('Profile picture updated','success'); renderProfileView();
      }catch(ex){ toast('Failed: '+ex.message,'error'); }
    };
  };
  $('editProfileBtn').onclick=()=>{
    openSheet('Edit Profile',
      '<div class="form-group"><label>Full Name</label><input type="text" id="editFullName" value="'+esc(userData.fullName||'')+'"></div>'
      +'<div class="form-group"><label>Username</label><input type="text" id="editUsername" value="'+esc(userData.username||'')+'"></div>'
      +'<div class="form-group"><label>Email</label><input type="email" value="'+esc(userData.email||'')+'" disabled></div>'
      +'<button class="btn btn-navy" id="saveProfileBtn">Save Changes</button>');
    $('saveProfileBtn').onclick=async()=>{
      try{
        await updateDoc(doc(db,'users',currentUser.uid), { fullName:$('editFullName').value.trim(), username:$('editUsername').value.trim() });
        closeSheet(); toast('Profile updated','success');
      }catch(ex){ toast('Failed: '+ex.message,'error'); }
    };
  };
  $('logoutBtn2').onclick=()=>signOut(auth);
}

/* Premium prices drop as days pass — refresh every minute */
setInterval(()=>{ if(!currentUser) return; renderHomePremium(); if(currentViewName==='premium') renderPremiumView(); },60000);

/* ============ BOOT ============ */
showView('home');
</script>
</body>
</html>
