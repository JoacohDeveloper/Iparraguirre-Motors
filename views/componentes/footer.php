<footer class="<?php echo isset($class) ? $class : "" ?>">

<div class="footer">
    <div class="footer-section">
      <h3>Iparraguirre-Motors</h3>
      <div class="social-icons">
        <a href="https://www.facebook.com/">
            <img src="/build/src/images/footer/facebook-white.png" alt="facebook social-icons" class="icon-white" id="icon-facebook">
            <img src="/build/src/images/footer/facebook-black.png" alt="facebook social-icons" class="icon-black" id="icon-facebook">
        </a>
        <a href="https://www.instagram.com/">
            <img src="/build/src/images/footer/instagram-white.png" alt="instagram social-icons" class="icon-white" id="icon-instagram">
            <img src="/build/src/images/footer/instagram-black.png" alt="instagram social-icons" class="icon-black" id="icon-instagram">
        </a>
        <a href="https://x.com/">
            <img src="/build/src/images/footer/twitter-white.png" alt="twitter social-icons" class="icon-white" id="icon-twitter">
            <img src="/build/src/images/footer/twitter-black.png" alt="twitter social-icons" class="icon-black" id="icon-twitter">
        </a>
    </div>

      <div class="payments-icons">
        <img src="/build/src/images/footer/visa.svg" alt="visa payments-icons">
        <img src="/build/src/images/footer/mastercard.svg" alt="mastercard payments-icons">
        <img src="/build/src/images/footer/maestro.svg" alt="maestro payments-icons">
      </div>
    </div>

    <div class="footer-section">
      <h3>Navegación</h3>
      <ul class="nav-links">
        <li><a href="/">Inicio</a></li>
        <li><a href="/catalogo/vehiculos">Tienda</a></li>
        <li><a href="/cuenta">Cuenta</a></li>
        <li><a href="/faq">FAQ</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h3>Información</h3>
      <ul class="info-links">
        <li><a href="#">Política de Privacidad</a></li>
        <li><a href="#">Términos y Condiciones</a></li>
      </ul>
      <?php include __DIR__ . "/themeSwitcher.php"; ?>
    </div>
  </div>
  
  <div class="footer-bottom">
    <p>&copy; <?php echo date("Y");?> Iparraguirre-Motors. Todos los derechos reservados.</p>
  </div>
</footer>
