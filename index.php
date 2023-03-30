<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="./scripts/script.js" defer></script>
    <title>Trasis - Sign In</title>
</head>
<body>
    <?php include 'html/inc/header.inc.php'; ?>
    <main class="main-sign">
        <h1 class="title-sign text">Hello</h1>
        <h2 class="subtitle-sign text">Sign in to your account</h2>
        <div class="error">
            <p class="error-message text"></p>
        </div>
        <form class="form-sign" method="post">
            <input type="text" class="email-icon email-sign text" id="mail" name="email" placeholder="Email">
            <input type="password" class="password-icon password-sign text" id="password" name="password" placeholder="Password">
            <div class="submit-sign">
                <span class="submit-sign-message text">Sign in</span>
                <button class="submit-sign-button">
                    <img class="button-image" src="assets/images/arrow_forward.svg" alt="Submit image">
                </button>
            </div>
        </form>
    </main>
    <footer>
        <p>Labo Pluridisciplinaire - Trasis | All rights reserved</p>
    </footer>
</body>
</html>