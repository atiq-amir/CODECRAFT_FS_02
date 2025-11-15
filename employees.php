<?php
session_start();
include 'config.php';
if(!isset($_SESSION['admin_id']) || ($_SESSION['admin_role'] ?? '') !== 'admin') {
    echo "<h2 style='text-align:center; margin-top:50px; color:red;'>Access Denied! Only admins can access this page.</h2>";
    exit();
}
if(isset($_GET['delete_btn']))
{
    $del_id = $_GET['delete_btn'];
    $deletequery = "DELETE FROM employees WHERE id='".$del_id."' ";
    mysqli_query($connect, $deletequery);
    if(mysqli_affected_rows($connect) > 0)
    {
        echo "<script>alert('Employee Deleted')</script>";
    }
    else 
    {
        echo "<script>alert('Failed to Delete')</script>";
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
 /* ----------  COLOUR THEME  ---------- */
:root {
    --c1: rgb(241, 243, 224);
    --c2: rgb(210, 220, 182);
    --c3: rgb(161, 188, 152);
    --c4: rgb(119, 136, 115);
    --text-dark: #2d2d2d;
    --text-light: #ffffff;
}

/* ----------  BASE  ---------- */
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

/* ----------  NAV  ---------- */
.nav-item {
    display: block; padding: 12px 20px; margin: 5px 0;
    background: var(--c2); color: var(--text-dark);
    border-radius: 8px; text-decoration: none; transition: .25s;
}
.nav-item:hover { background: var(--c3); color: var(--text-light); }

/* ----------  CARDS  ---------- */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
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

/* ----------  TABLE  ---------- */
.table-container {
    max-width: 1000px; margin: auto; background: var(--c2);
    padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,.1);
    overflow-x: auto;
}
.table-container h2 {
    text-align: center; color: var(--c4); margin-bottom: 20px;
}
table {
    width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;
}
thead { background: var(--c3); color: var(--c1); }
thead th { padding: 12px; text-align: left; font-size: 16px; }
tbody tr {
    background: var(--c1);
    border-bottom: 1px solid var(--c2);
}
tbody tr:nth-child(even) { background: rgb(230, 235, 210); }
tbody td { padding: 12px; color: rgb(60, 60, 60); white-space: nowrap; }
.upd_btn, .del_btn {
    padding: 4px 10px; border: none; border-radius: 5px; color: #fff;
    font-size: 14px; text-decoration: none; display: inline-block;
}
.upd_btn { background: rgb(98, 129, 65); }
.del_btn { background: rgb(255, 11, 85); }
.upd_btn:hover { background: rgb(139, 174, 102); }
.del_btn:hover { background: rgb(207, 15, 71); }

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

        <div class="container-fluid table-container">

    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Employee Details</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="thead">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Salary</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
        <?php
          $sql = "SELECT * FROM employees ORDER BY added_at DESC";
          $res = mysqli_query($connect, $sql);

          if (mysqli_num_rows($res) > 0):
            while ($row = mysqli_fetch_assoc($res)):
        ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['first_name']) ?></td>
            <td><?= htmlspecialchars($row['last_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td><?= htmlspecialchars($row['salary']) ?></td>
            <td><?= date('M d, Y', strtotime($row['added_at'])) ?></td>
            <td><?= date('M d, Y', strtotime($row['updated_at'])) ?></td>
            <td>
            <a class="btn upd_btn " name="update_btn" data-id="<?= $row['id'] ?>" href="update_employee.php?id=<?= $row['id'] ?>">Update</a>
            <a class="btn del_btn " name="delete_btn" data-id="<?= $row['id'] ?>" href="?delete_btn=<?= $row['id'] ?>" onclick="return confirm('Delete this Employee?')">Delete</a>
            </td>
          </tr>
        <?php
            endwhile;
          else:
            echo '<tr><td colspan="12" class="text-center">No Employees found</td></tr>';
          endif;
        ?>
        </tbody>

                </table>
            </div>

        </div>
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
