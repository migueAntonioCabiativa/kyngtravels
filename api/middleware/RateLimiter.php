<?php

// Bloqueo temporal tras varios intentos fallidos de login, por IP + email
class RateLimiter
{
    private const MAX_ATTEMPTS = 5;
    private const LOCK_SECONDS = 900; // 15 minutos

    private static function storagePath(): string
    {
        $dir = __DIR__ . '/../storage';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir . '/login_attempts.json';
    }

    private static function read(): array
    {
        $path = self::storagePath();

        if (!is_file($path)) {
            return [];
        }

        $data = json_decode(file_get_contents($path), true);

        return is_array($data) ? $data : [];
    }

    private static function write(array $data): void
    {
        file_put_contents(self::storagePath(), json_encode($data), LOCK_EX);
    }

    public static function tooManyAttempts(string $identifier): bool
    {
        $entry = self::read()[$identifier] ?? null;

        return $entry !== null && $entry['locked_until'] > time();
    }

    public static function retryAfter(string $identifier): int
    {
        $entry = self::read()[$identifier] ?? null;

        return $entry === null ? 0 : max(0, $entry['locked_until'] - time());
    }

    public static function registerFailedAttempt(string $identifier): void
    {
        $data = self::read();
        $entry = $data[$identifier] ?? ['attempts' => 0, 'locked_until' => 0];

        // Reinicia el contador si el bloqueo anterior ya expiró
        if ($entry['locked_until'] > 0 && $entry['locked_until'] <= time()) {
            $entry = ['attempts' => 0, 'locked_until' => 0];
        }

        $entry['attempts']++;

        if ($entry['attempts'] >= self::MAX_ATTEMPTS) {
            $entry['locked_until'] = time() + self::LOCK_SECONDS;
        }

        $data[$identifier] = $entry;
        self::write($data);
    }

    public static function reset(string $identifier): void
    {
        $data = self::read();
        unset($data[$identifier]);
        self::write($data);
    }
}
