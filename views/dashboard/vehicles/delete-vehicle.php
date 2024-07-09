<div class="container">
    <?php implementComp("dashboard\aside.php"); ?>
    <?php implementComp("error_toast.php") ?>
    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">

            </div>

            <h3>Eliminar Vehiculo</h3>

            <form class="f_deletevehicle">
                <input type="text" name="id" placeholder="ID del vehiculo">
                <input id="submit" type="submit" value="Eliminar">
            </form>
        </div>
        <?php implementComp("footer.php", ["class" => "dashboard-footer"]);
        ?>
    </div>
</div>

</div>
<!-- Falta: descripcion, titulo_imagen y imagen -->