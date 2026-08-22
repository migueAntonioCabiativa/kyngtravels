<?php

// JWT minimalista (HS256/384/512) sin dependencias externas
class Jwt
{
    public static function encode(array $payload, ?string $secret = null, ?string $algorithm = null): string
    {
        $secret ??= env('JWT_SECRET');
        $algorithm ??= env('JWT_ALGORITHM', 'HS256');

        $header = self::base64UrlEncode(json_encode(['typ' => 'JWT', 'alg' => $algorithm]));
        $body = self::base64UrlEncode(json_encode($payload));

        $signature = self::sign("{$header}.{$body}", $secret, $algorithm);

        return "{$header}.{$body}.{$signature}";
    }

    public static function decode(string $token, ?string $secret = null): ?array
    {
        $secret ??= env('JWT_SECRET');

        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return null;
        }

        [$header, $body, $signature] = $parts;

        $headerData = json_decode(self::base64UrlDecode($header), true);
        $algorithm = $headerData['alg'] ?? 'HS256';

        $expectedSignature = self::sign("{$header}.{$body}", $secret, $algorithm);

        if (!hash_equals($expectedSignature, $signature)) {
            return null;
        }

        $payload = json_decode(self::base64UrlDecode($body), true);

        if (!is_array($payload)) {
            return null;
        }

        if (isset($payload['exp']) && time() >= $payload['exp']) {
            return null;
        }

        return $payload;
    }

    private static function sign(string $data, string $secret, string $algorithm): string
    {
        $algoMap = ['HS256' => 'sha256', 'HS384' => 'sha384', 'HS512' => 'sha512'];
        $hashAlgo = $algoMap[$algorithm] ?? 'sha256';

        return self::base64UrlEncode(hash_hmac($hashAlgo, $data, $secret, true));
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
