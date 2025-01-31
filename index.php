
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Login</title>
</head>
<body>
    <h2>Langzeitgeschehen - Login</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_AUTH']); ?>">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

        <div id="auth" style="display: flex; justify-content: space-between; align-items: center; height: 200px; background-color: #f5f5f5; border-radius: 10px;"></div>

        <input type="text" name="Benutzername" placeholder="Geben Sie den Benutzername an." required>
        <input type="password" name="Passwort" placeholder="Geben Sie das Passwort ein." required>

        <button type="submit" value="Zu Bell" onclick="window.location.href='login.php'">Zu Bell</button>
    </form>

    <script>
        document.getElementById('auth').addEventListener('click', function() {
            var element = this.firstChild;
            var inputElement = this.parentElement.querySelector('input[type="text"]');
            var passwordInput = this.parentElement.querySelector('input[type="password"]');
            var submitButton = this.parentElement.querySelector('button[type="submit"]');

            if (inputElement) {
                // Commented out unnecessary nested event listener
                // document.getElementById('auth').addEventListener('click', function() {
                //     return false;
                // });

                inputElement.click();
                inputElement.focus();

                setTimeout(function() {
                    passwordInput.click();
                    passwordInput.focus();

                    setTimeout(function() {
                        submitButton.click();
                    }, 200);

                    this.parentElement.click();
                    return false;
                }, 1000);
            } else {
                alert('Fehler: Klicken Sie auf das Login-Formular!');
            }
        });
    </script>
</body>
</html>



<!DOCTYPE html>
<html lang="de">
<head>
    <title>Login</title>
</head>
<body>
    <h2>Langzeitgeschehen - Login</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_AUTH']); ?>">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

        <div id="auth" style="display: flex; justify-content: space-between; align-items: center; height: 200px; background-color: #f5f5f5; border-radius: 10px;"></div>

        <input type="text" name="Benutzername" placeholder="Geben Sie den Benutzername an." required>
        <input type="password" name="Passwort" placeholder="Geben Sie das Passwort ein." required>

        <button type="submit" value="Zu Bell" onclick="window.location.href='login.php'">Zu Bell</button>
    </form>

    <script>
        document.getElementById('auth').addEventListener('click', function() {
            var element = this.firstChild;
            var inputElement = this.parentElement.querySelector('input[type="text"]');
            var passwordInput = this.parentElement.querySelector('input[type="password"]');
            var submitButton = this.parentElement.querySelector('button[type="submit"]');

            if (inputElement) {
                // Commented out unnecessary nested event listener
                // document.getElementById('auth').addEventListener('click', function() {
                //     return false;
                // });

                inputElement.click();
                inputElement.focus();

                setTimeout(function() {
                    passwordInput.click();
                    passwordInput.focus();

                    setTimeout(function() {
                        submitButton.click();
                    }, 200);

                    this.parentElement.click();
                    return false;
                }, 1000);
            } else {
                alert('Fehler: Klicken Sie auf das Login-Formular!');
            }
        });
    </script>
</body>
</html>


