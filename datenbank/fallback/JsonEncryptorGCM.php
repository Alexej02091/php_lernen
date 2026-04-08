<?php
class JsonEncryptorGCM {

    privete $key;
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function encrypt(array $data): array {
        $json = json_encode($data);

        $iv = random_bytes(12);
        $tag = null;

        $cipher = openssl_encrypt(
            $json,
            "aes-256-gcm",
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
    
        return [
            "cipher" => base64_encode($cipher),
            "iv"     => base64_encode($iv),
            "tag"    => base64_encode($tag)
        ];

    }

    public function decrypt (string $cipher, string $iv, string $tag): array {
        $json = openssl_decrypt(
            base64_decode($cipher),
            "aes-256-gcm",
            $this->key,
            OPENSSL_RAW_DATA,
            base64_decode($iv),
            base64_decode($tag)
        );

    return json_decode($json, true);
    }
}

?>