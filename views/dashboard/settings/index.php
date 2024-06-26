<div class="container settingsContainer">
<<<<<<< HEAD
    <?php implementComp("dashboard/aside.php") ?>
=======
    <?php include implementComp("dashboard/aside.php") ?>


>>>>>>> d_changes/add-settings-view

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Account Settings</h3>
            </div>

            <div class="dashboard-fit__content">
                <aside class="dashboard-fit__content_aside">
                    <nav>
                        <ul>
                            <li class="selected"><a href="#my_profile">My Profile</a></li>
                            <li><a href="#">Notifications</a></li>
                            <li><a href="#">Security</a></li>
                            <li class="delete-account"><a href="#">Delete Account</a></li>
                        </ul>
                    </nav>
                </aside>
                <section class="dashboard-fit__content__profile" id="my_profile">
                    <h4>My Profile</h4>
                    <div class="dashboard-profile__resume">
                        <div class="profile-resume-configuration">
                            <div class="profile-resume__image">
                                <img src="<?php echo $imagen["url"] ?>" alt="<?php echo $imagen["alt"] ?>">
                            </div>
                            <div class="profile-resume__data">
                                <h4><?php echo $fullname . " - " . $username; ?></h4>
<<<<<<< HEAD
                                <p><?php echo isset($isAdmin) ? "Admin" : "User"; ?></p>
=======
                                <p><?php echo $isAdmin ? "Admin" : "User"; ?></p>
>>>>>>> d_changes/add-settings-view
                                <p>Lorem ipsum dolor sit.</p>
                            </div>
                        </div>
                        <button class="button_settings profile-resume-configuration__edit" id="edit-resume">
                            <p>edit</p>
                            <img src="/build/src/images/pencil.svg" alt="edit profile resume">
                        </button>
                    </div>
                    <div class="dashboard-fit__content__personal-information">
                        <div class="personal-information__head">
                            <h5>Personal Information</h5>
                            <button class="button_settings profile-resume-configuration__edit" id="edit-p-information">
                                <p>edit</p>
                                <img src="/build/src/images/pencil.svg" alt="edit profile personal information">
                            </button>
                        </div>
                        <div class="personal-information__saved-fields_grid">
                            <div class="saved-fields__field">
                                <label>First Name</label>
                                <p><?php echo $firstname; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Last Name</label>
                                <p><?php echo $lastname; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Email address</label>
                                <p><?php echo $email; ?></p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Phone</label>
                                <p>+598 098 561 082</p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Bio</label>
                                <p>My names is Joaquin</p>
                            </div>
                        </div>
                    </div>
                </section>
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