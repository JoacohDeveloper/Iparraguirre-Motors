<div class="container">

    <h3>Verificar Correo</h3>
    <form method="POST" id="verifcarForm">

        <label for="codigo">Ingrese el codigo</label>
        <input id="codigo" type="text" name="codigo" placeholder="codigo de verificacion">

        <button type="submit">Validar</button>
    </form>

    <?php implementComp("error_toast.php") ?>
</div>