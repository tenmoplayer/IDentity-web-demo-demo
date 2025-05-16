<?php
// Start session to store error messages
session_start();

// Check if there's an error message to display
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Clear the error message after displaying it
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | GUI-ILS-EXPO</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>

<div class="container">
  <div class="login-content">
    <div class="welcome-message">
      <h1>Welcome to GUI-ILS-EXPO</h1>
      <p class="subtitle">Please log in to continue</p>
    </div>

    <!-- Error message display -->
    <?php if ($error_message): ?>
      <div class="error-message">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>

    <div class="login-form">
      <form action="login.php" method="POST">
        <table class="login-table">
          <tr>
            <td><label for="username">Username</label></td>
            <td><input type="text" id="username" name="username" required placeholder="Enter your username"></td>
          </tr>
          <tr>
            <td><label for="password">Password</label></td>
            <td><input type="password" id="password" name="password" required placeholder="Enter your password"></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center;">
              <button type="submit" class="login-btn">Login</button>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>

</body>
</html>
