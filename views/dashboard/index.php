<div class="container">
    <?php implementComp("dashboard/aside.php") ?>

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
        <?php implementComp("footer.php", ["class" => "dashboard-footer"]);
        ?>

    </div>


</div>