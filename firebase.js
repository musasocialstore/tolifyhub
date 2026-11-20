// ============================================================================
//  TolifyHub — firebase.js
//  Shared Firebase init + helpers (ES Module). Used by index.php and admin.php.
//  Backend: Firebase JS SDK 10.14.1 — Auth + Firestore only.
//  Cloud Storage is NOT enabled on this project (Spark free plan;
//  Storage on new projects needs the paid Blaze plan). Images are
//  pasted as URLs (logoURL / photoURL / imageURL) — never uploaded.
//  The config below is the LIVE web-app config for tolifyhub-90375.
//  Do NOT replace it and do NOT copy it into any other file.
//  Do NOT paste the old Musa project (social-store-4a3e6) config here.
// ============================================================================
// firebase.js — TolifyHub shared Firebase init (ES Module)
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
import {
  getAuth,
  createUserWithEmailAndPassword,
  signInWithEmailAndPassword,
  signOut,
  onAuthStateChanged,
  sendPasswordResetEmail,
  updateProfile,
  setPersistence,
  browserLocalPersistence,
  GoogleAuthProvider,
  signInWithPopup
} from "https://www.gstatic.com/firebasejs/10.14.1/firebase-auth.js";
import {
  getFirestore,
  collection,
  doc,
  setDoc,
  getDoc,
  getDocs,
  addDoc,
  updateDoc,
  deleteDoc,
  query,
  where,
  orderBy,
  limit,
  onSnapshot,
  serverTimestamp,
  Timestamp,
  writeBatch,
  increment,
  arrayUnion,
  arrayRemove,
  runTransaction
} from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";
//  No firebase-storage import: Cloud Storage is not enabled on this project.

// ──────────────────────────────────────────────────────────────────────────
// LIVE CONFIG — project tolifyhub-90375 (already injected — do not replace)
// Firebase project: tolifyhub-90375 (Spark free, asia-south1).
// Auth (Email/Password + Google) and Firestore are ON. Storage is OFF.
// The values below are the live web-app config for this project.
// ──────────────────────────────────────────────────────────────────────────
const firebaseConfig = {
  apiKey: "AIzaSyABh1G_cnhXj0ombbB3AOwpnOkWWl7dkcE",
  authDomain: "tolifyhub-90375.firebaseapp.com",
  projectId: "tolifyhub-90375",
  storageBucket: "tolifyhub-90375.firebasestorage.app",
  messagingSenderId: "305786906866",
  appId: "1:305786906866:web:f82d9ad7dbf6e40234c86b"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

setPersistence(auth, browserLocalPersistence).catch(console.error);

// ──────────────────────────────────────────────────────────────────────────
// IMAGES — URL paste only. There is NO Storage upload helper in TolifyHub:
 // Cloud Storage is not enabled on this project (Spark free plan; new
 // projects need the paid Blaze plan for Storage). Admins paste an image
 // link into logoURL / imageURL fields, users paste one into photoURL.
 // (The old store used ImgBB with an API key embedded in code. That key
 // leaked. TolifyHub never uses ImgBB and never embeds an upload key.)

// ──────────────────────────────────────────────────────────────────────────
// Admin check: a user is admin if EITHER
//   1. an `admins/{uid}` document exists with active != false, OR
//   2. their email matches `settings/config.adminEmail`.
// Bootstrap (first admin): in the Firebase Console, create the document
// `admins/<your-uid>` with { active: true }, or set settings/config
// adminEmail to your email. See README.md.
// ──────────────────────────────────────────────────────────────────────────
export async function isAdminUser(user) {
  if (!user) return false;
  try {
    const snap = await getDoc(doc(db, "admins", user.uid));
    if (snap.exists() && snap.data().active !== false) return true;
  } catch (e) { /* fall through to settings check */ }
  try {
    const cfg = await getDoc(doc(db, "settings", "config"));
    if (cfg.exists() && cfg.data().adminEmail &&
        cfg.data().adminEmail.toLowerCase() === (user.email || "").toLowerCase()) return true;
  } catch (e) { /* not admin */ }
  return false;
}

// Public store settings (logo, WhatsApp number, social links).
// settings/config is PUBLICLY READABLE on purpose — it holds only public
// store info, no secrets. The login page loads the logo from it before
// the user signs in.
export async function loadPublicSettings() {
  try {
    const snap = await getDoc(doc(db, "settings", "config"));
    return snap.exists() ? snap.data() : {};
  } catch (e) {
    console.warn("Could not load public settings:", e.message);
    return {};
  }
}

export function whatsappLink(number, message) {
  const num = String(number || "").replace(/[^0-9]/g, "");
  if (!num) return "";
  return "https://wa.me/" + num + (message ? "?text=" + encodeURIComponent(message) : "");
}

// Unique id helper
export function generateId(prefix = "TH") {
  return prefix + "_" + Date.now() + "_" + Math.random().toString(36).slice(2, 9);
}

export {
  app, auth, db,
  createUserWithEmailAndPassword,
  signInWithEmailAndPassword,
  signOut,
  onAuthStateChanged,
  sendPasswordResetEmail,
  updateProfile,
  GoogleAuthProvider,
  signInWithPopup,
  collection, doc, setDoc, getDoc, getDocs, addDoc, updateDoc, deleteDoc,
  query, where, orderBy, limit, onSnapshot, serverTimestamp, Timestamp,
  writeBatch, increment, arrayUnion, arrayRemove,
  runTransaction
};
