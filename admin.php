<?php
// ============================================================================
//  TolifyHub — admin.php  (Admin panel) — UI v5 (Musa shell + lilac idea colours)
//  Lilac #f3f0ff, purple #6d5ae0, frosted white cards, radius 24px,
//  Plus Jakarta Sans, soft shadows. Same topbar / sidebar / buttons
//  as the Musa system.
//  NO EMOJIS ANYWHERE — Font Awesome / inline SVG icons only.
//  PHP serves the page; Firebase JS SDK 10.14.1 is the backend (firebase.js).
//  Logo: REAL file upload — file picker reads the image and stores it as
//  a data URL in logoURL (no Firebase Storage — Blaze plan not enabled);
//  URL-paste stays as fallback. Login credentials are entered in the SAME
//  add-account form and saved to accountSecrets together with the product.
//  Manage ONLY: Social Accounts + Premium Accounts, funds, users,
//  purchases, transactions, banners, notifications, settings.
//  NO courses, NO services/SMM, NO web-dev.
// ============================================================================
$STORE_NAME = 'TolifyHub';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $STORE_NAME; ?> — Admin Panel</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root{
  --bg:#f3f0ff; --card:#ffffff; --border:#e4e9f2;
  --royal:#6d5ae0; --royal-dark:#5a48d6; --navy:#221d4d; --navy-2:#312e81;
  --yellow:#8b7cf6; --yellow-2:#7c6cf0;
  --indigo:#6d5ae0; --indigo-dark:#5a48d6;
  --text:#221d4d; --muted:#6b7a99;
  --danger:#e53935; --success:#16a34a; --gold:#d97706;
  --radius:18px; --radius-sm:12px;
  --shadow:0 8px 30px rgba(34,29,77,.08);
  --shadow-lg:0 20px 50px rgba(34,29,77,.14);
}
*{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
body{font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;overflow-x:hidden}
button{font-family:inherit;cursor:pointer;border:none;background:none;color:inherit}
input,textarea,select{font-family:inherit}
img{display:block;max-width:100%}
a{color:inherit;text-decoration:none}
.hidden{display:none !important}

/* ---- Logo mark ---- */
.logo-mark{display:inline-flex;align-items:center;gap:10px}
.logo-sq{width:40px;height:40px;border-radius:11px;background:linear-gradient(135deg,var(--royal),var(--royal-dark));color:#fff;font-weight:800;font-size:22px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 16px rgba(109,90,224,.3)}
.logo-word{font-weight:800;font-size:21px;letter-spacing:-.4px;color:var(--navy);white-space:nowrap}
.logo-word b{color:var(--royal);font-weight:900}

/* ---- Login ---- */
#loginScreen{min-height:100vh;background:linear-gradient(160deg,#221d4d 0%,#123a8e 55%,#6d5ae0 100%);display:flex;align-items:center;justify-content:center;padding:24px 16px}
.login-card{background:#fff;border:1px solid var(--border);border-radius:26px;padding:34px 26px 30px;width:100%;max-width:420px;box-shadow:var(--shadow-lg);text-align:center}
.login-card .logo-mark{justify-content:center;margin-bottom:8px}
.login-card .logo-sq{width:64px;height:64px;border-radius:18px;font-size:34px}
.login-card .logo-word{font-size:26px}
.login-title{font-weight:800;font-size:22px;color:var(--navy);margin-top:10px}
.login-sub{color:var(--muted);font-size:12.5px;margin-top:4px;font-weight:700;letter-spacing:.6px;text-transform:uppercase}
.field{margin-top:18px;text-align:left}
.field label{display:block;font-size:12.5px;font-weight:700;color:var(--navy);margin-bottom:7px}
.field input{width:100%;padding:14px 15px;border:1.5px solid var(--border);border-radius:13px;font-size:14.5px;background:#fbfcff;outline:none;font-weight:500;color:var(--text)}
.field input:focus{border-color:var(--indigo);box-shadow:0 0 0 3px rgba(109,90,224,.1)}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 20px;border-radius:14px;font-weight:800;font-size:14px;width:100%;transition:.15s}
.btn-navy{background:linear-gradient(135deg,var(--royal),var(--royal-dark));color:#fff;box-shadow:0 8px 20px rgba(109,90,224,.32)}
.btn-navy:hover{transform:translateY(-1px);box-shadow:0 12px 26px rgba(109,90,224,.4)}
.btn-indigo{background:var(--royal);color:#fff}
.btn-outline{background:#fff;border:1.5px solid var(--border);color:var(--navy)}
.btn-danger{background:var(--danger);color:#fff}
.btn-sm{padding:9px 16px;font-size:12.5px;width:auto}
.btn:disabled{opacity:.55;cursor:not-allowed}
.err-msg{color:var(--danger);font-size:12.5px;font-weight:600;margin-top:10px;text-align:center;min-height:16px}

/* ---- App layout ---- */
#app{display:none;min-height:100vh;padding-bottom:30px}
#app.visible{display:block}
.topbar{position:sticky;top:0;z-index:40;background:#fff;border-bottom:1px solid var(--border);padding:12px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 2px 12px rgba(34,29,77,.04)}
.burger-btn{width:42px;height:42px;border-radius:12px;background:var(--bg);display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:17px}
.brand-block{display:flex;flex-direction:column;flex:1}
.brand-title{font-weight:800;font-size:16px;color:var(--navy)}
.brand-tag{font-size:10.5px;color:var(--muted);font-weight:700;letter-spacing:.6px;text-transform:uppercase}
.top-actions{display:flex;gap:8px;align-items:center}
.admin-chip{display:flex;align-items:center;gap:8px;background:var(--bg);padding:6px 12px 6px 6px;border-radius:999px}
.admin-chip .av{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--navy),var(--indigo));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:12px}
.admin-chip .nm{font-size:12.5px;font-weight:800;color:var(--navy)}
.icon-btn{width:40px;height:40px;border-radius:11px;background:var(--bg);display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:15px;position:relative}
.icon-btn:hover{background:var(--navy);color:#fff}

/* Sidebar — navy */
.sidebar{position:fixed;top:0;left:0;height:100%;width:260px;background:var(--navy);color:#fff;z-index:80;transform:translateX(-100%);transition:.3s;display:flex;flex-direction:column;overflow-y:auto}
.sidebar.open{transform:none}
.sidebar-head{padding:20px 18px;border-bottom:1px solid rgba(255,255,255,.1)}
.sidebar-head .logo-word{color:#fff}
.sidebar-head .sub{font-size:11px;opacity:.7;font-weight:600;letter-spacing:1px;margin-top:4px}
.sidebar-body{padding:10px 8px;flex:1}
.side-item{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:11px;font-weight:700;font-size:13.5px;color:#cbd5e1;cursor:pointer}
.side-item i{width:20px;text-align:center;color:#8ea6f5;font-size:14px}
.side-item:hover{background:rgba(255,255,255,.07);color:#fff}
.side-item.active{background:linear-gradient(135deg,var(--royal),var(--royal-dark));color:#fff}
.side-item.active i{color:#fff}
.side-item.danger{color:#fca5a5}.side-item.danger i{color:#fca5a5}
.side-section{padding:14px 14px 6px;font-size:10.5px;color:#94a3b8;font-weight:800;letter-spacing:1px;text-transform:uppercase}
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:70;opacity:0;pointer-events:none;transition:.25s}
.overlay.show{opacity:1;pointer-events:auto}

/* Content */
.content{padding:22px;max-width:1400px;margin:0 auto}
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px}
.page-header h2{font-size:22px;font-weight:800;color:var(--navy)}
.page-header p{font-size:13px;color:var(--muted);font-weight:600;margin-top:3px}
.page-header .actions{display:flex;gap:8px;flex-wrap:wrap}
.stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:14px;margin-bottom:22px}
.stat-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;box-shadow:var(--shadow);position:relative;overflow:hidden}
.stat-card .sc-label{font-size:11.5px;font-weight:800;color:var(--muted);letter-spacing:.5px;text-transform:uppercase;margin-bottom:8px}
.stat-card .sc-value{font-size:26px;font-weight:800;color:var(--navy)}
.stat-card .sc-sub{font-size:11.5px;color:var(--muted);font-weight:600;margin-top:5px}
.stat-card .sc-icon{position:absolute;top:14px;right:14px;width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;background:#e9e5ff;color:var(--royal)}
.card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:20px;box-shadow:var(--shadow);margin-bottom:18px}
.card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px}
.card-head h3{font-size:16px;font-weight:800;color:var(--navy)}
.search-row{display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap}
.search-input{flex:1;min-width:200px;position:relative}
.search-input input{width:100%;padding:12px 14px 12px 42px;border:1.5px solid var(--border);border-radius:12px;font-size:13.5px;background:#fff;outline:none;font-weight:500;color:var(--text)}
.search-input input:focus{border-color:var(--indigo)}
.search-input i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:14px}
.table-wrap{overflow-x:auto;border-radius:12px;border:1.5px solid var(--border)}
table{width:100%;border-collapse:collapse;min-width:640px}
table th{background:var(--bg);padding:12px 14px;text-align:left;font-size:11.5px;font-weight:800;color:var(--muted);letter-spacing:.5px;text-transform:uppercase;border-bottom:1.5px solid var(--border)}
table td{padding:13px 14px;font-size:13px;border-bottom:1px solid var(--border);font-weight:500}
table tr:last-child td{border-bottom:none}
table tr:hover td{background:#fbfcff}
.user-cell{display:flex;align-items:center;gap:10px}
.user-av{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--navy),var(--indigo));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:12px;flex-shrink:0;object-fit:cover}
.user-info .un{font-weight:800;font-size:13px;color:var(--navy)}
.user-info .ue{font-size:11px;color:var(--muted)}
.badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:10.5px;font-weight:800}
.badge-success{background:#dcfce7;color:#166534}
.badge-danger{background:#fee2e2;color:#991b1b}
.badge-pending{background:#fef3c7;color:#92400e}
.badge-active{background:#e9e5ff;color:var(--indigo)}
.badge-inactive{background:#f1f5f9;color:#64748b}
.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px}
.form-group{margin-bottom:14px}
.form-group label{display:block;font-size:12.5px;font-weight:800;color:var(--navy);margin-bottom:7px}
.form-group input,.form-group textarea,.form-group select{width:100%;padding:12px 14px;border:1.5px solid var(--border);border-radius:11px;font-size:13.5px;background:#fbfcff;outline:none;font-weight:500;color:var(--text)}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:var(--indigo)}
.form-group textarea{min-height:88px;resize:vertical}
.form-hint{font-size:11.5px;color:var(--muted);margin-top:5px;font-weight:600}
.help-text{font-size:11px;color:var(--muted);margin-top:5px}
.preview-img{margin-top:10px;border-radius:11px;max-height:160px;object-fit:cover}
.item-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px}
.item-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:16px;box-shadow:var(--shadow)}
.item-card .ic-img{width:100%;height:130px;border-radius:11px;object-fit:contain;margin-bottom:12px;background:var(--bg);padding:12px}
.item-card .ic-title{font-weight:800;font-size:15px;color:var(--navy);margin-bottom:4px}
.item-card .ic-desc{font-size:12.5px;color:var(--muted);line-height:1.5;margin-bottom:10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.item-card .ic-meta{display:flex;gap:10px;font-size:11.5px;font-weight:700;color:var(--indigo);margin-bottom:12px;flex-wrap:wrap}
.item-card .ic-actions{display:flex;gap:6px;flex-wrap:wrap}
.item-card .ic-actions button{flex:1;min-width:70px;padding:9px;border-radius:999px;font-weight:800;font-size:11.5px}
.btn-edit{background:#efecff;color:var(--indigo)}
.btn-del{background:#fee2e2;color:var(--danger)}
.btn-toggle{background:#fef3c7;color:#92400e}
.empty{text-align:center;padding:44px 20px;color:var(--muted)}
.empty i{font-size:42px;color:var(--border);margin-bottom:12px;display:block}
.empty p{font-size:13.5px;font-weight:600}
.toast{position:fixed;bottom:24px;right:24px;background:var(--navy);color:#fff;padding:13px 20px;border-radius:12px;font-weight:700;font-size:13px;z-index:200;opacity:0;transform:translateY(20px);transition:.25s;box-shadow:var(--shadow-lg);max-width:340px}
.toast.show{opacity:1;transform:none}
.toast.success{background:var(--success)}
.toast.error{background:var(--danger)}
.modal{position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:150;display:none;align-items:center;justify-content:center;padding:20px}
.modal.show{display:flex}
.modal-box{background:#fff;border-radius:20px;width:100%;max-width:560px;max-height:90vh;display:flex;flex-direction:column;overflow:hidden}
.modal-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.modal-head h3{font-size:16px;font-weight:800;color:var(--navy)}
.modal-close{width:34px;height:34px;border-radius:10px;background:var(--bg);display:flex;align-items:center;justify-content:center;color:var(--navy)}
.modal-close:hover{background:var(--danger);color:#fff}
.modal-body{padding:22px;overflow-y:auto;flex:1}
.modal-foot{padding:14px 22px;border-top:1px solid var(--border);display:flex;gap:10px;justify-content:flex-end;flex-shrink:0;background:#fbfcff}
.loader{display:inline-block;width:16px;height:16px;border:2.5px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
.detail-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);font-size:13px}
.detail-row:last-child{border-bottom:none}
.detail-row .dl{font-weight:700;color:var(--muted)}
.detail-row .dv{font-weight:800;color:var(--navy);text-align:right;word-break:break-word;max-width:60%}
.logo-tile{width:46px;height:46px;border-radius:12px;overflow:hidden;flex-shrink:0;background:var(--bg);display:flex;align-items:center;justify-content:center}
.logo-tile img{width:100%;height:100%;object-fit:contain}
.logo-tile svg{width:100%;height:100%}
@media(max-width:640px){
  .content{padding:14px}
  .page-header h2{font-size:19px}
  .stat-card .sc-value{font-size:22px}
  .admin-chip .nm{display:none}
  .item-grid{grid-template-columns:1fr}
  .toast{left:16px;right:16px;bottom:16px;max-width:none}
}

/* ============ TOLIFYHUB v5 — LILAC GLASS (Musa shell + idea colours, PKR) ============ */
body{background:#f3f0ff;background-image:radial-gradient(640px 420px at 8% -4%,rgba(109,90,224,.20),transparent 62%),radial-gradient(560px 420px at 96% 12%,rgba(37,99,235,.16),transparent 60%),radial-gradient(560px 520px at 50% 108%,rgba(236,72,153,.10),transparent 62%);background-attachment:fixed}
#app{background:transparent}
.topbar{background:rgba(255,255,255,.85);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,.7);border-radius:0 0 24px 24px;box-shadow:0 8px 30px rgba(109,90,224,.10)}
.burger-btn{background:#efecff;color:#221d4d}
.icon-btn{background:#efecff;color:#221d4d}
.icon-btn:hover{background:#6d5ae0;color:#fff}
.admin-chip{background:#efecff}
.admin-chip .av{background:linear-gradient(135deg,#6d5ae0,#2563eb)}
#loginScreen{background:linear-gradient(160deg,#ede9fe 0%,#ddd6fe 50%,#c7d2fe 100%)}
.login-card{background:rgba(255,255,255,.9);backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,.75);border-radius:28px}
.btn-navy{background:linear-gradient(135deg,#6d5ae0,#5a48d6);box-shadow:0 10px 24px rgba(109,90,224,.35)}
.btn-indigo{background:#6d5ae0}
.sidebar{background:rgba(255,255,255,.94);backdrop-filter:blur(18px);color:#221d4d}
.sidebar-head{border-bottom:1px solid rgba(109,90,224,.12)}
.sidebar-head .logo-word{color:#221d4d}
.sidebar-head .sub{color:#55517a}
.side-item{color:#55517a}
.side-item i{color:#6d5ae0}
.side-item:hover{background:#efecff;color:#221d4d}
.side-item.active{background:linear-gradient(135deg,#6d5ae0,#5a48d6);color:#fff;box-shadow:0 8px 18px rgba(109,90,224,.3)}
.side-item.active i{color:#fff}
.side-section{color:#8b87b3}
.card,.stat-card,.item-card{background:rgba(255,255,255,.88);backdrop-filter:blur(14px);border:1px solid rgba(255,255,255,.75);border-radius:24px;box-shadow:0 10px 26px rgba(109,90,224,.10)}
.stat-card .sc-icon{background:#ede9fe;color:#6d5ae0}
table th{background:#f3f0ff}
table tr:hover td{background:#faf9ff}
.modal-box{border-radius:28px;background:rgba(255,255,255,.97)}
.search-input input:focus,.form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:#6d5ae0;box-shadow:0 0 0 3px rgba(109,90,224,.12)}
.badge-active{background:#ede9fe;color:#5b21b6}
.btn-edit{background:#ede9fe;color:#6d5ae0}
.logo-sq{background:linear-gradient(135deg,#6d5ae0,#5a48d6);box-shadow:0 6px 16px rgba(109,90,224,.3)}
.logo-word b{color:#6d5ae0}
</style>
</head>
<body>

<!-- ============= LOGIN ============= -->
<div id="loginScreen">
  <div class="login-card">
    <div class="logo-mark"><span class="logo-sq">T</span><span class="logo-word">Tolify<b>Hub</b></span></div>
    <div class="login-title">Admin Panel</div>
    <div class="login-sub">TolifyHub</div>
    <form id="adminLoginForm" style="margin-top:22px">
      <div class="field">
        <label>Admin Email</label>
        <input type="email" id="adminEmail" placeholder="admin@tolifyhub.com" required autocomplete="username">
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" id="adminPassword" placeholder="••••••••" required autocomplete="current-password">
      </div>
      <div class="field" style="margin-top:22px">
        <button type="submit" class="btn btn-navy" id="adminLoginBtn">
          <i class="fa-solid fa-shield-halved"></i> Login to Admin Panel
        </button>
      </div>
      <div class="err-msg" id="adminErr"></div>
    </form>
    <div style="text-align:center;font-size:11.5px;color:var(--muted);margin-top:16px;font-weight:600">
      <i class="fa-solid fa-lock"></i> Authorized access only
    </div>
  </div>
</div>

<!-- ============= APP ============= -->
<div id="app">
  <div class="topbar">
    <button class="burger-btn" id="burgerBtn"><i class="fa-solid fa-bars"></i></button>
    <div class="brand-block">
      <span class="brand-title">TolifyHub</span>
      <span class="brand-tag">Admin Dashboard</span>
    </div>
    <div class="top-actions">
      <button class="icon-btn" id="refreshBtn" title="Refresh"><i class="fa-solid fa-rotate"></i></button>
      <div class="admin-chip">
        <div class="av" id="adminAv">A</div>
        <span class="nm" id="adminNm">Admin</span>
      </div>
      <button class="icon-btn" id="logoutBtn" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></button>
    </div>
  </div>

  <div class="overlay" id="overlay"></div>
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-head">
      <div class="logo-mark"><span class="logo-sq" style="background:#fff;color:var(--navy)">T</span><span class="logo-word">Tolify<b>Hub</b></span></div>
      <div class="sub">ADMIN</div>
    </div>
    <div class="sidebar-body">
      <div class="side-section">Overview</div>
      <div class="side-item active" data-nav="dashboard"><i class="fa-solid fa-chart-pie"></i> Dashboard</div>
      <div class="side-section">Users &amp; Money</div>
      <div class="side-item" data-nav="users"><i class="fa-solid fa-users"></i> Users</div>
      <div class="side-item" data-nav="funds"><i class="fa-solid fa-money-bill-transfer"></i> Add Funds</div>
      <div class="side-item" data-nav="transactions"><i class="fa-solid fa-receipt"></i> Transactions</div>
      <div class="side-section">Store</div>
      <div class="side-item" data-nav="socialAccounts"><i class="fa-brands fa-tiktok"></i> Social Accounts</div>
      <div class="side-item" data-nav="premiumAccounts"><i class="fa-solid fa-crown"></i> Premium Accounts</div>
      <div class="side-item" data-nav="purchases"><i class="fa-solid fa-bag-shopping"></i> Purchases</div>
      <div class="side-item" data-nav="banners"><i class="fa-solid fa-images"></i> Banners</div>
      <div class="side-section">Communication</div>
      <div class="side-item" data-nav="notifications"><i class="fa-regular fa-bell"></i> Notifications</div>
      <div class="side-section">System</div>
      <div class="side-item" data-nav="settings"><i class="fa-solid fa-gear"></i> Settings</div>
      <div class="side-item danger" id="sidebarLogout"><i class="fa-solid fa-right-from-bracket"></i> Logout</div>
    </div>
  </aside>

  <main class="content" id="content"></main>
</div>

<!-- MODAL -->
<div class="modal" id="modal">
  <div class="modal-box">
    <div class="modal-head">
      <h3 id="modalTitle">Modal</h3>
      <button class="modal-close" id="modalClose"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body" id="modalBody"></div>
    <div class="modal-foot" id="modalFoot"></div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script type="module">
import {
  auth, db,
  signInWithEmailAndPassword, signOut, onAuthStateChanged,
  setPersistence, browserLocalPersistence,
  collection, doc, setDoc, getDoc, getDocs, addDoc, updateDoc,
  deleteDoc, query, where, orderBy, limit, onSnapshot, serverTimestamp,
  Timestamp, runTransaction, increment,
  isAdminUser, loadPublicSettings, whatsappLink
} from './firebase.js';

setPersistence(auth, browserLocalPersistence).catch(()=>{});

const $ = id => document.getElementById(id);
function fmt(n){ n = Number(n)||0; return 'Rs. ' + n.toLocaleString('en-PK'); }
function esc(s){ return String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
function toast(msg,type=''){ const t=$('toast'); t.textContent=msg; t.className='toast show '+type; clearTimeout(t._to); t._to=setTimeout(()=>t.classList.remove('show'),3000); }
function msOf(ts){ if(!ts) return Date.now(); if(ts.toMillis) return ts.toMillis(); if(ts.seconds) return ts.seconds*1000; return Number(ts)||Date.now(); }
function fmtDate(ts){ if(!ts) return '—'; return new Date(msOf(ts)).toLocaleDateString('en-PK',{year:'numeric',month:'short',day:'numeric'}); }
function timeAgo(ts){ if(!ts) return ''; const diff=Date.now()-msOf(ts); const s=Math.floor(diff/1000); if(s<60) return 'just now'; const m=Math.floor(s/60); if(m<60) return m+'m ago'; const h=Math.floor(m/60); if(h<24) return h+'h ago'; const d=Math.floor(h/24); if(d<7) return d+'d ago'; return new Date(msOf(ts)).toLocaleDateString(); }
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


function openModal(title, bodyHTML, footHTML=''){ $('modalTitle').textContent=title; $('modalBody').innerHTML=bodyHTML; $('modalFoot').innerHTML=footHTML; $('modal').classList.add('show'); }
function closeModal(){ $('modal').classList.remove('show'); }
$('modalClose').onclick = closeModal;
$('modal').onclick = e=>{ if(e.target.id==='modal') closeModal(); };

/* Inline SVG brand marks — fallback only when a product has no logoURL.
   Real logos always come from logoURL (admin pastes the logo link). */
let __svgUid = 0;
function svgBrand(p){
  p=(p||'').toLowerCase();
  const uid='g'+(++__svgUid);
  const open='<svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="'+esc(p)+'">';
  const close='</svg>';
  const txt=(ch,fill)=>'<text x="24" y="33" text-anchor="middle" font-family="Arial, sans-serif" font-size="28" font-weight="800" fill="'+fill+'">'+ch+'</text>';
  if(p.includes('tiktok')) return open+'<rect width="48" height="48" rx="12" fill="#000000"/><ellipse cx="19" cy="34" rx="5" ry="4" fill="#ffffff" transform="rotate(-15 19 34)"/><rect x="23.4" y="11" width="2.6" height="23" fill="#ffffff"/><path d="M26 11c4.5 1 7 3.5 7.5 8.5-2.5-.5-4.5-2-5.5-4.5" fill="none" stroke="#ffffff" stroke-width="2.6" stroke-linecap="round"/>'+close;
  if(p.includes('youtube')) return open+'<rect width="48" height="48" rx="12" fill="#FF0000"/><polygon points="20,15 33,24 20,33" fill="#ffffff"/>'+close;
  if(p.includes('instagram')) return open+'<defs><linearGradient id="'+uid+'" x1="0" y1="1" x2="1" y2="0"><stop offset="0" stop-color="#f09433"/><stop offset=".5" stop-color="#dc2743"/><stop offset="1" stop-color="#bc1888"/></linearGradient></defs><rect width="48" height="48" rx="12" fill="url(#'+uid+')"/><rect x="12" y="12" width="24" height="24" rx="8" fill="none" stroke="#ffffff" stroke-width="2.6"/><circle cx="24" cy="24" r="6" fill="none" stroke="#ffffff" stroke-width="2.6"/><circle cx="31.5" cy="16.5" r="1.8" fill="#ffffff"/>'+close;
  if(p.includes('facebook')) return open+'<rect width="48" height="48" rx="12" fill="#1877F2"/>'+txt('f','#ffffff')+close;
  if(p.includes('canva')) return open+'<rect width="48" height="48" rx="12" fill="#00C4CC"/>'+txt('C','#ffffff')+close;
  if(p.includes('capcut')) return open+'<rect width="48" height="48" rx="12" fill="#111111"/><circle cx="18" cy="17" r="3.6" fill="none" stroke="#ffffff" stroke-width="2.4"/><circle cx="18" cy="31" r="3.6" fill="none" stroke="#ffffff" stroke-width="2.4"/><path d="M21 19.5 33 30M21 28.5 33 18" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round"/>'+close;
  if(p.includes('google')) return open+'<rect x="1" y="1" width="46" height="46" rx="12" fill="#ffffff" stroke="#e4e9f2" stroke-width="2"/>'+txt('G','#4285F4')+close;
  return open+'<rect width="48" height="48" rx="12" fill="#6d5ae0"/>'+txt('T','#ffffff')+close;
}
function logoTileHTML(a){
  if(a.logoURL) return '<div class="logo-tile"><img src="'+esc(a.logoURL)+'" alt=""></div>';
  return '<div class="logo-tile">'+svgBrand(a.platform)+'</div>';
}

/* ============ STATE ============ */
let currentUser = null, currentNav = 'dashboard', unsubs = {};
let cache = { users:[], purchases:[], transactions:[], banners:[], fundRequests:[], notifications:[], settings:{}, socialAccounts:[], premiumAccounts:[] };

/* ============ AUTH ============ */
$('adminLoginForm').onsubmit = async e=>{
  e.preventDefault();
  const btn=$('adminLoginBtn'), err=$('adminErr');
  err.textContent=''; btn.disabled=true; btn.innerHTML='<span class="loader"></span> Verifying...';
  try{
    const cred = await signInWithEmailAndPassword(auth, $('adminEmail').value.trim(), $('adminPassword').value);
    const ok = await isAdminUser(cred.user);
    if(!ok){ await signOut(auth); throw new Error('NOT_ADMIN'); }
  }catch(ex){
    const code=ex.code||'';
    if(ex.message==='NOT_ADMIN') err.textContent='Access denied — not an admin account';
    else if(code==='auth/wrong-password'||code==='auth/invalid-credential') err.textContent='Invalid email or password';
    else if(code==='auth/user-not-found') err.textContent='No admin account found with this email';
    else if(code==='auth/too-many-requests') err.textContent='Too many attempts. Try later.';
    else if(code==='auth/invalid-email') err.textContent='Invalid email format';
    else err.textContent=ex.message||'Login failed';
    btn.disabled=false; btn.innerHTML='<i class="fa-solid fa-shield-halved"></i> Login to Admin Panel';
  }
};
onAuthStateChanged(auth, async user=>{
  cleanupListeners();
  if(!user){ currentUser=null; $('app').classList.remove('visible'); $('loginScreen').style.display='flex'; return; }
  const ok = await isAdminUser(user);
  if(!ok){ await signOut(auth); return; }
  currentUser=user;
  $('loginScreen').style.display='none';
  $('app').classList.add('visible');
  $('adminAv').textContent=(user.email||'A').charAt(0).toUpperCase();
  $('adminNm').textContent=user.email.split('@')[0];
  attachListeners();
  navigate('dashboard');
});
$('logoutBtn').onclick=()=>doLogout();
$('sidebarLogout').onclick=()=>doLogout();
async function doLogout(){ cleanupListeners(); await signOut(auth); }

/* ============ LISTENERS ============ */
function attachListeners(){
  unsubs.users = onSnapshot(collection(db,'users'), snap=>{ cache.users=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='dashboard') renderDashboard(); if(currentNav==='users') renderUsers(); });
  unsubs.purchases = onSnapshot(query(collection(db,'accountPurchases'), orderBy('purchasedAt','desc'), limit(500)), snap=>{ cache.purchases=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='dashboard') renderDashboard(); if(currentNav==='purchases') renderPurchases(); });
  unsubs.transactions = onSnapshot(query(collection(db,'walletTransactions'), orderBy('createdAt','desc'), limit(300)), snap=>{ cache.transactions=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='transactions') renderTransactions(); });
  unsubs.banners = onSnapshot(collection(db,'banners'), snap=>{ cache.banners=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='banners') renderBanners(); });
  unsubs.fundRequests = onSnapshot(query(collection(db,'fundRequests'), orderBy('createdAt','desc'), limit(300)), snap=>{ cache.fundRequests=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='funds'||currentNav==='dashboard'){ if(currentNav==='funds') renderFunds(); else renderDashboard(); } });
  unsubs.notifications = onSnapshot(query(collection(db,'notifications'), orderBy('createdAt','desc'), limit(200)), snap=>{ cache.notifications=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='notifications') renderNotifications(); });
  unsubs.settings = onSnapshot(doc(db,'settings','config'), snap=>{ cache.settings=snap.exists()?snap.data():{}; if(currentNav==='settings') renderSettings(); });
  unsubs.socialAccounts = onSnapshot(collection(db,'socialAccounts'), snap=>{ cache.socialAccounts=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='socialAccounts') renderSocialAccounts(); if(currentNav==='dashboard') renderDashboard(); });
  unsubs.premiumAccounts = onSnapshot(collection(db,'premiumAccounts'), snap=>{ cache.premiumAccounts=snap.docs.map(d=>({id:d.id,...d.data()})); if(currentNav==='premiumAccounts') renderPremiumAccounts(); if(currentNav==='dashboard') renderDashboard(); });
}
function cleanupListeners(){ Object.values(unsubs).forEach(fn=>{ try{fn();}catch(e){} }); unsubs={}; }

/* ============ NAV ============ */
document.querySelectorAll('.side-item[data-nav]').forEach(item=>{ item.onclick=()=>navigate(item.dataset.nav); });
function navigate(name){
  currentNav=name;
  document.querySelectorAll('.side-item').forEach(x=>x.classList.toggle('active', x.dataset.nav===name));
  closeSidebar();
  const fns={ dashboard:renderDashboard, users:renderUsers, funds:renderFunds, transactions:renderTransactions, purchases:renderPurchases, banners:renderBanners, notifications:renderNotifications, settings:renderSettings, socialAccounts:renderSocialAccounts, premiumAccounts:renderPremiumAccounts };
  (fns[name]||renderDashboard)();
}
$('burgerBtn').onclick=()=>{ $('sidebar').classList.add('open'); $('overlay').classList.add('show'); };
$('overlay').onclick=closeSidebar;
function closeSidebar(){ $('sidebar').classList.remove('open'); $('overlay').classList.remove('show'); }
$('refreshBtn').onclick=()=>{ toast('Refreshing...'); const nav=currentNav; cleanupListeners(); attachListeners(); navigate(nav); };

/* ============ DASHBOARD ============ */
function statCard(label, value, icon, sub){
  return '<div class="stat-card"><div class="sc-icon"><i class="fa-solid '+icon+'"></i></div><div class="sc-label">'+label+'</div><div class="sc-value">'+value+'</div>'+(sub?'<div class="sc-sub">'+sub+'</div>':'')+'</div>';
}
function renderDashboard(){
  const users=cache.users, purchases=cache.purchases;
  const now=new Date(); const todayStart=new Date(now); todayStart.setHours(0,0,0,0);
  const totalUsers=users.length;
  const todayUsers=users.filter(u=>{ const d=u.createdAt?new Date(msOf(u.createdAt)):null; return d&&d>=todayStart; }).length;
  const revenue=purchases.reduce((s,p)=>s+(p.amount||0),0);
  const todayRevenue=purchases.filter(p=>{ const d=p.purchasedAt?new Date(msOf(p.purchasedAt)):null; return d&&d>=todayStart; }).reduce((s,p)=>s+(p.amount||0),0);
  const inStock=cache.socialAccounts.filter(a=>!a.sold).length + cache.premiumAccounts.filter(a=>!a.sold).length;
  const soldCount=cache.socialAccounts.filter(a=>a.sold).length + cache.premiumAccounts.filter(a=>a.sold).length;
  const pendingFunds=cache.fundRequests.filter(r=>r.status==='pending').length;
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Dashboard</h2><p>Welcome back, '+esc(currentUser.email)+'</p></div></div>'
    +'<div class="stat-grid">'
    + statCard('Total Users', totalUsers, 'fa-users', todayUsers+' joined today')
    + statCard('Total Revenue', fmt(revenue), 'fa-sack-dollar', 'All account sales')
    + statCard('Today Revenue', fmt(todayRevenue), 'fa-calendar-day', '')
    + statCard('Accounts In Stock', inStock, 'fa-box-open', soldCount+' sold')
    + statCard('Pending Funds', pendingFunds, 'fa-clock', pendingFunds>0?'Needs review':'')
    + statCard('Total Orders', purchases.length, 'fa-bag-shopping', '')
    +'</div>'
    +'<div class="card"><div class="card-head"><h3>Recent Purchases</h3><button class="btn btn-outline btn-sm" id="dashAllPurchases">View All</button></div>'
    +'<div class="table-wrap"><table><thead><tr><th>Buyer</th><th>Account</th><th>Type</th><th>Amount</th><th>Date</th></tr></thead><tbody>'
    +(purchases.slice(0,8).map(p=>'<tr><td>'+esc(p.username||p.userId||'—')+'</td><td style="font-weight:800">'+esc(p.platform||'—')+(p.username?' · '+esc(p.username):'')+'</td><td>'+esc(p.type||'')+'</td><td style="font-weight:800;color:var(--indigo)">'+fmt(p.amount)+'</td><td style="font-size:12px;color:var(--muted)">'+timeAgo(p.purchasedAt)+'</td></tr>').join('') || '<tr><td colspan="5" style="text-align:center;padding:24px;color:var(--muted)">No purchases yet</td></tr>')
    +'</tbody></table></div></div>';
  $('dashAllPurchases').onclick=()=>navigate('purchases');
}

/* ============ USERS ============ */
let usersSearchQ='';
function renderUsers(){
  const q=usersSearchQ.toLowerCase();
  const filtered=cache.users.filter(u=>{ if(!q) return true; return (u.username||'').toLowerCase().includes(q)||(u.fullName||'').toLowerCase().includes(q)||(u.email||'').toLowerCase().includes(q)||(u.id||'').toLowerCase().includes(q); });
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Users</h2><p>'+cache.users.length+' total · '+cache.users.filter(u=>u.blocked).length+' blocked</p></div></div>'
    +'<div class="search-row"><div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search by username, email, ID..." id="userSearch" value="'+esc(usersSearchQ)+'"></div></div>'
    +'<div class="table-wrap"><table><thead><tr><th>User</th><th>Balance</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead><tbody>'
    +(filtered.map(u=>'<tr><td><div class="user-cell">'+(u.photoURL?'<img src="'+esc(u.photoURL)+'" class="user-av">':'<div class="user-av">'+esc((u.username||'U').charAt(0).toUpperCase())+'</div>')+'<div class="user-info"><div class="un">'+esc(u.username||u.fullName||'—')+'</div><div class="ue">'+esc(u.email||'')+'</div></div></div></td>'
      +'<td style="font-weight:800;color:var(--indigo)">'+fmt(u.balance||0)+'</td>'
      +'<td>'+(u.blocked?'<span class="badge badge-danger">Blocked</span>':'<span class="badge badge-active">Active</span>')+'</td>'
      +'<td style="font-size:12px;color:var(--muted)">'+fmtDate(u.createdAt)+'</td>'
      +'<td><button class="btn btn-outline btn-sm" data-view-user="'+esc(u.id)+'">View</button></td></tr>').join('') || '<tr><td colspan="5" style="text-align:center;padding:24px;color:var(--muted)">No users found</td></tr>')
    +'</tbody></table></div>';
  const si=$('userSearch');
  if(si) si.oninput=e=>{ usersSearchQ=e.target.value; renderUsers(); };
  document.querySelectorAll('[data-view-user]').forEach(b=>{ b.onclick=()=>openUserDetail(b.dataset.viewUser); });
}
async function openUserDetail(uid){
  const user=cache.users.find(u=>u.id===uid);
  if(!user) return;
  const purchases=cache.purchases.filter(p=>p.userId===uid);
  const txns=cache.transactions.filter(t=>t.userId===uid);
  openModal('User: '+esc(user.username||user.email),
    '<div style="display:flex;gap:14px;align-items:center;margin-bottom:18px">'
    +(user.photoURL?'<img src="'+esc(user.photoURL)+'" style="width:64px;height:64px;border-radius:50%;object-fit:cover">':'<div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--navy),var(--indigo));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:24px">'+esc((user.username||'U').charAt(0).toUpperCase())+'</div>')
    +'<div style="flex:1;min-width:0"><div style="font-weight:800;font-size:16px;color:var(--navy)">'+esc(user.username||'—')+'</div><div style="font-size:12.5px;color:var(--muted)">'+esc(user.email||'')+'</div><div style="font-size:10.5px;color:var(--muted);font-family:monospace;margin-top:2px">'+esc(user.id)+'</div></div></div>'
    +'<div class="detail-row"><span class="dl">Balance</span><span class="dv" style="color:var(--indigo)">'+fmt(user.balance||0)+'</span></div>'
    +'<div class="detail-row"><span class="dl">Status</span><span class="dv">'+(user.blocked?'<span class="badge badge-danger">Blocked</span>':'<span class="badge badge-active">Active</span>')+'</span></div>'
    +'<div class="detail-row"><span class="dl">Joined</span><span class="dv">'+fmtDate(user.createdAt)+'</span></div>'
    +'<div class="detail-row"><span class="dl">Purchases</span><span class="dv">'+purchases.length+'</span></div>'
    +'<div class="detail-row"><span class="dl">Total Spent</span><span class="dv">'+fmt(purchases.reduce((s,p)=>s+(p.amount||0),0))+'</span></div>'
    +'<h4 style="font-size:13.5px;font-weight:800;color:var(--navy);margin:18px 0 10px">Quick Actions</h4>'
    +'<div style="display:grid;gap:8px">'
    +'<button class="btn btn-indigo" id="addBalanceBtn"><i class="fa-solid fa-plus"></i> Add Balance</button>'
    +'<button class="btn btn-outline" id="sendNotifBtn"><i class="fa-regular fa-bell"></i> Send Notification</button>'
    +'<button class="btn '+(user.blocked?'btn-navy':'btn-danger')+'" id="blockToggleBtn"><i class="fa-solid fa-'+(user.blocked?'unlock':'ban')+'"></i> '+(user.blocked?'Unblock User':'Block User')+'</button>'
    +'</div>');
  $('addBalanceBtn').onclick=()=>openAddBalanceModal(user);
  $('sendNotifBtn').onclick=()=>openSendNotifModal(user.id, user.username);
  $('blockToggleBtn').onclick=async()=>{
    try{ await updateDoc(doc(db,'users',uid), { blocked: !user.blocked }); toast('User '+(user.blocked?'unblocked':'blocked'),'success'); closeModal(); }
    catch(ex){ toast('Failed: '+ex.message,'error'); }
  };
}
function openAddBalanceModal(user){
  openModal('Add Balance',
    '<div class="form-group"><label>Amount (Rs.)</label><input type="number" id="addBalanceAmt" placeholder="Enter amount" min="1" value="500"></div>'
    +'<div class="form-group"><label>Note (optional)</label><input type="text" id="addBalanceNote" placeholder="e.g. Manual top-up"></div>'
    +'<div style="background:#fef3c7;border:1px solid #fde68a;padding:11px;border-radius:10px;font-size:12px;color:#92400e">Current balance: <strong>'+fmt(user.balance||0)+'</strong><br>This will add to the user wallet and create a transaction entry.</div>',
    '<button class="btn btn-outline btn-sm" id="cancelAddBal">Cancel</button><button class="btn btn-indigo btn-sm" id="confirmAddBal">Add Balance</button>');
  $('cancelAddBal').onclick=closeModal;
  $('confirmAddBal').onclick=async()=>{
    const amt=Number($('addBalanceAmt').value);
    const note=$('addBalanceNote').value.trim();
    if(!amt||amt<=0){ toast('Invalid amount','error'); return; }
    try{
      const txnId=doc(collection(db,'walletTransactions')).id;
      await runTransaction(db, async tx=>{
        const uRef=doc(db,'users',user.id);
        const uSnap=await tx.get(uRef);
        if(!uSnap.exists()) throw new Error('User missing');
        const newBal=(uSnap.data().balance||0)+amt;
        tx.update(uRef, { balance: newBal });
        tx.set(doc(db,'walletTransactions',txnId), { transactionId:txnId, userId:user.id, type:'credit', category:'admin_add', amount:amt, balanceAfter:newBal, description:note||'Balance added by admin', createdAt:serverTimestamp(), adminEmail:currentUser.email });
      });
      await addDoc(collection(db,'notifications'), { userId:user.id, title:'Balance Added', body:'Admin added '+fmt(amt)+' to your wallet.', read:false, createdAt:serverTimestamp() });
      toast('Added '+fmt(amt)+' to user wallet','success'); closeModal();
    }catch(ex){ toast('Failed: '+ex.message,'error'); }
  };
}
function openSendNotifModal(uid, username){
  openModal('Send Notification',
    '<div class="form-group"><label>Title</label><input type="text" id="nTitle" placeholder="e.g. Important Announcement"></div>'
    +'<div class="form-group"><label>Message</label><textarea id="nBody" placeholder="Type your message..."></textarea></div>'
    +'<div style="font-size:12px;color:var(--muted)">Sending to: <strong>'+esc(username||'User')+'</strong></div>',
    '<button class="btn btn-outline btn-sm" id="cancelNotif">Cancel</button><button class="btn btn-navy btn-sm" id="confirmNotif">Send</button>');
  $('cancelNotif').onclick=closeModal;
  $('confirmNotif').onclick=async()=>{
    const title=$('nTitle').value.trim(), body=$('nBody').value.trim();
    if(!title||!body){ toast('Title and message required','error'); return; }
    try{ await addDoc(collection(db,'notifications'), { userId:uid, title:title, body:body, read:false, createdAt:serverTimestamp() }); toast('Notification sent','success'); closeModal(); }
    catch(ex){ toast('Failed: '+ex.message,'error'); }
  };
}

/* ============ FUNDS ============ */
function renderFunds(){
  const pending=cache.fundRequests.filter(r=>r.status==='pending');
  const history=cache.fundRequests.filter(r=>r.status!=='pending');
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Fund Requests</h2><p>'+pending.length+' pending · '+history.length+' processed</p></div></div>'
    +'<div class="card"><div class="card-head"><h3>Pending Requests ('+pending.length+')</h3></div>'
    +'<div class="table-wrap"><table><thead><tr><th>User</th><th>Amount</th><th>Method</th><th>Proof</th><th>Requested</th><th>Actions</th></tr></thead><tbody>'
    +(pending.map(r=>'<tr><td><div style="font-weight:800">'+esc(r.username||'—')+'</div><div style="font-size:11px;color:var(--muted)">'+esc(r.email||'')+'</div></td><td style="font-weight:800;color:var(--indigo)">'+fmt(r.amount)+'</td><td>'+esc(r.paymentMethod||'—')+'</td><td>'+(r.screenshotURL?'<a href="'+esc(r.screenshotURL)+'" target="_blank" rel="noopener"><img src="'+esc(r.screenshotURL)+'" style="width:44px;height:44px;border-radius:8px;object-fit:cover;border:1px solid var(--border)" alt="proof"></a>':'<span style="color:var(--muted)">—</span>')+'</td><td style="font-size:12px;color:var(--muted)">'+timeAgo(r.createdAt)+'</td><td><button class="btn btn-sm" style="background:var(--success);color:#fff;margin-right:4px" data-approve="'+esc(r.id)+'">Approve</button><button class="btn btn-sm" style="background:var(--danger);color:#fff" data-reject="'+esc(r.id)+'">Reject</button></td></tr>').join('') || '<tr><td colspan="6" style="text-align:center;padding:24px;color:var(--muted)">No pending requests</td></tr>')
    +'</tbody></table></div></div>'
    +'<div class="card"><div class="card-head"><h3>History</h3></div>'
    +'<div class="table-wrap"><table><thead><tr><th>User</th><th>Amount</th><th>Method</th><th>Proof</th><th>Status</th><th>Reviewed</th></tr></thead><tbody>'
    +(history.map(r=>'<tr><td>'+esc(r.username||'—')+'</td><td style="font-weight:800">'+fmt(r.amount)+'</td><td>'+esc(r.paymentMethod||'—')+'</td><td>'+(r.screenshotURL?'<a href="'+esc(r.screenshotURL)+'" target="_blank" rel="noopener"><img src="'+esc(r.screenshotURL)+'" style="width:44px;height:44px;border-radius:8px;object-fit:cover;border:1px solid var(--border)" alt="proof"></a>':'<span style="color:var(--muted)">—</span>')+'</td><td><span class="badge badge-'+(r.status==='approved'?'success':'danger')+'">'+esc(r.status)+'</span></td><td style="font-size:12px;color:var(--muted)">'+timeAgo(r.reviewedAt||r.createdAt)+'</td></tr>').join('') || '<tr><td colspan="6" style="text-align:center;padding:24px;color:var(--muted)">No history yet</td></tr>')
    +'</tbody></table></div></div>';
  document.querySelectorAll('[data-approve]').forEach(b=>{ b.onclick=()=>approveFund(b.dataset.approve); });
  document.querySelectorAll('[data-reject]').forEach(b=>{ b.onclick=()=>rejectFund(b.dataset.reject); });
}
async function approveFund(reqId){
  const req=cache.fundRequests.find(r=>r.id===reqId);
  if(!req) return;
  try{
    const txnId=doc(collection(db,'walletTransactions')).id;
    await runTransaction(db, async tx=>{
      const reqRef=doc(db,'fundRequests',reqId);
      const reqSnap=await tx.get(reqRef);
      if(!reqSnap.exists()) throw new Error('Request missing');
      if(reqSnap.data().status!=='pending') throw new Error('Already processed');
      const uRef=doc(db,'users',req.userId);
      const uSnap=await tx.get(uRef);
      if(!uSnap.exists()) throw new Error('User missing');
      const newBal=(uSnap.data().balance||0)+req.amount;
      tx.update(uRef, { balance: newBal });
      tx.update(reqRef, { status:'approved', reviewedAt:serverTimestamp(), reviewedBy:currentUser.email });
      tx.set(doc(db,'walletTransactions',txnId), { transactionId:txnId, userId:req.userId, type:'credit', category:'fund_approved', amount:req.amount, balanceAfter:newBal, description:'Fund request approved ('+req.paymentMethod+')', createdAt:serverTimestamp(), referenceId:reqId });
    });
    await addDoc(collection(db,'notifications'), { userId:req.userId, title:'Balance Added', body:'Your fund request of '+fmt(req.amount)+' has been approved.', read:false, createdAt:serverTimestamp() });
    toast('Approved '+fmt(req.amount),'success');
  }catch(ex){ toast('Failed: '+ex.message,'error'); }
}
async function rejectFund(reqId){
  const req=cache.fundRequests.find(r=>r.id===reqId);
  if(!req) return;
  if(!confirm('Reject this request for '+fmt(req.amount)+'?')) return;
  try{
    await updateDoc(doc(db,'fundRequests',reqId), { status:'rejected', reviewedAt:serverTimestamp(), reviewedBy:currentUser.email });
    await addDoc(collection(db,'notifications'), { userId:req.userId, title:'Fund Request Rejected', body:'Your fund request of '+fmt(req.amount)+' was rejected. Contact support.', read:false, createdAt:serverTimestamp() });
    toast('Request rejected','success');
  }catch(ex){ toast('Failed: '+ex.message,'error'); }
}

/* ============ TRANSACTIONS + PURCHASES ============ */
function renderTransactions(){
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Transactions</h2><p>Last '+cache.transactions.length+' wallet movements</p></div></div>'
    +'<div class="table-wrap"><table><thead><tr><th>User</th><th>Type</th><th>Category</th><th>Amount</th><th>Balance After</th><th>Date</th></tr></thead><tbody>'
    +(cache.transactions.map(t=>{ const u=cache.users.find(x=>x.id===t.userId); return '<tr><td>'+esc(u?.username||t.userId||'—')+'</td><td><span class="badge '+(t.type==='credit'?'badge-success':'badge-danger')+'">'+esc(t.type||'')+'</span></td><td>'+esc(t.category||'—')+'</td><td style="font-weight:800;color:'+(t.type==='credit'?'var(--success)':'var(--danger)')+'">'+(t.type==='credit'?'+':'−')+fmt(t.amount)+'</td><td>'+fmt(t.balanceAfter||0)+'</td><td style="font-size:12px;color:var(--muted)">'+timeAgo(t.createdAt)+'</td></tr>'; }).join('') || '<tr><td colspan="6" style="text-align:center;padding:24px;color:var(--muted)">No transactions yet</td></tr>')
    +'</tbody></table></div>';
}
function renderPurchases(){
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Purchases</h2><p>'+cache.purchases.length+' account purchases</p></div></div>'
    +'<div class="table-wrap"><table><thead><tr><th>Buyer</th><th>Account</th><th>Type</th><th>Amount</th><th>Date</th><th>Login Details</th></tr></thead><tbody>'
    +(cache.purchases.map(p=>{ const u=cache.users.find(x=>x.id===p.userId); return '<tr><td>'+esc(u?.username||p.userId||'—')+'<div style="font-size:11px;color:var(--muted)">'+esc(u?.email||'')+'</div></td><td style="font-weight:800">'+esc(p.platform||'—')+(p.username?' · '+esc(p.username):'')+'</td><td>'+esc(p.type||'')+'</td><td style="font-weight:800;color:var(--indigo)">'+fmt(p.amount)+'</td><td style="font-size:12px;color:var(--muted)">'+timeAgo(p.purchasedAt)+'</td><td><button class="btn btn-outline btn-sm" data-secrets="'+esc(p.id)+'">View</button></td></tr>'; }).join('') || '<tr><td colspan="6" style="text-align:center;padding:24px;color:var(--muted)">No purchases yet</td></tr>')
    +'</tbody></table></div>';
  document.querySelectorAll('[data-secrets]').forEach(b=>{ b.onclick=()=>viewSecrets(b.dataset.secrets); });
}
async function viewSecrets(id){
  try{
    const s=await getDoc(doc(db,'accountSecrets',id));
    if(!s.exists()){ toast('No login details saved for this account','error'); return; }
    const d=s.data();
    openModal('Login Details',
      '<div class="detail-row"><span class="dl">Email / Username</span><span class="dv">'+esc(d.loginEmail||'—')+'</span></div>'
      +'<div class="detail-row"><span class="dl">Password</span><span class="dv">'+esc(d.loginPassword||'—')+'</span></div>'
      +(d.accountLink?'<div class="detail-row"><span class="dl">Account Link</span><span class="dv">'+esc(d.accountLink)+'</span></div>':'')
      +(d.loginNote?'<div class="detail-row"><span class="dl">Note</span><span class="dv">'+esc(d.loginNote)+'</span></div>':''));
  }catch(ex){ toast('Failed: '+ex.message,'error'); }
}

/* ============ ACCOUNT CRUD (shared for Social + Premium) ============ */
function premCalcAdmin(a){
  const total=Math.max(1, Number(a.validDays)||30);
  const elapsed=Math.floor((Date.now()-msOf(a.createdAt))/86400000);
  const daysLeft=Math.max(0, total-elapsed);
  return { daysLeft:daysLeft, total:total, price:Math.round(daysLeft/total*(Number(a.originalPrice)||0)) };
}
function renderAccountsPage(prem){
  const list = prem ? cache.premiumAccounts : cache.socialAccounts;
  const title = prem ? 'Premium Accounts' : 'Social Accounts';
  const sub = prem ? 'Canva Pro, CapCut Pro, Google One and more' : 'TikTok, YouTube, Instagram, Facebook';
  $('content').innerHTML =
    '<div class="page-header"><div><h2>'+title+'</h2><p>'+sub+' · '+list.length+' total · '+list.filter(a=>!a.sold).length+' in stock</p></div>'
    +'<div class="actions"><button class="btn btn-navy btn-sm" id="addAccBtn"><i class="fa-solid fa-plus"></i> Add Account</button></div></div>'
    +'<div class="item-grid">'
    +(list.map(a=>{
      const price = prem ? premCalcAdmin(a).price : (Number(a.price)||0);
      return '<div class="item-card">'
        +(a.logoURL?'<img src="'+esc(a.logoURL)+'" class="ic-img" alt="">':'<div class="ic-img" style="display:flex;align-items:center;justify-content:center;padding:20px">'+svgBrand(a.platform)+'</div>')
        +'<div class="ic-title">'+esc(a.platform||'Account')+' — '+esc(a.username||'N/A')+'</div>'
        +'<div class="ic-desc">'+esc(a.description||'No description')+'</div>'
        +'<div class="ic-meta"><span>'+(prem?premCalcAdmin(a).daysLeft+' days left':esc(a.followers||'—')+' followers')+'</span><span>'+fmt(price)+'</span><span>'+(a.sold?'<span class="badge badge-danger">Sold</span>':'<span class="badge badge-active">Available</span>')+'</span></div>'
        +'<div class="ic-actions"><button class="btn-edit" data-edit="'+esc(a.id)+'">Edit</button><button class="btn-del" data-del="'+esc(a.id)+'">Delete</button></div>'
        +'</div>';
    }).join('') || '<div class="empty" style="grid-column:1/-1"><i class="fa-solid fa-box-open"></i><p>No accounts added yet</p></div>')
    +'</div>';
  $('addAccBtn').onclick=()=>openAccountForm(prem, null);
  document.querySelectorAll('[data-edit]').forEach(b=>{ b.onclick=()=>openAccountForm(prem, b.dataset.edit); });
  document.querySelectorAll('[data-del]').forEach(b=>{ b.onclick=async()=>{ if(!confirm('Delete this account?')) return; try{ await deleteDoc(doc(db, prem?'premiumAccounts':'socialAccounts', b.dataset.del)); await deleteDoc(doc(db,'accountSecrets', b.dataset.del)).catch(()=>{}); toast('Account deleted','success'); }catch(ex){ toast('Failed: '+ex.message,'error'); } }; });
}
function renderSocialAccounts(){ renderAccountsPage(false); }
function renderPremiumAccounts(){ renderAccountsPage(true); }

function openAccountForm(prem, id){
  const col = prem ? 'premiumAccounts' : 'socialAccounts';
  const list = prem ? cache.premiumAccounts : cache.socialAccounts;
  const it = id ? list.find(x=>x.id===id) : null;
  const platforms = prem ? ['Canva Pro','CapCut Pro','Google One','Netflix','Spotify','ChatGPT Plus'] : ['TikTok','YouTube','Instagram','Facebook'];
  openModal(it?'Edit Account':'Add '+(prem?'Premium':'Social')+' Account',
    '<div class="form-grid">'
    +'<div class="form-group"><label>Platform</label><select id="accPlatform">'+platforms.map(p=>'<option value="'+p+'"'+(it?.platform===p?' selected':'')+'>'+p+'</option>').join('')+'<option value="Other"'+(it&&!platforms.includes(it.platform)?' selected':'')+'>Other</option></select></div>'
    +'<div class="form-group"><label>Username</label><input id="accUsername" value="'+esc(it?.username||'')+'"></div></div>'
    +'<div class="form-group"><label>Description</label><textarea id="accDesc">'+esc(it?.description||'')+'</textarea></div>'
    +'<div class="form-group"><label>Account Link (URL)</label><input id="accLink" value="'+esc(it?.accountLink||'')+'" placeholder="https://..."></div>'
    +'<div class="form-grid">'
    +(prem
      ? '<div class="form-group"><label>Original Price (Rs.)</label><input type="number" id="accPrice" value="'+(it?.originalPrice||0)+'" min="0"></div>'
        +'<div class="form-group"><label>Valid Days</label><input type="number" id="accValidDays" value="'+(it?.validDays||30)+'" min="1"></div>'
      : '<div class="form-group"><label>Followers</label><input id="accFollowers" value="'+esc(it?.followers||'')+'"></div>'
        +'<div class="form-group"><label>Country</label><input id="accCountry" value="'+esc(it?.country||'')+'"></div>'
        +'<div class="form-group"><label>Price (Rs.)</label><input type="number" id="accPrice" value="'+(it?.price||0)+'" min="0"></div>')
    +'</div>'
    +'<div class="form-group"><label>Login Email / Username</label><input id="accEmail" value=""></div>'
    +'<div class="form-group"><label>Login Password</label><input type="text" id="accPassword" value="" placeholder="Hidden from user until purchase"></div>'
    +'<div class="form-group"><label>Login Note (optional)</label><input type="text" id="accLoginNote" value="" placeholder="e.g. 2FA code, recovery email, extra info"></div>'
    +'<div class="form-group"><label>Logo — Upload File</label><input type="file" id="accLogoFile" accept="image/*"><div class="help-text">Real brand logo upload karein — file se data URL ban kar save hoga (no Storage needed). Ya neeche link paste karein.</div>'
    +'<label style="margin-top:10px;display:block;font-size:12.5px;font-weight:800;color:var(--navy)">Logo Image URL (paste link — fallback)</label><input type="url" id="accLogoURL" value="'+esc((it?.logoURL||'').startsWith('data:')?'':(it?.logoURL||''))+'" placeholder="https://.../logo.png">'
    +'<img id="accLogoPreview" class="preview-img'+(it?.logoURL?'':' hidden')+'" src="'+esc(it?.logoURL||'')+'"></div>'
    +'<div class="form-group"><label>Account Screenshots (paste image links — one URL per line)</label><textarea id="accScreensURLs" placeholder="https://.../shot1.png\nhttps://.../shot2.png">'+esc((it?.screenshots||[]).join('\n'))+'</textarea><div class="help-text">Paste one image link per line. No file upload.</div>'
    +'<div id="accScreensPreview" style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px">'+(it?.screenshots||[]).map(s=>'<img src="'+esc(s)+'" style="width:60px;height:60px;border-radius:8px;object-fit:cover">').join('')+'</div></div>',
    '<button class="btn btn-outline btn-sm" id="cancelAcc">Cancel</button><button class="btn btn-navy btn-sm" id="saveAcc">Save Account</button>');
  // Logo: file upload (accLogoFile -> data URL in logoURL) OR pasted URL
  // (accLogoURL). Login (accEmail/accPassword/accLoginNote) is in the SAME
  // form and saved to accountSecrets together with the product doc.
  // Screenshots stay URL-paste (accScreensURLs).
  if(it) getDoc(doc(db,'accountSecrets',id)).then(sn=>{ if(sn.exists()){ $('accEmail').value=sn.data().loginEmail||''; $('accPassword').value=sn.data().loginPassword||''; $('accLoginNote').value=sn.data().loginNote||''; } }).catch(()=>{});
  let logoDataURL='';
  $('accLogoFile').onchange=async e=>{ const f=e.target.files[0]; if(!f) return; try{ logoDataURL=await readImageDataURL(f,256,0.85); $('accLogoPreview').src=logoDataURL; $('accLogoPreview').classList.remove('hidden'); toast('Logo loaded','success'); }catch(ex){ toast(ex.message,'error'); e.target.value=''; } };
  $('cancelAcc').onclick=closeModal;
  $('accLogoURL').oninput=e=>{ const u=e.target.value.trim(); $('accLogoPreview').src=u; $('accLogoPreview').classList.toggle('hidden', !u); };
  $('accScreensURLs').oninput=e=>{ const urls=e.target.value.split('\n').map(s=>s.trim()).filter(Boolean); $('accScreensPreview').innerHTML=urls.map(u=>'<img src="'+esc(u)+'" style="width:60px;height:60px;border-radius:8px;object-fit:cover">').join(''); };
  $('saveAcc').onclick=async()=>{
    const btn=$('saveAcc'); btn.disabled=true; btn.innerHTML='<span class="loader"></span>';
    try{
      const aid = id || doc(collection(db,col)).id;
      const logoURL = logoDataURL || $('accLogoURL').value.trim();
      const screenshots = $('accScreensURLs').value.split('\n').map(s=>s.trim()).filter(Boolean);
      const base = {
        platform: $('accPlatform').value.trim(),
        username: $('accUsername').value.trim(),
        description: $('accDesc').value.trim(),
        accountLink: $('accLink').value.trim(),
        logoURL: logoURL, screenshots: screenshots,
        sold: it?.sold || false,
        createdAt: it?.createdAt || serverTimestamp(),
        updatedAt: serverTimestamp()
      };
      if(prem){ base.originalPrice=Number($('accPrice').value)||0; base.validDays=Number($('accValidDays').value)||30; }
      else { base.followers=$('accFollowers').value.trim(); base.country=$('accCountry').value.trim(); base.price=Number($('accPrice').value)||0; }
      await setDoc(doc(db,col,aid), base, { merge:true });
      await setDoc(doc(db,'accountSecrets',aid), { loginEmail:$('accEmail').value.trim(), loginPassword:$('accPassword').value.trim(), loginNote:$('accLoginNote').value.trim(), accountLink:$('accLink').value.trim() }, { merge:true });
      toast('Account saved','success'); closeModal();
    }catch(ex){ toast('Failed: '+ex.message,'error'); btn.disabled=false; btn.innerHTML='Save Account'; }
  };
}

/* ============ BANNERS ============ */
function renderBanners(){
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Banners</h2><p>Home page slider images</p></div><div class="actions"><button class="btn btn-navy btn-sm" id="addBannerBtn"><i class="fa-solid fa-plus"></i> Add Banner</button></div></div>'
    +'<div class="item-grid">'
    +(cache.banners.map(b=>'<div class="item-card">'
      +(b.imageURL?'<img src="'+esc(b.imageURL)+'" class="ic-img" style="object-fit:cover;padding:0">':'<div class="ic-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:28px"><i class="fa-solid fa-image"></i></div>')
      +'<div class="ic-title">'+esc(b.title||'Banner')+'</div>'
      +'<div class="ic-desc">'+esc(b.description||'')+'</div>'
      +'<div class="ic-meta"><span>'+(b.active?'<span class="badge badge-active">Active</span>':'<span class="badge badge-inactive">Hidden</span>')+'</span></div>'
      +'<div class="ic-actions"><button class="btn-toggle" data-toggle-banner="'+esc(b.id)+'">'+(b.active?'Hide':'Show')+'</button><button class="btn-del" data-del-banner="'+esc(b.id)+'">Delete</button></div>'
      +'</div>').join('') || '<div class="empty" style="grid-column:1/-1"><i class="fa-solid fa-images"></i><p>No banners yet</p></div>')
    +'</div>';
  $('addBannerBtn').onclick=()=>openBannerForm();
  document.querySelectorAll('[data-toggle-banner]').forEach(b=>{ b.onclick=async()=>{ const it=cache.banners.find(x=>x.id===b.dataset.toggleBanner); try{ await updateDoc(doc(db,'banners',it.id), { active: !it.active }); }catch(ex){ toast('Failed: '+ex.message,'error'); } }; });
  document.querySelectorAll('[data-del-banner]').forEach(b=>{ b.onclick=async()=>{ if(!confirm('Delete this banner?')) return; try{ await deleteDoc(doc(db,'banners',b.dataset.delBanner)); toast('Banner deleted','success'); }catch(ex){ toast('Failed: '+ex.message,'error'); } }; });
}
function openBannerForm(){
  openModal('Add Banner',
    '<div class="form-group"><label>Title</label><input id="bnTitle" placeholder="e.g. Big Sale"></div>'
    +'<div class="form-group"><label>Description</label><textarea id="bnDesc" placeholder="Short description..."></textarea></div>'
    +'<div class="form-group"><label>Banner Image URL (paste link)</label><input type="url" id="bnImageURL" placeholder="https://.../banner.png"><div class="help-text">Paste an image link for the banner. No file upload.</div><img id="bnPreview" class="preview-img hidden" src=""></div>'
    +'<div class="form-group"><label><input type="checkbox" id="bnActive" checked style="width:16px;height:16px;accent-color:var(--indigo)"> Active (show on home page)</label></div>',
    '<button class="btn btn-outline btn-sm" id="cancelBn">Cancel</button><button class="btn btn-navy btn-sm" id="saveBn">Save Banner</button>');
  $('cancelBn').onclick=closeModal;
  $('bnImageURL').oninput=e=>{ const u=e.target.value.trim(); $('bnPreview').src=u; $('bnPreview').classList.toggle('hidden', !u); };
  $('saveBn').onclick=async()=>{
    const btn=$('saveBn'); btn.disabled=true; btn.innerHTML='<span class="loader"></span>';
    try{
      const imageURL=$('bnImageURL').value.trim();
      await addDoc(collection(db,'banners'), { title:$('bnTitle').value.trim(), description:$('bnDesc').value.trim(), imageURL:imageURL, active:$('bnActive').checked, createdAt:serverTimestamp() });
      toast('Banner saved','success'); closeModal();
    }catch(ex){ toast('Failed: '+ex.message,'error'); btn.disabled=false; btn.innerHTML='Save Banner'; }
  };
}

/* ============ NOTIFICATIONS ============ */
function renderNotifications(){
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Notifications</h2><p>Send a message to one user or everyone</p></div></div>'
    +'<div class="card"><div class="card-head"><h3>Send Notification</h3></div>'
    +'<div class="form-group"><label>Send To</label><select id="notifTarget"><option value="all">All Users</option>'+cache.users.map(u=>'<option value="'+esc(u.id)+'">'+esc(u.username||u.email||u.id)+'</option>').join('')+'</select></div>'
    +'<div class="form-group"><label>Title</label><input id="notifTitle" placeholder="e.g. New accounts added"></div>'
    +'<div class="form-group"><label>Message</label><textarea id="notifBody" placeholder="Type your message..."></textarea></div>'
    +'<button class="btn btn-navy" id="sendNotifAll" style="max-width:220px"><i class="fa-regular fa-bell"></i> Send Notification</button></div>'
    +'<div class="card"><div class="card-head"><h3>Recent ('+cache.notifications.length+')</h3></div>'
    +(cache.notifications.slice(0,20).map(n=>{ const u=cache.users.find(x=>x.id===n.userId); return '<div class="detail-row"><span class="dl">'+esc(n.title||'')+' → '+esc(u?.username||n.userId||'')+'</span><span class="dv" style="font-weight:600;color:var(--muted)">'+timeAgo(n.createdAt)+'</span></div>'; }).join('') || '<p style="color:var(--muted);font-size:13px">No notifications sent yet</p>')
    +'</div>';
  $('sendNotifAll').onclick=async()=>{
    const target=$('notifTarget').value, title=$('notifTitle').value.trim(), body=$('notifBody').value.trim();
    if(!title||!body){ toast('Title and message required','error'); return; }
    try{
      const targets = target==='all' ? cache.users.map(u=>u.id) : [target];
      for(const uid of targets){ await addDoc(collection(db,'notifications'), { userId:uid, title:title, body:body, read:false, createdAt:serverTimestamp() }); }
      toast('Sent to '+targets.length+' user(s)','success');
      $('notifTitle').value=''; $('notifBody').value='';
    }catch(ex){ toast('Failed: '+ex.message,'error'); }
  };
}

/* ============ SETTINGS ============ */
function renderSettings(){
  const s=cache.settings;
  const links=s.socialLinks||{};
  $('content').innerHTML =
    '<div class="page-header"><div><h2>Settings</h2><p>Store configuration — logo, WhatsApp, social links</p></div></div>'
    +'<div class="card"><div class="card-head"><h3>General Settings</h3></div>'
    +'<div class="form-grid">'
    +'<div class="form-group"><label>Store Name</label><input id="setName" value="'+esc(s.websiteName||'TolifyHub')+'"></div>'
    +'<div class="form-group"><label>Currency</label><input id="setCurrency" value="'+esc(s.currency||'PKR')+'"></div>'
    +'<div class="form-group"><label>WhatsApp Number</label><input id="setWa" value="'+esc(s.whatsappNumber||'')+'" placeholder="923001234567"></div>'
    +'<div class="form-group"><label>Admin Email</label><input id="setAdminEmail" value="'+esc(s.adminEmail||'')+'" placeholder="admin@tolifyhub.com"></div>'
    +'</div>'
    +'<div class="form-group"><label>Store Logo — Upload File</label><input type="file" id="setLogoFile" accept="image/*"><div class="help-text">Logo upload karein — file se data URL ban kar save hoga. Ya neeche link paste karein. Ye logo login / register page ke top par fixed dikhega.</div>'
    +'<label style="margin-top:10px;display:block;font-size:12.5px;font-weight:800;color:var(--navy)">Logo Image URL (paste link — fallback)</label><input type="url" id="setLogoURL" value="'+esc((s.logoURL||'').startsWith('data:')?'':(s.logoURL||''))+'" placeholder="https://.../logo.png">'
    +'<img id="logoPreview" class="preview-img'+(s.logoURL?'':' hidden')+'" src="'+esc(s.logoURL||'')+'"></div>'
    +'<h4 style="font-size:14px;font-weight:800;color:var(--navy);margin:18px 0 12px">Social Links (shown in footer + drawer)</h4>'
    +'<div class="form-grid">'
    +'<div class="form-group"><label>TikTok URL</label><input id="setTiktok" value="'+esc(links.tiktok||'')+'" placeholder="https://tiktok.com/@tolifyhub"></div>'
    +'<div class="form-group"><label>Instagram URL</label><input id="setInstagram" value="'+esc(links.instagram||'')+'" placeholder="https://instagram.com/tolifyhub"></div>'
    +'<div class="form-group"><label>YouTube URL</label><input id="setYoutube" value="'+esc(links.youtube||'')+'" placeholder="https://youtube.com/@tolifyhub"></div>'
    +'<div class="form-group"><label>Facebook URL</label><input id="setFacebook" value="'+esc(links.facebook||'')+'" placeholder="https://facebook.com/tolifyhub"></div>'
    +'</div>'
    +'<button class="btn btn-navy" id="saveSettingsBtn" style="max-width:220px"><i class="fa-solid fa-save"></i> Save Settings</button></div>';
  $('setLogoURL').oninput=e=>{ const u=e.target.value.trim(); $('logoPreview').src=u; $('logoPreview').classList.toggle('hidden', !u); };
  let setLogoDataURL='';
  $('setLogoFile').onchange=async e=>{ const f=e.target.files[0]; if(!f) return; try{ setLogoDataURL=await readImageDataURL(f,256,0.85); $('logoPreview').src=setLogoDataURL; $('logoPreview').classList.remove('hidden'); toast('Logo loaded','success'); }catch(ex){ toast(ex.message,'error'); e.target.value=''; } };
  $('saveSettingsBtn').onclick=async()=>{
    const btn=$('saveSettingsBtn'); btn.disabled=true; btn.innerHTML='<span class="loader"></span>';
    try{
      const logoURL=setLogoDataURL||$('setLogoURL').value.trim();
      await setDoc(doc(db,'settings','config'), {
        websiteName: $('setName').value.trim(),
        currency: $('setCurrency').value.trim(),
        whatsappNumber: $('setWa').value.trim(),
        adminEmail: $('setAdminEmail').value.trim(),
        logoURL: logoURL,
        socialLinks: {
          whatsapp: $('setWa').value.trim() ? whatsappLink($('setWa').value.trim()) : '',
          tiktok: $('setTiktok').value.trim(),
          instagram: $('setInstagram').value.trim(),
          youtube: $('setYoutube').value.trim(),
          facebook: $('setFacebook').value.trim()
        },
        updatedAt: serverTimestamp()
      }, { merge:true });
      toast('Settings saved','success');
    }catch(ex){ toast('Failed: '+ex.message,'error'); }
    btn.disabled=false; btn.innerHTML='<i class="fa-solid fa-save"></i> Save Settings';
  };
}

/* ============ INIT ============ */
window.addEventListener('error', e=>console.error('JS:', e.message));
</script>
</body>
</html>
