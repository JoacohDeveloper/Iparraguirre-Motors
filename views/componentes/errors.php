<?php
echo "hello";
if (isset($errores)) {
    foreach ($errores as $key => $value) {
        echo "<div class='error'>$value</div>";
    }
}
