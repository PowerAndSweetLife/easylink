<?php

namespace App\Helper;

use DateInterval;
use DateTime;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;
use Throwable;

class JWT {
    
    const KEY = "easylink-test";

    public static function encode($data): string
    {
        $dt = new DateTime();
        $dt = $dt->add(DateInterval::createFromDateString('900 seconds'));
        $paylod = [
            'exp' => $dt->getTimestamp(),
            'data' => $data
        ];

        $jwt = FirebaseJWT::encode($paylod, self::KEY, 'HS256');

        return $jwt;
    }

    public static function decode(string $token)
    {
        try {
            return FirebaseJWT::decode($token, new Key(self::KEY, 'HS256'));
        } catch(Throwable $th) {
            return null;
        }
    }

}