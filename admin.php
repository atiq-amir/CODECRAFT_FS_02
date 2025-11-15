<?php
session_start();
include 'config.php';
if(!isset($_SESSION['admin_id']) || ($_SESSION['admin_role'] ?? '') !== 'admin') {
    echo "<h2 style='text-align:center; margin-top:50px; color:red;'>Access Denied! Only admins can access this page.</h2>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet"> 
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
    <style>
:root {
    --c1: rgb(241, 243, 224);
    --c2: rgb(210, 220, 182);
    --c3: rgb(161, 188, 152);
    --c4: rgb(119, 136, 115);
    --text-dark: #2d2d2d;
    --text-light: #ffffff;
}
body {
    margin: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: var(--c1);
    color: var(--text-dark);
    display: flex;
    min-height: 100vh;
}

/* ----------  SIDEBAR  ---------- */
.sidebar {
    width: 250px;
    background: var(--c4);
    color: var(--text-light);
    display: flex;
    flex-direction: column;
    padding: 20px;
    box-sizing: border-box;
    transition: transform .3s ease;
}
.sidebar img { width: 180px; margin: 0 auto 20px; display: block; }
.sidebar h3 { text-align: center; margin: 0 0 25px; font-size: 22px; }

/* ----------  TOPBAR  ---------- */
.topbar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px 20px;
    background: var(--c2);
    position: relative;
    box-shadow: 0 2px 5px rgba(0,0,0,.1);
}
.profile-dropdown { position: relative; margin-left: 15px; }
.pfp {
    width: 40px; height: 40px; border-radius: 50%; cursor: pointer;
    object-fit: cover; border: 2px solid var(--c3); transition: .25s;
}
.pfp:hover { border-color: var(--c4); }
.dropdown-menu {
    display: none; position: absolute; top: 50px; right: 0;
    background: var(--c2); border: 1px solid var(--c3);
    border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,.2);
    min-width: 120px; z-index: 100;
}
.dropdown-menu a {
    display: block; padding: 10px 15px; color: var(--text-dark);
    text-decoration: none; font-size: 14px; transition: .2s;
}
.dropdown-menu a:hover { background: var(--c3); color: var(--text-light); }

/* ----------  NAV ITEMS  ---------- */
.nav-item {
    display: block; padding: 12px 20px; margin: 5px 0;
    background: var(--c2); color: var(--text-dark);
    border-radius: 8px; text-decoration: none; transition: .25s;
}
.nav-item:hover { background: var(--c3); color: var(--text-light); }

/* ----------  CARDS  ---------- */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px; padding: 25px;
}
.card {
    padding: 25px; background: var(--c2); border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,.1); text-align: center;
    transition: .3s;
}
.card:hover { background: var(--c3); transform: translateY(-5px); }
.card h3 { margin: 0; font-size: 22px; }
.card p { margin-top: 10px; font-size: 14px; }

/* -------------------------------------------------
   RESPONSIVE BREAK-POINTS  (CSS-ONLY)
   ------------------------------------------------- */

/* ≥ 992 px : default desktop – keep side-by-side layout */
@media (min-width: 992px) {
    .content { flex: 1; display: flex; flex-direction: column; }
}

/* < 992 px : stack sidebar & content, turn sidebar into slide-in drawer */
@media (max-width: 991.98px) {
    body { flex-direction: column; }
    .sidebar {
        position: fixed; top: 0; left: 0; height: 100vh; z-index: 1100;
        transform: translateX(-100%);
    }
    .sidebar.show { transform: translateX(0); }

    /* hamburger button (created by CSS) */
    .menu-toggle {
        position: fixed; top: 15px; left: 15px; width: 44px; height: 44px;
        background: var(--c4); color: #fff; border: none; border-radius: 6px;
        font-size: 24px; cursor: pointer; z-index: 1200;
        display: flex; align-items: center; justify-content: center;
    }
    /* overlay curtain when sidebar open */
    .sidebar-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,.45);
        z-index: 1090; display: none;
    }
    .sidebar-overlay.show { display: block; }
}

/* ≤ 576 px : tiny phones – reduce font & card padding */
@media (max-width: 576px) {
    .card { padding: 18px; }
    .card h3 { font-size: 18px; }
    .topbar { font-size: 16px; padding: 8px 15px; }
    .pfp { width: 34px; height: 34px; }
}
/* ----------  SMALL-SCREEN TOGGLE  ---------- */
/* hide toggle & overlay on big screens */
.menu-toggle,
.sidebar-overlay {
    display: none;
}

@media (max-width: 991.98px) {
    /* hamburger button */
    .menu-toggle {
        display: block;
        position: fixed;
        top: 15px;
        left: 15px;
        width: 44px;
        height: 44px;
        background: var(--c4);
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 24px;
        line-height: 44px;
        text-align: center;
        cursor: pointer;
        z-index: 1200;
    }
    /* invisible checkbox */
    #sidebar-toggle {
        display: none;
    }
    /* when checkbox checked → show sidebar */
    #sidebar-toggle:checked ~ .sidebar {
        display: flex;
    }
    /* optional: dim content while sidebar open */
    #sidebar-toggle:checked ~ .sidebar-overlay {
        display: block;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1090;
    }
    /* ----------  SMALL-SCREEN SLIDE TOGGLE  ---------- */
.menu-toggle,
.sidebar-overlay { display: none; }

@media (max-width: 991.98px) {
    .menu-toggle {                     /* ☰ button */
        display: block;
        position: fixed;
        top: 15px;
        left: 15px;
        width: 44px;
        height: 44px;
        background: var(--c4);
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 24px;
        line-height: 44px;
        text-align: center;
        cursor: pointer;
        z-index: 1200;
    }
    .sidebar-overlay {                 /* dim background */
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 1090;
        display: none;
    }
    #sidebar-toggle:checked ~ .sidebar-overlay { display: block; }

    /* sidebar starts off-screen */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        transform: translateX(-100%);
        z-index: 1100;
    }
    /* slide in when checkbox is checked */
    #sidebar-toggle:checked ~ .sidebar { transform: translateX(0); }
}
}
    </style>
</head>
<body>
    <!-- hidden checkbox + label (hamburger) -->
<input type="checkbox" id="sidebar-toggle" hidden>
<label for="sidebar-toggle" class="menu-toggle">☰</label>
<!-- optional overlay -->
<label for="sidebar-toggle" class="sidebar-overlay"></label>
    <div class="sidebar">
        <img src="./images/logo.png" alt="Logo" style="width:180px;margin:0 auto 20px;display:block;" />
        <h3>Admin Panel</h3>
        <a href="admin.php" class="nav-item">Dashboard</a>
        <a href="employees.php" class="nav-item">Employees</a>
        <a href="add_employee.php" class="nav-item">Add Employee</a>
        <a href="settings.php" class="nav-item">Settings</a>

        
    </div>

    <div class="content">
        <div class="topbar">
    <?php if (isset($_SESSION['admin_id'])): ?>
        <span class="text-dark fw-semibold ms-2 d-none d-sm-inline">
            Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?>
        </span>
        <div class="profile-dropdown">
            <img src="images/<?= htmlspecialchars($_SESSION['admin_pfp'] ?? 'default.png') ?>" 
                 alt="Profile" class="pfp" id="pfpToggle">
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    <?php endif; ?>
</div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Employees</h3>
                <p>120</p>
            </div>

            <div class="card">
                <h3>New Registrations</h3>
                <p>8 this week</p>
            </div>

            <div class="card">
                <h3>Pending Approvals</h3>
                <p>3 employees</p>
            </div>
        </div>
    </div>
    <script>
const pfpToggle = document.getElementById('pfpToggle');
const dropdownMenu = document.getElementById('dropdownMenu');

pfpToggle.addEventListener('click', () => {
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
});

// Close dropdown if clicked outside
window.addEventListener('click', (e) => {
    if (!pfpToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.style.display = 'none';
    }
});
</script>

</body>
</html>
