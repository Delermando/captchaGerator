<html>
    <head>
       
        <title></title>
    </head>
    <body>
        <?php
            session_start();
            ini_set('display_errors', 'on');
            error_reporting(E_ALL);
            require_once 'clsCaptcha.class.php';
            
            $captcha = new Captcha("2tvcdfn45wxhj38g67pqrskm9byz", "fontesCaptcha", "imagenCaptcha");
            $caminho = $captcha->captchaGerator(120, 40, 5);
            var_dump($caminho);
            $code = "dedede";  
            var_dump($captcha->codeChecker($code));
           
        ?>
        <br />
        <img src="<?php echo $caminho; ?>" alt="" />
    </body>
</html>
