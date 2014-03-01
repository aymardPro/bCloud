<?php

/**
 * 
 */
class Dream
{
	private $keygen, $cipher, $mode, $size, $source, $iv_size;
	
	public function __construct()
	{
		// la clé devrait être un binaire aléatoire, utilisez la fonction scrypt, bcrypt
		// ou PBKDF2 pour convertir une chaîne de caractères en une clé.
		// La clé est spécifiée en utilisant une notation héxadécimale.
		$this->key = pack('H*', md5(Configure::read('Security.salt')));
		
		$this->cipher = MCRYPT_RIJNDAEL_256;
		$this->mode = MCRYPT_MODE_CBC;
		$this->source = MCRYPT_RAND;
		
		$this->iv_size = mcrypt_get_iv_size($this->cipher, $this->mode);
	}
	
    public function encrypt($string)
    {
        if(!$string) {
        	return false;
        }
		
		// Crée un IV aléatoire à utiliser avec l'encodage CBC
		$iv = mcrypt_create_iv($this->iv_size, $this->source);
		
		// Crée un texte cipher compatible avec AES (Rijndael block size = 256)
		// pour conserver le texte confidentiel.
		// Uniquement applicable pour les entrées encodées qui ne se terminent jamais
		// pas la valeur 00h (en raison de la suppression par défaut des zéros finaux)
		$ciphertext = mcrypt_encrypt($this->cipher, $this->keygen, $string, $this->mode, $iv);
		
		// On ajoute à la fin le IV pour le rendre disponible pour le chiffrement
		$ciphertext = $iv . $ciphertext;
		
		// Encode le texte du cipher résultant pouvant être représenté ainsi sous forme de chaîne de caractères
        return trim(base64_encode($ciphertext));
    }
    
    public function decrypt($string)
    {
        if(!$string) {
            return false;
		}
		
		$ciphertext_dec = base64_decode($string);
		
		// Récupère le IV, iv_size doit avoir été créé en utilisant la fonction
		// mcrypt_get_iv_size()
		$iv_dec = substr($ciphertext_dec, 0, $this->iv_size);
		
		// Récupère le texte du cipher (tout, sauf $iv_size du début)
		$ciphertext_dec = substr($ciphertext_dec, $this->iv_size);
		
		// On doit supprimer les caractères de valeur 00h de la fin du texte plein
        return trim(mcrypt_decrypt($this->cipher, $this->keygen, $ciphertext_dec, $this->mode, $iv_dec));
    }
}
