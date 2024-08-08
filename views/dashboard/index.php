<div class="container">
    <?php implementComp("dashboard/aside.php") ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Dashboard</h3>
            </div>

            <div class="analytics card w-full">
                <canvas id="chart1"></canvas>
            </div>
            <div class="options">
                <article class="card">
                    <canvas id="chart2"></canvas>
                </article>
                <article class="card">
                    <canvas id="chart3"></canvas>
                </article>

            </div>

        </div>
        
        <?php implementComp("footer.php", ["class" => "dashboard-footer"]);?>
    </div>


</div>