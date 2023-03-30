<header class="top-head header">
        <?php
        if (basename($_SERVER['PHP_SELF']) == 'index.php') {
            echo '<img class="logo" src="./assets/images/logoTrasisText.svg" alt="Logo Trasis">';
        } else {
            echo '<img class="logo" src="../assets/images/logoTrasisText.svg" alt="Logo Trasis">';
        }
        ?>
</header>