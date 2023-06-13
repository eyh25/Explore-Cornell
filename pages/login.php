<!DOCTYPE html>
<html lang="en">
<title>Login</title>

<?php include('includes/header.php'); ?>

<main class="form">

<?php if (!is_user_logged_in()) { ?>
<div class="login-form">
    <p class="login-title">Log In</p>

  <?php echo login_form('/', $session_messages);} ?>
  </div>



</main>

</body>
</html>
