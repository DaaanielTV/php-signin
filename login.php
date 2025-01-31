<?php
session_start();

// Simulated database for demonstration (replace with actual database logic)
$users = [];
$verification_tokens = [];
$reset_tokens = [];

// Function to send verification email (dummy function)
function sendVerificationEmail($email, $token) {
    // Here you would implement actual email sending logic
    echo "Verification email sent to $email with token: $token\n";
}

// Function to send password reset email (dummy function)
function sendPasswordResetEmail($email, $token) {
    // Here you would implement actual email sending logic
    echo "Password reset email sent to $email with token: $token\n";
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Benutzername']) && isset($_POST['Passwort'])) {
    $username = htmlspecialchars(trim($_POST['Benutzername']));
    $password = htmlspecialchars(trim($_POST['Passwort']));

    // Validate user credentials
    if (array_key_exists($username, $users) && password_verify($password, $users[$username]['password'])) {
        if ($users[$username]['verified']) {
            $_SESSION['username'] = $username;
            $message = "Willkommen, $username!";
        } else {
            $message = "Bitte bestätigen Sie Ihre E-Mail-Adresse.";
        }
    } else {
        $message = "Ungültiger Benutzername oder Passwort.";
    }
}

// Handle registration
if (isset($_POST['new_username']) && isset($_POST['new_password']) && isset($_POST['email'])) {
    $new_username = htmlspecialchars(trim($_POST['new_username']));
    $new_password = htmlspecialchars(trim($_POST['new_password']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Basic validation
    if (!empty($new_username) && !empty($new_password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Hash the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Generate a verification token
        $token = bin2hex(random_bytes(16));
        $verification_tokens[$new_username] = $token;

        // Save the new user to the simulated database
        $users[$new_username] = [
            'password' => $hashed_password,
            'email' => $email,
            'verified' => false,
        ];

        // Send verification email
        sendVerificationEmail($email, $token);

        $message = "Registrierung erfolgreich! Bitte überprüfen Sie Ihre E-Mail, um Ihr Konto zu aktivieren.";
    } else {
        $message = "Bitte füllen Sie alle Felder korrekt aus.";
    }
}

// Handle email verification
if (isset($_GET['verify']) && isset($_GET['token'])) {
    $username = htmlspecialchars(trim($_GET['verify']));
    $token = htmlspecialchars(trim($_GET['token']));

    if (isset($verification_tokens[$username]) && $verification_tokens[$username] === $token) {
        $users[$username]['verified'] = true;
        unset($verification_tokens[$username]); // Remove the token after verification
        $message = "E-Mail erfolgreich bestätigt! Sie können sich jetzt anmelden.";
    } else {
        $message = "Ungültiger Bestätigungstoken.";
    }
}

// Handle password recovery
if (isset($_POST['recover_username'])) {
    $recover_username = htmlspecialchars(trim($_POST['recover_username']));

    if (array_key_exists($recover_username, $users)) {
        // Generate a password reset token
        $reset_token = bin2hex(random_bytes(16));
        $reset_tokens[$recover_username] = $reset_token;

        // Send password reset email
        sendPasswordResetEmail($users[$recover_username]['email'], $reset_token);
        $message = "Ein Link zum Zurücksetzen des Passworts wurde an Ihre E-Mail gesendet.";
    } else {
        $message = "Benutzername nicht gefunden.";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-container { margin: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Langzeitgeschehen - Login</h2>

    <?php if (isset($message)): ?>
        <p class="<?php echo strpos($message, 'erfolgreich') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    <?php if (!isset($_SESSION['username'])): ?>
        <div class="form-container">
            <h3>Login</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="text" name="Benutzername" placeholder="Geben Sie den Benutzername an." required>
                <input type="password" name="Passwort" placeholder="Geben Sie das Passwort ein." required>
                <button type="submit">Anmelden</button>
            </form>

            <h3>Neu hier? <a href="#register">Registrieren</a></h3>
            <h3><a href="#recover">Passwort vergessen?</a></h3>

            <div id="register" style="display:none;">
                <h2>Registrieren</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="text" name="new_username" placeholder="Benutzername" required>
                    <input type="password" name="new_password" placeholder="Passwort" required>
                    <input type="email" name="email" placeholder="E-Mail" required>
                    <button type="submit">Registrieren</button>
                </form>
            </div>

            <div id="recover" style="display:none;">
                <h2>Passwort Wiederherstellen</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="text" name="recover_username" placeholder="Benutzername" required>
                    <button type="submit">Passwort zurücksetzen</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <h3>Willkommen, <?php echo $_SESSION['username']; ?>! <a href="?logout=true">Abmelden</a></h3>
    <?php endif; ?>

    <script>
        // Toggle visibility of registration and recovery forms
        document.querySelector('a[href="#register"]').addEventListener('click', function() {
            document.getElementById('register').style.display = 'block';
            document.getElementById('recover').style.display = 'none';
        });

        document.querySelector('a[href="#recover"]').addEventListener('click', function() {
            document.getElementById('recover').style.display = 'block';
            document.getElementById('register').style.display = 'none';
        });
    </script>
</body>
</html>
