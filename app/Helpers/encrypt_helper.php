<?php

if (!function_exists('encrypt_url')) {
    function encrypt_url($string) {
        try {
            // Pastikan input adalah string
            $string = (string)$string;
            
            $encrypter = \Config\Services::encrypter();
            // Menggunakan strtr untuk mengubah karakter yang tidak aman di URL
            return strtr(base64_encode($encrypter->encrypt($string)), '+/=', '-_.');
        } catch (\Exception $e) {
            log_message('error', 'Encryption error: ' . $e->getMessage());
            return $string; // Return original string if encryption fails
        }
    }
}

if (!function_exists('decrypt_url')) {
    function decrypt_url($string) {
        try {
            $encrypter = \Config\Services::encrypter();
            // Mengembalikan karakter base64 standar
            $base64 = strtr($string, '-_.', '+/=');
            return $encrypter->decrypt(base64_decode($base64));
        } catch (\Exception $e) {
            log_message('error', 'Decryption error: ' . $e->getMessage());
            return $string; // Return original string if decryption fails
        }
    }
}
