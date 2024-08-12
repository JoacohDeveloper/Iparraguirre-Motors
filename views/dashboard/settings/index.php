<div class="container settingsContainer">
    <?php implementComp("dashboard/aside.php") ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Account Settings</h3>
            </div>

            <div class="dashboard-fit__content">
                <aside class="dashboard-fit__content_aside">
                    <nav>
                        <ul class="steps">
                            <li aria-label="step-1" class="selected"><a href="#my_profile">My Profile</a></li>
                            <li aria-label="step-2"><a href="#">Notifications</a></li>
                            <li aria-label="step-3"><a href="#">Security</a></li>
                            <li aria-label="step-4" class="delete-account"><a href="#">Delete Account</a></li>
                        </ul>
                    </nav>
                </aside>
                <section class="dashboard-fit__content__profile settingsStepVisible" aria-step="1" id="my_profile">
                    <h4>My Profile</h4>
                    <div class="dashboard-profile__resume">
                        <div class="profile-resume-configuration">
                            <div class="profile-resume__image">
                                <img id="profile-img__id" src="<?php echo $imagen["url"] ?>" alt="<?php echo $imagen["alt"] ?>">
                            </div>
                            <div class="profile-resume__data">
                                <h4 id="fullname__id"><?php echo $fullname . " - " . $username; ?></h4>
                                <p><?php echo isset($isAdmin) ? "Admin" : "User"; ?></p>

                                <p id="summary__id">Lorem ipsum dolor sit.</p>
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
                                <label>Phone</label>
                                <p id="pNumber__id">+598 098 561 082</p>
                            </div>
                            <div class="saved-fields__field">
                                <label>Bio</label>
                                <p id="bio__id">My names is Joaquin</p>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="dashboard-fit__content__notifications" aria-step="2">
                    <h4>Notifications</h4>
                </section>
                <section class="dashboard-fit__content__security" aria-step="3">
                    <h4>Security</h4>
                </section>

                <section class="dashboard-fit__content__delelteAcc" aria-step="4">
                    <h4>Delete Account</h4>
                </section>
            </div>


        </div>

    </div>


</div>