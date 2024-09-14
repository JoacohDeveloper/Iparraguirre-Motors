<div class="container">
    <aside class="settings-fit__content_aside">
        <div class="settings-userinfo_aside">
            <div class="profile-resume__image">
                <img id="profile-img__id" src="\build\src\images\users\default.jpg">
                <h4 id="fullname__id"><?php echo $fullname; ?></h4>
            </div>
        </div>
        <nav class="aside-nav">
            <ul class="steps">
                <li aria-label="step-1" id="profile" class="selected"><a href="#my_profile">Personal information</a></li>
                <li aria-label="step-2" id="notifications"><a href="#">Wishlist</a></li>
                <li aria-label="step-3" id="security"><a href="#">Cart</a></li>
                <li aria-label="step-4" id="change-pass"><a href="#">Change Password</a></li>
                <li aria-label="step-5" id="delete-account"><a href="#">Log out</a></li>
            </ul>
        </nav>
    </aside>
    <?php implementComp("error_toast.php")?>
</div>