<?php

/**
 * 
 */
class BCloudHelper extends AppHelper
{
    function uppercase($string)
    {
        $tbl = array( 
            "à" => "À", "è" => "È", "ì" => "Ì", "ò" => "Ò", "ù" => "Ù", 
            "á" => "Á", "é" => "É", "í" => "Í", "ó" => "Ó", "ú" => "Ú", 
            "â" => "Â", "ê" => "Ê", "î" => "Î", "ô" => "Ô", "û" => "Û", 
            "ç" => "Ç",
        );
        return(strtr(strtoupper($string), $tbl));
    }
}
