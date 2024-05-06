<?php

    $enc_key = "password";

    function encryptData($cargoCode,$token) {
        global $enc_key;
        $data = $cargoCode.'|@|'.$token;
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $enc_key, 0, $iv);
        echo base64_encode($iv . $encryptedData);
    }

    function decryptData($data) {
        global $enc_key;
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $encryptedData = substr($data, 16);

        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $enc_key, 0, $iv);
    
        if ($decryptedData === false) {
            $error = openssl_error_string();
            echo "Failed to decrypt data! Error: $error";
        } else {
            echo $decryptedData;
        }
    }