<?php

// Prime numbers used for encryption and decryption
$primes = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499];

// Encryption function
if (!function_exists('prime_encrypt')) {
    function prime_encrypt($data) {
        global $primes;
        $encrypted = '';
        foreach (str_split($data) as $char) {
            $ascii = ord($char);
            $prime = $primes[$ascii % count($primes)]; // Use a prime number for encryption
            $encrypted .= chr($ascii + $prime); // Shift the ASCII value
        }
        return base64_encode($encrypted);
    }
}

// Decryption function
if (!function_exists('prime_decrypt')) {
    function prime_decrypt($data) {
        global $primes;
        $data = base64_decode($data);
        $decrypted = '';
        foreach (str_split($data) as $char) {
            $ascii = ord($char);
            $prime = $primes[$ascii % count($primes)]; // Use the same prime number for decryption
            $decrypted .= chr($ascii - $prime); // Reverse the shift
        }
        return $decrypted;
    }
}
