<?php

namespace App\Util;

class Helper
{

    public static function encrypt($string): string
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '45345345345435345';
        $secret_iv = 'dfg546yjdfj6rturt7';

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        return base64_encode($output);
    }

    public static function decrypt($string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '45345345345435345';
        $secret_iv = 'dfg546yjdfj6rturt7';

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
}
