<footer class="<?php echo isset($class) ? $class : "" ?>">

<div class="footer">
    <div class="footer-section">
      <h3>Iparraguirre-Motors</h3>
      <div class="social-icons">
        <a href="https://www.facebook.com/"><img src="/build/src/images/footer/facebook-icon.png" alt="facebook social-icons" id="icon-facebook"></a>
        <a href="https://www.instagram.com/"><img src="/build/src/images/footer/instagram-icon.png" alt="instagram social-icons" id="icon-instagram"></a>
        <a href="https://x.com/"><img src="/build/src/images/footer/twitter-icon.png" alt="twitter social-icons" id="icon-twitter"></a>
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
        <li><a href="/catalogo">Catalogo</a></li>
        <li><a href="/faq">Ayuda</a></li>
        <li><a href="/settings?u=<?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUUID() : ""; ?>">Cuenta</a></li>
        <li><a href="/checkout/cart">Carrito</a></li>
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
