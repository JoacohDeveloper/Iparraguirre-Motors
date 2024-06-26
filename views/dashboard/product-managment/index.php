<div class="container">
    <?php include str_replace("\dashboard\product-managment", "", __DIR__) .  "\componentes\dashboard\aside.php"; ?>
    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Product Managment</h3>
            </div>
        </div>

<<<<<<< HEAD
        <?php implementComp("footer.php", ["class" => "dashboard-footer"]);
=======
        <?php include implementComp("footer.php");

        footer("dashboard-footer");
>>>>>>> d_changes/add-settings-view
        ?>
    </div>

</div>