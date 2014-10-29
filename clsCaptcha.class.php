<?php

class Captcha 
{

    private $listaCaracteres;
    private $pastaSouceCaptcha;
    private $pastaFontesTTF;

    public function __construct($listaCaracteres, $fontesCaptcha, $sourceCaptcha) 
    {
        $this->setListaCaracteres($listaCaracteres);
        $this->setPastaFontesTTF($fontesCaptcha);
        $this->setPastaSouceCaptcha($sourceCaptcha);
    }

    public function setPastaSouceCaptcha($sourceCaptcha) 
    {
        if (file_exists($sourceCaptcha)) 
        {
            $this->pastaSouceCaptcha = $sourceCaptcha . "/captcha.png";
        } 
        else 
        {
            trigger_error('A "pasta" informada não existe', 256);
        }
    }

    public function setPastaFontesTTF($pastaFontes)
    {
        if (file_exists($pastaFontes)) 
        {

            $diretorio = dir($pastaFontes);
            while ($arquivo = $diretorio->read()) 
            {
                $arquivos[] = $arquivo;
            }

            $diretorio->close();

            for ($a = 0; sizeof($arquivos) > $a; $a++) 
            {
                $fonteTTF = explode(".", $arquivos[$a]);
                if (sizeof($fonteTTF) == 2) 
                {
                    if ($fonteTTF[1] == "ttf") 
                    {
                        $arrayFinalFontes[] = $pastaFontes . "/" . $arquivos[$a];
                    }
                }
            }

            if (!isset($arrayFinalFontes)) 
            {
                $arrayFinalFontes = "";
            }

            $this->pastaFontesTTF = $arrayFinalFontes;
        } 
        else 
        {
            trigger_error('A "pasta" informada não existe', 256);
        }
    }

    public function setListaCaracteres($listaCaracteres) 
    {
        $this->listaCaracteres = $listaCaracteres;
    }

    function captchaGerator($width, $height, $ch) 
    {
        $pos = $this->listaCaracteres;
        $i = 0;
        $code = "";
        while ($i < $ch) 
        {
            $code .= substr($pos, mt_rand(0, strlen($pos) - 1), 1);
            $i++;
        }
        $font_size = $height * 0.6;
        $image = imagecreate($width, $height);
        $bg_color = imagecolorallocate($image, 240, 247, 255);
        $text_color = imagecolorallocate($image, 0, 0, 150);
        $n_color = imagecolorallocate($image, 120, 160, 180);

        for ($i = 0; $i < ($width * $height) / 3; $i++) 
        {
            imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $n_color);
        }
        for ($i = 0; $i < ($width * $height) / 160; $i++) 
        {
            imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $n_color);
        }

        $font = $this->pastaFontesTTF;

        $rand = array($ch);
        $rand2 = array($ch);
        $ii = 0;
        $x = 0;
        $y = $height;
        while ($ii < $ch) 
        {
            $ver = substr($code, $ii, 1);
            $f = mt_rand(0, count($font) - 1);
            $rand[$ii] = $f;
            $rand2[$ii] = $x;
            $textbox = imagettfbbox($font_size, 0, $font[$f], $ver);
            $y = ($y > ($height - $textbox[5]) / 2) ? ($height - $textbox[5]) / 2 : $y;
            $x += $textbox[4] + 4;
            $ii++;
        }

        if ($x - 4 > $width) 
        {
            $this->captchaGerator($width, $height, $ch);
            exit;
        }

        $x = ($width - $x) / 2;
        $i = 0;
        while ($i < $ch) 
        {
            imagettftext($image, $font_size, 0, ($rand2[$i] + $x), 30, $text_color, $font[$rand[$i]], substr($code, $i, 1));
            $i++;
        }
        $_SESSION["seguranca"] = $code;
        imagepng($image, $this->pastaSouceCaptcha);
        return $this->pastaSouceCaptcha."?".$this->randonSequence();
    }
    function randonSequence($tamanho = 5)
    {
	$retorno = '';
	$caracteres = $this->listaCaracteres; 
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) 
        {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
	}
	return $retorno;
    }
    function getCodeCaptcha() 
    {
        $code = $_SESSION['seguranca'];
        if (strlen($code) == 5) 
        {
            return $code;
        }
    }

    function getCaminhoImagem() 
    {
        return $this->pastaSouceCaptcha;
    }

    function codeChecker($code) 
    {
        if ($this->getCodeCaptcha() == $code) 
        {
            $result = true;
        } else 
        {
            $result = false;
        }
        return $result;
    }
}

