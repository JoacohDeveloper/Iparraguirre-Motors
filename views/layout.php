<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo isset($description) ? $description : 'Pagina automotora de vehiculos | Iparraguirre Motors'?>">
    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <link rel="stylesheet" href="/build/css/globals.css">
    <?php
        //styles loader
        
        if(isset($styles) && count($styles) != 0) {
            foreach($styles as $style) {
                $file = str_replace("\\views", "/public", dirname(__FILE__)) . "/build/css/$style.css";

                $file = str_replace("\\", "/", $file);

               
                if(file_exists($file)) {  
                    echo "<link rel='stylesheet' href='$file'>";
                }
            }
        }
    ?>
    <script defer src="/build/js/index.js"></script>
    <title><?php echo isset($title) ? $title : "Iparraguirre Motors"?></title>
</head>
<body>
        <header>
           header
        </header>

        <?php echo $contenido;?>   

        <footer>
            footer
        </footer>

        <?php
        //script loader
        if(isset($scripts) && count($scripts) != 0) {
            foreach($scripts as $script) {
                
                $file = "/build/js/$script.js";   
                echo "<script src='$file'></script>";
                
            }
        }
    ?>
</body>
</html>