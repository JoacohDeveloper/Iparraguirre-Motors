<div class="container settingsContainer">
    <?php implementComp("dashboard/aside.php") ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3 class="accountType" id="<?php echo $userType?>">Configuracion de cuenta</h3>
            </div>

            <div class="dashboard-fit__content">
                <aside class="dashboard-fit__content_aside">
                    <nav>
                        <ul class="steps">
                            <li aria-label="step-1" id="profile" class="selected"><a href="#my_profile">Mi perfil</a></li>
                            <li aria-label="step-2" id="notifications"><a href="#">Notificaciones</a></li>
                            <li aria-label="step-3" id="change-pass"><a href="#">Cambiar contraseña</a></li>
                            <li aria-label="step-4" id="delete-account"><a href="#">Eliminar cuenta</a></li>
                        </ul>
                    </nav>
                </aside>
                <section class="dashboard-fit__content__profile settingsStepVisible" aria-step="1" id="my_profile">
                    <h4>Mi perfil</h4>
                    <button class="button_settings profile-resume-configuration__edit" id="edit-resume">
                        <p>Editar perfil</p>
                        <img src="/build/src/images/pencil.svg" alt="edit profile resume">
                    </button>
                    <div class="dashboard-profile__resume">
                        <div class="profile-resume-configuration">
                            <div class="profile-resume__image">
                                <img id="profile-img__id" src="<?php echo $imagen["url"] ?>" alt="<?php echo $imagen["alt"] ?>">
                            </div>
                            <div class="profile-resume__data">
                                <h4 id="fullname__id"><?php echo $fullname; ?></h4>
                                <p><?php echo $username; ?></p>
                            </div>
                        </div>
                        <?php
                        if ($imagen["url"] != "\build\src\images\users\default.jpg") {
                            echo '<button class="delete-picture-configuration__edit" id="delete-image">
                                    <p>Eliminar imagen de perfil</p>
                                    <img src="/build/src/images/trash.svg" alt="delete profile picture">
                                </button>';
                        }
                        ?>
                    </div>
                    <div class="dashboard-fit__content__personal-information">
                        <div class="personal-information__head">
                            <h5>Informacion personal</h5>
                        </div>
                        <div class="personal-information__saved-fields_grid">
                            <div class="saved-fields__field">
                                <label>Nombre</label>
                                <p id="firstname__id"><?php echo $firstname; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Apellido</label>
                                <p id="lastname__id"><?php echo $lastname; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Correo electronico</label>
                                <p id="email__id"><?php echo $email; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Nombre de usuario</label>
                                <p id="username__id"><?php echo $username; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Registrado el</label>
                                <p id="created__id"><?php echo $createdAt; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Ultima actualizacion</label>
                                <p id="updated__id"><?php echo $updatedAt; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Acerca de mi</label>
                                <p id="bio__id">
                                    <?php
                                    if ($bio == "" || $bio == null) {
                                        echo "Hola, soy " . htmlspecialchars($firstname);
                                    } else {
                                        echo htmlspecialchars($bio);
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="dashboard-fit__content__notifications" aria-step="2">
                    <h4>Notificaciones</h4>
                </section>
                <section class="dashboard-fit__content__password" aria-step="3">
                    <h4>Cambiar contraseña</h4>
                    <form class="form_changePassword">
                        <label for="olderPassword">
                            Contraseña actual
                            <div class="password-container">
                                <input type="password" name="olderPassword" inputmode="text">
                                <button type="button" class="show-password" onclick="togglePassword(this)">
                                    <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                                </button>
                            </div>
                        </label>
                        <label for="password">
                            Nueva contraseña
                            <div class="password-container">
                                <input type="password" name="password" inputmode="text">
                                <button type="button" class="show-password" onclick="togglePassword(this)">
                                    <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                                </button>
                            </div>
                        </label>
                        <label for="repeatPassword">
                            Repetir nueva contraseña
                            <div class="password-container">
                                <input type="password" name="repeatPassword" inputmode="text">
                                <button type="button" class="show-password" onclick="togglePassword(this)">
                                    <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                                </button>
                            </div>
                        </label>
                        <input type="submit" value="Cambiar" id="form_changePassword-submitButton">
                    </form>
                </section>
                <section class="dashboard-fit__content__delelteAcc" aria-step="4">
                    <h4>Eliminar mi cuenta</h4>
                    <h6>¿Estas seguro?</h6>
                    <p>Borrar tu cuenta implica perder todos tus datos, y una vez hecho no hay vuelta atras!</p>
                    <form class="form_deleteAccount">
                        <label for="fullname">
                            Nombre completo
                            <input type="text" name="Nombre">
                        </label>
                        <label for="password">
                            Contraseña
                            <div class="password-container">
                                <input type="password" name="Password" inputmode="text">
                                <button type="button" class="show-password" onclick="togglePassword(this)">
                                    <img src="/build/src/images/closedEye.svg" alt="Mostrar contraseña">
                                </button>
                            </div>
                        </label>
                        <input type="submit" value="Eliminar" id="form_deleteAccount-submitButton">
                    </form>
                </section>
            </div>
        </div>
    </div>
    <?php implementComp("error_toast.php") ?>
</div>