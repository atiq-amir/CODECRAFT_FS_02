<?php
session_start();
include 'config.php';
if(isset($_POST['register']))
{
    $userrole= $_POST['userrole'];
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $usercontact = $_POST['usercontact'];
    $userpassword = password_hash($_POST['userpassword'], PASSWORD_DEFAULT);
    $userimage = $_FILES['userimage']['name'];
    $tempimg = $_FILES['userimage']['tmp_name'];
    move_uploaded_file($tempimg, "images/" . $userimage);
    $insertquery = "INSERT INTO admin(name,email,phone,password,pfp,role,created_at) 
    VALUES('".$username."','".$useremail."','".$usercontact."','".$userpassword."','".$userimage."','".$userrole."', NOW())";
    $runbtn = mysqli_query($connect, $insertquery);
    header("location: login.php");
            exit();
}

?>

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
  font-family: "Segoe UI", Tahoma, sans-serif;
  background: var(--c1);
  color: var(--text-dark);
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}
.container {
  background: var(--c2);
  padding: 40px;
  width: 100%;
  max-width: 420px;
  border-radius: 16px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.12);
  border: 2px solid var(--c3);
}
h2 {
  text-align: center;
  margin-bottom: 25px;
  color: var(--c4);
  font-size: 30px;
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
input, select {
  padding: 12px;
  border-radius: 8px;
  border: 1px solid var(--c3);
  background: var(--c1);
  font-size: 15px;
  transition: 0.25s;
}
input:focus, select:focus {
  border-color: var(--c4);
  outline: none;
}
button {
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
button:hover {
  background: var(--c3);
}
p {
  text-align: center;
  margin-top: 18px;
  color: var(--c4);
}
p a {
  color: var(--c4);
  font-weight: 600;
  text-decoration: none;
}
</style>

<div class="container">
  <h2>Create Account</h2>

  <form method="POST" enctype="multipart/form-data">
    <div class="field">
      <input type="hidden" value="admin" name="userrole"/>
      <label>Full Name</label>
      <input type="text" name="username" pattern="[A-Za-z ]+" title="Only letters and spaces allowed" placeholder="John Doe" required />
    </div>

    <div class="field">
      <label>Email</label>
      <input type="email" name="useremail" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}" title="Enter a valid email address" placeholder="you@example.com" required />
    </div>

    <div class="field">
      <label>Contact Number</label>
      <input type="tel" name="usercontact" pattern="03[0-9]{9}" title="Format: 03XXXXXXXXX" placeholder="03xxxxxxxxx" required />
    </div>

    <div class="field">
      <label>Password</label>
      <input type="password" name="userpassword" minlength="8" title="At least 8 characters" placeholder="Minimum 8 characters" required />
    </div>


    <div class="field">
      <label>Profile Picture</label>
      <input type="file" name="userimage" accept="image/*" />
    </div>

  <input type="submit" value="Create Account" name="register">

    <p>Already have an account? <a href="login.php">Login</a></p>
  </form>
</div>
