<?php

class JWT {
    /**
     * Headers for JWT
     *
     * @var array
     */
    private $headers;
    /**
     * Secret for JWT
     *
     * @var string
     */
    private $secret;

    public function __construct() {
        
        $this->headers = [
            'alg' => 'HS256',
            'typ' => 'JWT',
            'iss' => 'http://localhost/API_project/jwt/',
            'aud' => 'http://localhost/API_project'
        ];

        $this->secret = "this_is_my_secret";
    }
    /**
     * A public function to generate JWT using a Payload.
     *
     * @param array $payload
     * @return string
     */
    public function generate(array $payload): string {
        $headers = $this->encode(json_encode($this->headers));
        $payload['exp'] = time() + 60;
        $payload = $this->encode(json_encode($payload));
        $signature = hash_hmac('SHA256', "$headers.$payload", $this->secret, true);
        $signature = $this->encode($signature);
        return "$headers.$payload.$signature";
    }
    /**
     * A private function that encode/encrypt our JWT using base64.
     *
     * @param string $str
     * @return string
     */
    private function encode(string $str): string {

        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
    /**
     * A public function that checks if our JWT key is valid
     *
     * @param string $jwt
     * @return boolean
     */
    public function is_valid(string $jwt): bool {
        $token = explode('.', $jwt);
        if (!isset($token[1]) && !isset($token[2])) {
            return false;
        }
        /**
         * To Extract and decode the content of JWT using base64.
         */
        $headers = base64_decode($token[0]);
        $payload = base64_decode($token[1]);
        /**
         * To store the encoded value of the JWT secret for later validation
         */
        $clientSignature = $token[2];
        /**
         * To validate if the payload contains json data.
         */
        if (!json_decode($payload)) {
            return false;
        }
        /**
         * To check if the payload expiry time is less than zero
         */
        if (json_decode($payload)->exp - time() < 0) {
            return false;
        }
        /**
         * To check if the header issuer is equal to the payload issuer
         */
        if (isset(json_decode($payload)->iss)) {
            if (json_decode($payload)->iss != json_decode($headers)->iss) {
                return false;
            }
        } else {
            return false;
        }
        /**
         * To check if the header audience is equal to payload audience
         */
        if (isset(json_decode($payload)->aud)) {
            if (json_decode($payload)->aud != json_decode($headers)->aud) {
                return false;
            }
        } else {
            return false;
        }

        $base64_headers = $this->encode($headers);
        $base64_payload = $this->encode($payload);

        $signature = hash_hmac('SHA256', "$base64_headers.$base64_payload", $this->secret, true);
        $base64_signature = $this->encode($signature);
        /**
         * To compare the client encoded signature with the encoded JWT secret and return a boolean value
         */
        return ($base64_signature === $clientSignature);
    }

}
