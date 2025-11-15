<?php
session_start();
include 'config.php';
if(!isset($_SESSION['admin_id']) || ($_SESSION['admin_role'] ?? '') !== 'admin') {
    echo "<h2 style='text-align:center; margin-top:50px; color:red;'>Access Denied! Only admins can access this page.</h2>";
    exit();
}
if (isset($_POST['add_employee'])) {
    $first_name = mysqli_real_escape_string($connect, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($connect, $_POST['last_name']);
    $email      = mysqli_real_escape_string($connect, $_POST['email']);
    $contact    = mysqli_real_escape_string($connect, $_POST['contact']);
    $salary     = (float)$_POST['salary'];
    $sql = "INSERT INTO `employees`
            (`first_name`, `last_name`, `email`, `contact`, `salary`, `added_at`, `updated_at`)
            VALUES ('$first_name', '$last_name', '$email', '$contact', $salary, NOW(), NOW())";

    if (mysqli_query($connect, $sql)) {
        echo "<script>alert('Employee added successfully');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
    }
    header('Location: employees.php');
    exit;
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
        /* Color Theme */
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
        }
        html, body {
        max-width: 100vw;
        overflow-x: hidden;
        }
        @media (max-width: 575px) {
            .topbar {
                font-size: 16px;
            }
            .pfp {
                width: 32px;
                height: 32px;
            }
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            height: auto;
            background: var(--c4);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 22px;
            text-align: center;
            font-weight: 600;
        }

        .nav-item {
            margin: 12px 0;
            padding: 12px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .nav-item:hover {
            background: var(--c3);
        }

       
        /* Main Content */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 25px;
        }

        .card {
            padding: 25px;
            background: var(--c2);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: 0.3s;
        }

        .card:hover {
            background: var(--c3);
            transform: translateY(-5px);
        }

        .card h3 {
            margin: 0;
            font-size: 22px;
        }

        .card p {
            margin-top: 10px;
            font-size: 14px;
        }
        .topbar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px 20px;
    background: #f0f2f5;
    position: relative;
}

.profile-dropdown {
    position: relative;
    margin-left: 15px;
}

.pfp {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    object-fit: cover;
    border: 2px solid var(--c3);
    transition: 0.25s;
}

.pfp:hover {
    border-color: var(--c4);
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 50px;
    right: 0;
    background: var(--c2);
    border: 1px solid var(--c3);
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    min-width: 120px;
    z-index: 100;
}

.dropdown-menu a {
    display: block;
    padding: 10px 15px;
    color: var(--text-dark);
    text-decoration: none;
    font-size: 14px;
    transition: 0.2s;
}

.dropdown-menu a:hover {
    background: var(--c3);
    color: var(--text-light);
}
.nav-item {
    display: block;
    padding: 12px 20px;
    margin: 5px 0;
    background: var(--c2);
    color: var(--text-dark);
    border-radius: 8px;
    text-decoration: none;
    transition: 0.25s;
    cursor: pointer;
}

.nav-item:hover {
    background: var(--c3);
    color: var(--text-light);
}

.container {
    background: var(--c2);
    padding: 40px 30px;
    width: 100%;
    margin-left:25%;
    max-width: 500px;
    border: 2px solid var(--c3);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    color: var(--c4);
    font-size: 28px;
}

.field {
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
}

label {
    font-size: 14px;
    margin-bottom: 6px;
    color: var(--c4);
}

input[type="text"],
input[type="email"],
input[type="tel"],
input[type="number"] {
    padding: 12px;
    border-radius: 8px;
    border: 1px solid var(--c3);
    background: var(--c1);
    font-size: 15px;
    transition: 0.25s;
}

input:focus {
    border-color: var(--c4);
    outline: none;
}

.addemployee {
    width: 100%;
    padding: 14px;
    background: var(--c4);
    color: var(--text-light);
    border: none;
    border-radius: 10px;
    font-size: 17px;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.25s;
}

.addemployee:hover {
    background: var(--c4);
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

    <!-- ==================== TOP BAR (unchanged) ==================== -->
<div class="content d-flex flex-column min-vh-100">
    <div class="topbar d-flex justify-content-end align-items-center px-3 px-lg-4">
        <?php if (isset($_SESSION['admin_id'])): ?>
            <span class="text-dark fw-semibold me-3 d-none d-sm-inline">
                Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?>
            </span>
            <div class="profile-dropdown">
                <img src="images/<?= htmlspecialchars($_SESSION['admin_pfp'] ?? 'default.png') ?>"
                     alt="Profile" class="pfp" id="pfpToggle">
                <div class="dropdown-menu" id="dropdownMenu">
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- ==================== RESPONSIVE FORM CARD ==================== -->
    <main class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center px-3 py-4">
        <div class="card shadow border-0 w-100" style="max-width: 500px;">
            <div class="card-body p-4 p-sm-5">
                <h2 class="card-title text-center mb-4 fw-bold" style="color:var(--c4);">Add Employee</h2>

                <form method="POST" action="" novalidate>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               placeholder="John" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               placeholder="Doe" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="you@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="contact" name="contact"
                               placeholder="03XXXXXXXXX"
                               pattern="03[0-9]{9}" title="Format: 03XXXXXXXXX" required>
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="form-label">Salary (PKR)</label>
                        <input type="number" class="form-control" id="salary" name="salary"
                               placeholder="50000" min="15000" step="1000" required>
                    </div>

                    <button type="submit" name="add_employee" class="btn addemployee w-100 py-2 fw-bold">
                        Add Employee
                    </button>
                </form>
            </div>
        </div>
    </main>
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
