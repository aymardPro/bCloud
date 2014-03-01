<?php

App::uses('Component', 'Controller');

class BCloudComponent extends Component 
{
    public function getAlias($str)
    {
        $str = str_replace('&', 'et', $str);
		
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
    public function rand_str($length = 32, $chars = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789')
    {
        // Length of character list
        $chars_length = (strlen($chars) - 1);
        
        // Start our string
        $string = $chars{rand(0, $chars_length)};
        
        // Generate random string
        for ($i = 1; $i < $length; $i = strlen($string))
        {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};
            
            // Make sure the same two characters don't appear next to each other
            if ($r != $string{$i - 1}) $string .=  $r;
        }
        
        // Return the string
        return $string;
    }
    
    /*
     * Valeurs possible de $options
     *  data : 
     *  allowed : tableau de type mimes acceptés. Ex. array('application/pdf','application/msword', 'image/*')
     *  rep : dossier dans le repertoire de destination
     * 
     *  $require: indique si l'upload est obligatoire ou pas
     */
    public function upload($options = array())
    {
        App::uses('Upload', 'Vendor/Upload');        
        $handle = new Upload($options['data'], 'fr_FR');
        
        if ($handle->uploaded) {
            if (array_key_exists('allowed', $options)) {                
                $handle->allowed = $options['allowed'];
            }
            
            if (array_key_exists('safe_name', $options)) {                
                $handle->file_safe_name = $options['safe_name'];
            }
            $handle->file_auto_rename   = true;
            $handle->file_overwrite     = true;
            
            $handle->process(WWW_ROOT . Configure::read('iDream.uploadDir') . DS . sha1(AuthComponent::user('compte_id')) . DS . $options['rep']);
            
            if ($handle->processed) {
                $this->uploadName = $handle->file_dst_name;
                $handle->clean();
                return true;
            } else {
                $this->uploadMessage = $handle->error;
                return false;
            }
        } else {
            $this->uploadMessage = $handle->error;
            return false;
        }
    }
    
    public function safeName($filename)
    {
        $new_name = str_replace(array(' ', '-'), array('_','_'), $filename);
        $new_name = preg_replace('/[^A-Za-z0-9_]/', '', $new_name);
        return $new_name;
    }
}