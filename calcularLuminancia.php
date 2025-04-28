<?php
function linearizarCanal($c) {
        if ($c <= 0.04045) {
            return $c / 12.92;
        } else {
            return pow(($c + 0.055) / 1.055, 2.4);
        }
    }
    function calcularLuminancia($hex) {
        $regex = '/^#[a-fA-F0-9]{6}$/i';
        if (!preg_match($regex, $hex)) {
            return null; 
        }
        $hex = ltrim($hex, '#');
        $rHex = hexdec(substr($hex, 0, 2));
        $gHex = hexdec(substr($hex, 2, 2));
        $bHex = hexdec(substr($hex, 4, 2));
        $rSrgb = $rHex / 255;
        $gSrgb = $gHex / 255;
        $bSrgb = $bHex / 255;
        $rLinear = $this->linearizarCanal($rSrgb);
        $gLinear = $this->linearizarCanal($gSrgb);
        $bLinear = $this->linearizarCanal($bSrgb);
        $luminancia = 0.2126 * $rLinear + 0.7152 * $gLinear + 0.0722 * $bLinear;
        return $luminancia;
    }
    

    function getFontColorForBackground($hexColor) {
        $luminancia = calcularLuminancia($hexColor);
        if ($luminancia === null) {
            return null;
        }
        $umbral = 0.179;//Este valor corresponde al estandar WCAG AA, puedes ajustar de 0 a 1, para precisar la lumnancia sobre el umbral
        if ($luminancia > $umbral) {
            return '#000000'; //Retorna negro, para contraste
        } else {
            return '#FFFFFF';//retorna blanco
        }
    }
