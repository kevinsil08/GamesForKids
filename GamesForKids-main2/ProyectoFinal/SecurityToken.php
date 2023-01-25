<?php
class secureToke
{
    private static $secretKey = 'Your Desired key(Hash)';
    private static $secretIv = 'www.domain.com';
    private static $encryptMethod = "AES-256-CBC";
    public static function tokenencrypt($data)
    {
        $key = hash('sha256', self::$secretKey);
        $iv = substr(hash('sha256', self::$secretIv), 0, 16);
        $result = openssl_encrypt($data, self::$encryptMethod, $key, 0, $iv);
        return $result = base64_encode($result);
    }

    public static function tokendecrypt($data)
    {
        $key = hash('sha256', self::$secretKey);
        $iv = substr(hash('sha256', self::$secretIv), 0, 16);
        $result = openssl_decrypt(base64_decode($data), self::$encryptMethod, $key, 0, $iv);
        return $result;
    }
}
?>