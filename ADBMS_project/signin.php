<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>AMS</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="center">
      <h1>Login</h1>

      <form method="post">
        <div class="txt_field">
          <input type="text" name="username" required>
          <span></span>
          <label>ID</label>
        </div>
        <div class="txt_field">
          <input type="password" name="password" required>
          <span></span>
          <label>Password</label>
        </div>
        
        <input type="submit" value="Login" name="submit">
        <div class="signup_link">
          Not a member? <a href="signup.php">Signup</a><br>
          <a href="admin_signin.php">Admin Login</a>
        </div>
      </form>
    </div>


<?php
  if (isset($_POST['submit'])) {
    $password = $_POST["password"];
    $user_id = $_POST["username"];

    $conn = oci_connect('ADMS', 'tiger', '//localhost/XE');   
    if (!$conn) {
      echo 'Failed to connect to oracle' . "<br>";
    }
    $query = "SELECT CUSTOMER_PASS FROM CUSTOMER WHERE CUSTOMER_ID = '$user_id'";
    $stid = oci_parse($conn, $query);

    if (!$stid) {
      $m = oci_error($conn);
      trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
    }
    echo '<br>';

    $r = oci_execute($stid);
    if (!$r) {
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
    }
    echo '<br>';

    $row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);

    $check_password= $row['CUSTOMER_PASS'];

    if ($password == $check_password && $password != null) {
      header("refresh: 1; url=customer_dashbord.php");
    }
    else{
      print "<br>INCORRECT INFORMATION";
      header("refresh: 3;");
    }

  }
 

?>


</body>
</html>