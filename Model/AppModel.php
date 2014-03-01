<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Model', 'Model');
App::uses('CakeTime', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model
{
    public function getAlias($string)
    {
        $str = str_replace('&', 'et', $string);
        
        // On convertit la chaîne en UTF-8 si besoin est.
        if($str !== mb_convert_encoding(mb_convert_encoding($str,'UTF-32','UTF-8'),'UTF-8','UTF-32')) {
            $str = mb_convert_encoding($str,'UTF-8');
        }
        $str = htmlentities($str, ENT_NOQUOTES ,'UTF-8');
        
        // Quelques entités à remplacer par les lettres correspondantes.
        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i','$1',$str);
        $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'),'-',$str);
        return strtolower(trim($str,'-'));
    }
    
    // Generate a random character string
    public function randomString($length = 32, $pwd = false, $type = false)
    {
        switch ($type) {
            case 0:
                $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ';
                break;
                
            case 1:
                $chars = 'abcdefghjkmnpqrstuvwxyz';
                break;
                
            case 2:
                $chars = '1234567890';
                break;
                
            default:
                $chars = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
                break;
        }
        
        if ($pwd) {
            $chars .= "@#$%&_-+={}[]|<>?";
        }
        // Length of character list
        $chars_length = (strlen($chars) - 1);
        
        // Start our string
        $string = $chars{rand(0, $chars_length)};
        
        // Generate random string
        for ($i = 1; $i < $length; $i = strlen($string)) {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};
            
            // Make sure the same two characters don't appear next to each other
            if ($r != $string{$i - 1}) $string .=  $r;
        }
        // Return the string
        return $string;
    }
    
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
