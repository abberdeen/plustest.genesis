<?php

class security{

    const CIPHER="AES-128-CBC";

    /**
     * @return null
     */
    private static function key(){
        return $_SESSION[SS_USER_TOKEN];
    }

    /**
     * AES Authenticated Encryption
     * @param $plaintext
     * @return string
     */
    public static function encrypt($plaintext){
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, self::CIPHER, self::key(), $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, self::key(), $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }

    /**
     * @param $ciphertext
     * @return null|string
     */
    public static function decrypt($ciphertext){
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = substr($c, 0, $ivlen);
        if(strlen($iv) < $ivlen) return null;
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, self::CIPHER, self::key(), $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, self::key(), $as_binary=true);
        if (hash_equals($hmac, $calcmac))
        {
            return $original_plaintext;
        }
        return null;
    }
}