<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id']) || ($_SESSION['admin_role'] ?? '') !== 'admin') {
    echo "<h2 style='text-align:center; margin-top:50px; color:red;'>Access Denied!</h2>";
    exit();
}
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin WHERE id = $admin_id LIMIT 1";
$result = mysqli_query($connect, $query);
$data = mysqli_fetch_assoc($result);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {

    $name  = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $update_pfp_sql = "";
    if (!empty($_FILES['pfp']['name'])) {

        $filename = time() . "_" . basename($_FILES['pfp']['name']);
        $target = "images/" . $filename;

        if (move_uploaded_file($_FILES['pfp']['tmp_name'], $target)) {
            $update_pfp_sql = "pfp = '$filename'";
            $_SESSION['admin_pfp'] = $filename;
        }
    }
    $update = "
        UPDATE admin SET
            name = '$name',
            email = '$email',
            phone = '$phone'
    ";
    if (!empty($update_pfp_sql)) {
        $update .= ", $update_pfp_sql";
    }
    $update .= " WHERE id = $admin_id";
    if (mysqli_query($connect, $update)) {
        $_SESSION['admin_name'] = $name;
        echo "<script>alert('Profile Updated Successfully'); window.location.href='settings.php';</script>";
    } else {
        echo "<script>alert('Update Failed!');</script>";
    }
}
if(isset($_GET['delete_btn']))
{
    $del_id = $_GET['delete_btn'];
    $deletequery = "DELETE FROM admin WHERE id='".$del_id."' ";
    mysqli_query($connect, $deletequery);
    if(mysqli_affected_rows($connect) > 0)
    {
        echo "<script>alert('User Deleted')</script>";
    }
    else 
    {
        echo "<script>alert('Failed to Delete')</script>";
    }
    header('Location: signup.php');
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

        /* Sidebar */
        .sidebar {
            width: 250px;
            height:950px;
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
            width: 100%;
            background: var(--c2);
            padding: 15px 25px;
            font-size: 20px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
    background: var(--c2);
    width: 100%;
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

.profile-container {
    width: 90%;
    max-width: 500px;
    margin: auto;
    background: rgb(210, 220, 182);
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 0 18px rgba(0, 0, 0, 0.15);
}

.profile-container h2 {
    text-align: center;
    font-size: 28px;
    margin-bottom: 25px;
    color: rgb(119, 136, 115);
}

/* Profile Image Circle */
.profile-image {
    width: 120px;
    height: 120px;
    margin: auto;
    margin-bottom: 25px;
    border-radius: 50%;
    border: 4px solid rgb(119, 136, 115);
    overflow: hidden;
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Labels */
form label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
    color: rgb(119, 136, 115);
}

/* Inputs */
form input[type="text"],
form input[type="email"],
form input[type="file"] {
    width: 100%;
    padding: 12px;
    border: 2px solid rgb(161, 188, 152);
    border-radius: 8px;
    background: rgb(241, 243, 224);
    margin-bottom: 18px;
    font-size: 15px;
    outline: none;
}

form input:focus {
    border-color: rgb(119, 136, 115);
}

/* Save Button */
.save-btn {
    width: 100%;
    padding: 12px;
    background: rgb(119, 136, 115);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}

.save-btn:hover {
    background: rgb(99, 112, 95);
}

.delete-btn {
    display: block;        
    width: 100%; 
    padding: 12px;
    background: #d9534f;
    color: white;
    border: none;
    font-size: 16px;
    text-align: center;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 15px;
    text-decoration: none;  
    transition: 0.3s;
}

.delete-btn:hover {
    background: #c9302c;
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
        <div class="content">

<div class="profile-container">
    <h2>My Profile</h2>

    <div class="profile-image">
        <img src="images/<?php echo htmlspecialchars($data['pfp'] ?? 'default.png'); ?>" alt="Profile Picture">
    </div>

    <form method="POST" enctype="multipart/form-data">

        <label>Change Picture</label>
        <input type="file" name="pfp">

        <label>Full Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>

        <label>E-mail</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>" required>

        <button type="submit" name="update_profile" class="save-btn">Save Changes</button>
        <a class="delete-btn text-center" href="?delete_btn=<?= $admin_id ?>" onclick="return confirm('Delete this User?')">Delete</a>

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
