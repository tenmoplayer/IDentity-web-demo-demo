<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign In / Sign Up</title>
    <style>
        body {
            background-color: #f4f4f4;
            background-image: url(background.png);
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4285f4;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #3367d6;
        }

        .link {
            margin-top: 20px;
        }

        .link a {
            text-decoration: none;
            color: #4285f4;
            font-weight: bold;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?php echo isset($_GET['signup']) ? 'Sign Up' : 'Sign In'; ?></h2>

    <form action="<?php echo isset($_GET['signup']) ? 'signup_handler.php' : 'login_handler.php'; ?>" method="POST">
        <?php if (isset($_GET['signup'])): ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="signup">Sign Up</button>
        <?php else: ?>
            <input type="text" name="user_input" placeholder="Email or Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        <?php endif; ?>
    </form>

    <div class="link">
        <?php if (isset($_GET['signup'])): ?>
            <a href="index.php">Already have an account? Sign In</a>
        <?php else: ?>
            <a href="index.php?signup=1">Don't have an account? Sign Up</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
