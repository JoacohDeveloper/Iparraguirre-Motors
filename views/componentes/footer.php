<?php

function footer($args = '')
{
?>
    <footer class="<?php echo $args ?>">

        <?php include __DIR__ . "/navegacion.php";
        ?>
        <?php include __DIR__ . "/themeSwitcher.php"; ?>

        <div class="img-container">
            <img src="/build/src/images/LOGO.png" alt="Iparraguirre Logo">
        </div>
        <p>Iparraguire Motors &copy; <?php echo date("Y"); ?></p>
    </footer>
<?php
}
