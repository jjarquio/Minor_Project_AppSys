<?php

class Vault {
    private $encrypt_method = "AES-256-CBC";
    private $key;
    private $iv;

    function Vault(){
        $this->key = hash('sha256', 'Your own salt key here');
        $this->iv = substr(hash('sha256', 'Your own salt key here'), 0, 16);
    }

    function press($str){
        return base64_encode(openssl_encrypt($str, $this->encrypt_method, $this->key, 0, $this->iv));
    }

    function open($str){
        return openssl_decrypt(base64_decode($str), $this->encrypt_method, $this->key, 0, $this->iv);
    }

    function hash($str){
        return password_hash($str, PASSWORD_BCRYPT, ['cost' => 9, 'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)]);
    }

    function verify($str, $key){
        return password_verify($str, $key);
    }
}

?>
