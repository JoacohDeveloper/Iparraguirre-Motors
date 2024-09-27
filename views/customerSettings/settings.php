
<div class="container">
    <aside class="settings-fit__content_aside">
        <div class="settings-userinfo_aside">
            <div class="aside_profile-resume__image">
                <img id="img_profile" src="\build\src\images\users\default.jpg">
                <h4 id="fullname__id"><?php echo $fullname; ?></h4>
            </div>
        </div>
        <nav class="aside-nav">
            <ul class="steps">
                <li aria-label="step-1" id="profile" class="selected"><a href="#my_profile">Personal information</a></li>
                <li aria-label="step-2" id="notifications"><a href="#cart">Cart</a></li>
                <li aria-label="step-3" id="security"><a href="#wishlist">Wishlist</a></li>
                <li aria-label="step-4" id="change-pass"><a href="#changepass">Change password</a></li>
                <li aria-label="step-5" id="delete-account"><a href="#deleteacount">Delete account</a></li>
            </ul>
            <a id="LogOut"href="">Cerrar Sesion</a>
        </nav>
    </aside>  
<div class="dashboard-fit__content">  
    <section class="dashboard-fit__content__profile settingsStepVisible" aria-step="1" id="#my_profile">
        <h4>My Profile</h4>
        <button class="button_settings profile-resume-configuration__edit" id="edit-resume">
            <p>Edit profile</p>
            <img src="/build/src/images/pencil.svg" alt="edit profile resume">
        </button>
        <div class="dashboard-profile__resume">
            <div class="profile-resume-configuration">
                <div class="profile-resume__image">
                    <img id="img_resume" src="<?php echo $imagen["url"] ?>" alt="<?php echo $imagen["alt"] ?>">
                </div>
                <div class="profile-resume__data">
                    <h4 id="fullname__id"><?php echo $fullname; ?></h4>
                    <p><?php echo $username; ?></p>
                </div>
            </div>
            <?php
            if ($imagen["url"] != "\build\src\images\users\default.jpg") {
                echo '<button class="delete-picture-configuration__edit" id="delete-image">
                        <p>Delete profile picture</p>
                        <img src="/build/src/images/trash.svg" alt="delete profile picture">
                    </button>';
            }
            ?>
        </div>
        
        <div class="dashboard-fit__content__personal-information">
            <div class="personal-information__head">
                <h5>Personal Information</h5>
            </div>
            <div class="personal-information__saved-fields_grid">
                <div class="saved-fields__field">
                    <label>First Name</label>
                    <p id="firstname__id"><?php echo $firstname; ?></p>
                </div>
                <div class="saved-fields__field">
                    <label>Last Name</label>
                    <p id="lastname__id"><?php echo $lastname; ?></p>
                </div>
                <div class="saved-fields__field">
                    <label>Email address</label>
                    <p id="email__id"><?php echo $email; ?></p>
                </div>
                <div class="saved-fields__field">
                    <label>Username</label>
                    <p id="username__id"><?php echo $username; ?></p>
                </div>
                <div class="saved-fields__field">
                    <label>Registered on</label>
                    <p id="created__id"><?php echo $createdAt; ?></p>
                </div>
                <div class="saved-fields__field">
                    <label>Updated on</label>
                    <p id="updated__id"><?php echo $updatedAt; ?></p>
                </div>
                <div class="saved-fields__field">
                    <label>Bio</label>
                    <p id="bio__id">
                        <?php
                        if ($bio == "" || $bio == null) {
                            echo "My name is " . htmlspecialchars($firstname);
                        } else {
                            echo htmlspecialchars($bio);
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-fit__content__myCart" aria-step="2" id="#mycart">
     <h4>Carrito de compras</h4>
    </section>

    <section class="dashboard-fit__content__wishlist" aria-step="3" id="#wishlist">
        <h4>Lista de deseos</h4>
    </section>

    <section class="dashboard-fit__content__password" aria-step="4">
        <h4>Change Password</h4>
        <form class="form_changePassword">
            <label for="olderPassword">
                Contraseña actual
                <input type="password" name="olderPassword">
            </label>
            <label for="password">
                Nueva contraseña
                <input type="password" name="password">
            </label>
            <label for="repeatPassword">
                Repetir nueva contraseña
                <input type="password" name="repeatPassword">   
            </label>
            <input id="Changepw" type="submit" value="Cambiar">
        </form>
    </section>

    <section class="dashboard-fit__content__delelteAcc" aria-step="5" id="#deleteacount">
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
                <input type="password" name="Password">
            </label>
            <input id="Delete" type="submit" value="Eliminar">
        </form>
    </section>

    <?php implementComp("error_toast.php")?>

</div>