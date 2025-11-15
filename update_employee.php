<?php
session_start();
include 'config.php';
if(!isset($_SESSION['admin_id']) || ($_SESSION['admin_role'] ?? '') !== 'admin') {
    echo "<h2 style='text-align:center; margin-top:50px; color:red;'>Access Denied! Only admins can access this page.</h2>";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $salary = $_POST['salary'];

    $update = "UPDATE employees SET first_name = '$first_name', last_name = '$last_name', email = '$email', contact = '$contact', salary = '$salary', updated_at = NOW() WHERE id = $id";

    if (mysqli_query($connect, $update)) {
        echo "<script>alert('Employee Updated'); window.location.href='employees.php';</script>";
    } else {
        echo "<script>alert('Update Failed');</script>";
    }
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

        /* Sidebar */
        .sidebar {
            width: 250px;
            height:650px;
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

        /* Top Bar */
        .topbar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px 20px;
    background: var(--c2);
    position: relative;
    box-shadow: 0 2px 5px rgba(0,0,0,.1);
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
.update-container {
    width: 100%;
    max-width: 500px;
    margin: auto;
    background: rgb(210, 220, 182);
    padding: 25px;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
}

.update-container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: rgb(119, 136, 115);
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-weight: bold;
    color: rgb(119, 136, 115);
    margin-bottom: 6px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 2px solid rgb(161, 188, 152);
    border-radius: 8px;
    background: rgb(241, 243, 224);
    outline: none;
    color: #333;
    font-size: 15px;
}

.form-group input:focus,
.form-group select:focus {
    border-color: rgb(119, 136, 115);
}

.update-btn {
    width: 100%;
    padding: 12px 0;
    background: rgb(119, 136, 115);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 17px;
    font-weight: bold;
    transition: 0.3s ease;
}

.update-btn:hover {
    background: rgb(95, 110, 92);
}
/* ----------  RESPONSIVE  ---------- */
.menu-toggle,
.sidebar-overlay { display: none; }

@media (max-width: 991.98px) {
    body { flex-direction: column; }
    .sidebar {
        position: fixed; top: 0; left: 0; height: 100vh;
        transform: translateX(-100%); z-index: 1100;
    }
    .sidebar.show { transform: translateX(0); }

    .menu-toggle {
        display: block; position: fixed; top: 15px; left: 15px;
        width: 44px; height: 44px; background: var(--c4); color: #fff;
        border: none; border-radius: 6px; font-size: 24px;
        line-height: 44px; text-align: center; cursor: pointer; z-index: 1200;
    }
    .sidebar-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,.45);
        z-index: 1090; display: none;
    }
    #sidebar-toggle:checked ~ .sidebar-overlay { display: block; }
}

@media (max-width: 576px) {
    .card { padding: 18px; }
    .card h3 { font-size: 18px; }
    .topbar { font-size: 16px; padding: 8px 15px; }
    .pfp { width: 34px; height: 34px; }
    .sidebar { width: 220px; }
    .sidebar img { width: 150px; }
}
/* =====  MAKE THE TOGGLER WORK  ===== */
#sidebar-toggle:checked ~ .sidebar { transform: translateX(0); }
    </style>
</head>
<body>
    <input type="checkbox" id="sidebar-toggle" hidden>
<label for="sidebar-toggle" class="menu-toggle">☰</label>
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
        <div class="update-container">
    <h2>Update Employee</h2>
        <?php
        if(isset($_GET['id']))
        {
        $id = $_GET['id'];
        $showdata = "SELECT * FROM employees WHERE id = $id";
        $result = mysqli_query($connect, $showdata);
        while($row = mysqli_fetch_array($result))
        {
        ?>
    <form method="POST" action="">
        <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="<?= htmlspecialchars($row['email']) ?>">
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="contact" value="<?= htmlspecialchars($row['contact']) ?>">
        </div>

        <div class="form-group">
            <label>Salary</label>
            <input type="text" name="salary" value="<?= htmlspecialchars($row['salary']) ?>">
        </div>

        <button type="submit" name="update" class="btn update-btn me-2">Update Employee</button>

        <?php
                }
            }
         ?>
    </form>

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
