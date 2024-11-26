
<div class="container">
    <aside class="settings-fit__content_aside">
        <div class="settings-userinfo_aside">
            <div class="aside_profile-resume__image">
                <img id="img_profile" src="<?php echo $imagen["url"] ?>" alt="<?php echo $imagen["alt"] ?>">
                <h4 id="aside_fullname__id"><?php echo $fullname; ?></h4>
            </div>
        </div>
        <nav class="aside-nav">
            <ul class="steps">
                <li aria-label="step-1" id="profile" class="selected"><a href="#my_profile"><img src="build/src/images/user.svg" alt="personal information icon">Informacion personal</a></li>
                <li aria-label="step-2" id="cart"><a href="#mycart"><img src="/build/src/images/cart.svg" alt="">Carrito</a></li>
                <li aria-label="step-3" id="wishlist"><a href="#wishlist"><img src="/build/src/images/bookmark.svg" alt="">Lista de deseos</a></li>
                <li aria-label="step-4" id="change-pass"><a href="#changepass"><img src="build/src/images/lock.svg" alt="change password icon">Cambiar contraseña</a></li>
                <li aria-label="step-5" id="delete-account"><a href="#deleteacount"><img src="build/src/images/alert.svg" alt="delete account icon">Borrar cuenta</a></li>
                <li aria-label="step-6" id="log-out"><a href="#logout"><img src="build/src/images/exit.svg" alt="log out icon">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </aside>  
    <div class="fit__content">  
        <section class="fit__content__profile settingsStepVisible" aria-step="1" id="#my_profile">
            <h4 id="myProfile-title">Mi perfil</h4>
            <div class="profile__resume">
            <?php
                if ($imagen["url"] != "\build\src\images\users\default.jpg") {
                    echo '<button class="delete-picture-configuration__edit" id="delete-image">
                            <p>Borrar foto de perfil</p>
                            <img src="/build/src/images/trash.svg" alt="delete profile picture">
                        </button>';
                }
                ?>
                <div class="profile-resume-configuration">
                    <div class="profile-resume__image">
                        <img id="img_resume" src="<?php echo $imagen["url"] ?>" alt="<?php echo $imagen["alt"] ?>">
                    </div>
                    <div class="profile-resume__data">
                        <h4 id="fullname__id"><?php echo $fullname; ?></h4>
                        <p id="username_resume"><?php echo $username; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="fit__content__personal-information">
                <div class="personal-information__head">
                    <h5>Informacion personal</h5>
                    <button class="button_settings profile-resume-configuration__edit" id="edit-resume">
                        <p>Editar perfil</p>
                        <img src="/build/src/images/pencil.svg" alt="edit profile resume">
                    </button>
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
                </div>
            </div>

            <div class="fit__content-information">
                <div class="fit__content__purchase-information">
                    <div class="purchase__head">
                        <h5>Registro de compras</h5>
                    </div>
                    <div class="purchase-information__saved-fields">
                        <p id="exampleTXT_information">No has realizado ninguna compra</p>
                    </div>
                </div>

                <div class="fit__content__testdrive-information">
                    <div class="testdrive__head">
                        <h5>Registro de test drive</h5>
                    </div>
                    <div class="testdrive-information__saved-fields">
                        <div class="cardTestDrive_Container">
                            <!-- Aqui van las cartas de los testdrive reservados por el cliente o un mensaje por defecto dinamico -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fit__content__myCart" aria-step="2" id="#mycart">
        <div class="basket-title">
            <h4>Productos del Carrito</h4>
            </div>
            <div class="basket-container">
                <div class="cart-content">
                    <p>
                        Productos
                    </p>
                    <div class="cart-items">
                    </div>
                </div>
                <div class="totalPrice-checkout">
                    <p class="checkout-title">Checkout</p>
                    <div class="products-total">
                        <div class="checkout-total">
                            <p>Total: <span class="total-pricing">U$S 78.00</span></p>
                            <img src="/build/src/images/chevronDown.svg" alt="down arrow image">
                        </div>
                        <div class="subtotal hidden">
                        </div>
                    </div>
                    <button class="checkout-buy">Comprar</button>
                    <p class="shipping">costos de envios calculados</p>
                </div>
            </div>
        </section>

        <section class="fit__content__wishlist" aria-step="3" id="#wishlist">
            <h4>Lista de deseos</h4>
        </section>

        <section class="fit__content__password" aria-step="4">
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
                <input id="Changepw" type="submit" value="Cambiar">
            </form>
        </section>

        <section class="fit__content__delelteAcc" aria-step="5" id="#deleteacount">
            <h4>Eliminar mi cuenta</h4>
            <h6>¿Estas seguro?</h6>
            <p>Borrar tu cuenta implica perder todos tus datos, y una<br>vez hecho no hay vuelta atras!</p>
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
                <input id="Delete" type="submit" value="Eliminar">
            </form>
        </section>

        <section class="fit__content__logOut" aria-step="6" id="#logout">
            <h4>Cerrar sesion</h4>
            <p>Presiona el boton de abajo para cerrar la sesion de tu cuenta</p>
            <button id="btnLogOut">Salir</button>
        </section>

        <?php implementComp("error_toast.php")?>
    </div>
</div>