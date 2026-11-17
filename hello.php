<?php
session_start();

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $error = 'Please enter your name.';
    } else {
        $_SESSION['name'] = $name;
        $_SESSION['started_at'] = time();
    }
}

$isLoggedIn = isset($_SESSION['name'], $_SESSION['started_at']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello</title>
    <style>
        .start-time {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
    </style>
</head>
<body>
    <?php if ($isLoggedIn): ?>
        <div class="start-time">
            Start time: <?= escape(date('Y-m-d H:i:s', (int) $_SESSION['started_at'])) ?>
        </div>

        <h1>Hello, <?= escape($_SESSION['name']) ?>!</h1>

        <form action="logout.php" method="post">
            <button type="submit">Log out</button>
        </form>
    <?php else: ?>
        <h1>Enter your name</h1>

        <?php if ($error !== ''): ?>
            <p role="alert"><?= escape($error) ?></p>
        <?php endif; ?>

        <form action="hello.php" method="post">
            <label for="name">Name:</label>
            <input id="name" name="name" type="text" required>
            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>
</body>
</html>