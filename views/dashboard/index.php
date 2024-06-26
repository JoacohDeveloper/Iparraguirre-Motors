<div class="container">
<<<<<<< HEAD
    <?php implementComp("dashboard/aside.php") ?>
=======
    <?php include implementComp("dashboard/aside.php") ?>
>>>>>>> d_changes/add-settings-view

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Dashboard</h3>
            </div>

            <div class="analytics card w-full loading">

            </div>
            <div class="options">
                <article class="card loading">

                </article>
                <article class="card loading">

                </article>


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