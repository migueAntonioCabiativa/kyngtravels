# KyngTravels API — Documentación

API REST en PHP puro (sin frameworks), con enrutamiento manual, autenticación JWT y protección contra fuerza bruta.

## Estructura de carpetas

```
api/
├── index.php               # Punto de entrada único, headers CORS, bootstrap
├── .htaccess                # Reescritura de URLs hacia index.php?route=...
├── .env                      # Variables de entorno reales (NO se sube a git)
├── .env.example              # Plantilla de variables de entorno
├── config/
│   ├── env.php                # loadEnv() y env() — carga y lectura de variables
│   └── database.php           # Config de conexión + crea $GLOBALS['pdo']
├── controllers/
│   ├── AuthController.php     # Login (POST /login)
│   └── UserController.php     # CRUD de usuarios (/users)
├── models/
│   └── User.php               # Acceso a datos (tabla `users`)
├── middleware/
│   ├── AuthMiddleware.php     # Valida Authorization: Bearer <token>
│   ├── Jwt.php                 # Encode/decode JWT (HS256) sin dependencias
│   └── RateLimiter.php         # Bloqueo tras intentos fallidos de login
└── routes/
    └── api.php                # Switch de rutas según ?route=
```

## Requisitos

- PHP 8.1+ (usa tipado estricto en propiedades y `str_contains`/`str_starts_with`)
- Extensión `pdo_mysql`
- MySQL/MariaDB
- Apache con `mod_rewrite` habilitado (usa [api/.htaccess](.htaccess))

## Variables de entorno

Copia [api/.env.example](.env.example) a `api/.env` y completa los valores:

| Variable | Descripción |
|---|---|
| `APP_ENV` | `development` \| `production` |
| `APP_DEBUG` | Muestra detalles de error si es `true` |
| `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_CHARSET` | Conexión MySQL |
| `JWT_SECRET` | Clave secreta para firmar tokens (usar valor aleatorio largo) |
| `JWT_ALGORITHM` | Algoritmo de firma, por defecto `HS256` |
| `JWT_TTL` | Tiempo de vida del token en segundos (por defecto 3600) |
| `CORS_ALLOWED_ORIGINS` | Orígenes permitidos (informativo, CORS actual es `*`) |

`api/.env` está excluido de git en [.gitignore](../.gitignore).

## Bootstrap ([index.php](index.php))

1. Define headers CORS y `Content-Type: application/json`.
2. Responde `200` inmediato a peticiones `OPTIONS` (preflight).
3. Incluye [routes/api.php](routes/api.php), que resuelve la ruta solicitada.

La conexión a la base de datos se crea una sola vez en [config/database.php](config/database.php) y queda disponible como `$GLOBALS['pdo']` (accesible en cualquier controlador con `global $pdo;`).

## Enrutamiento

No hay router de terceros: [.htaccess](.htaccess) reescribe cualquier URL hacia `index.php?route=<lo-que-venga>`, y [routes/api.php](routes/api.php) hace un `switch($route)`:

| Ruta (`?route=`) | Método | Controlador | Protegida |
|---|---|---|---|
| `login` | POST | `AuthController::login` | No |
| `users` | GET/POST/PUT/DELETE | `UserController::procesarPeticion` | Sí (JWT) |
| `productos` | GET/POST/PUT/DELETE | `ProductoController::procesarPeticion` | No (controlador no implementado aún) |

Ejemplo de URL real: `http://localhost/kyngtravels/api/index.php?route=users` (o `http://localhost/api/users` si el `.htaccess` está activo).

## Autenticación

### 1. Login — `POST /?route=login`

Body JSON:
```json
{
  "email": "admin@kyngtravels.com",
  "password": "123456"
}
```

Validaciones aplicadas en [controllers/AuthController.php](controllers/AuthController.php):
- Campos obligatorios (`400` si faltan)
- Formato de email válido (`400` si no lo es)
- Rate limiting por `IP + email` (`429` si excede intentos)
- Verificación de contraseña con `password_verify()` contra el hash guardado
- Mensaje idéntico para email inexistente o password incorrecta (evita user enumeration)
- Rehash automático del password si el algoritmo/costo quedó desactualizado (`password_needs_rehash`)

Respuesta exitosa (`200`):
```json
{
  "success": true,
  "message": "Login correcto",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "user": { "id": 1, "name": "...", "email": "..." }
}
```

Respuestas de error:
| Código | Motivo |
|---|---|
| 400 | JSON inválido / campos vacíos / email con formato inválido |
| 401 | Credenciales incorrectas |
| 429 | Demasiados intentos fallidos (incluye segundos de espera en el mensaje) |
| 500 | Error de base de datos |

### 2. Rate limiting ([middleware/RateLimiter.php](middleware/RateLimiter.php))

- Máximo **5 intentos fallidos** por combinación `IP|email`.
- Al superarlos, bloquea **900 segundos (15 min)**.
- Estado persistido en `api/storage/login_attempts.json` (carpeta excluida de git).
- Se resetea automáticamente tras un login exitoso.

### 3. JWT ([middleware/Jwt.php](middleware/Jwt.php))

Implementación propia de HS256/384/512 sin librerías externas:
- `Jwt::encode(array $payload)`: firma con `JWT_SECRET`, agrega header y firma en base64url.
- `Jwt::decode(string $token)`: valida firma (`hash_equals`) y expiración (`exp`); devuelve `null` si es inválido.

Payload emitido en el login:
```json
{ "sub": 1, "email": "admin@kyngtravels.com", "iat": 1755000000, "exp": 1755003600 }
```

### 4. Proteger un endpoint ([middleware/AuthMiddleware.php](middleware/AuthMiddleware.php))

Se invoca al inicio del `case` correspondiente en [routes/api.php](routes/api.php):
```php
AuthMiddleware::handle();
```
- Exige header `Authorization: Bearer <token>`.
- Si falta o el formato no es `Bearer <token>` → `401` "Token de autenticación requerido".
- Si el token no valida o expiró → `401` "Token inválido o expirado".
- Si es válido, devuelve el payload decodificado y la ejecución continúa.

Actualmente solo `users` está protegida. Para proteger otra ruta, agrega:
```php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
AuthMiddleware::handle();
```
antes de instanciar el controlador correspondiente.

## Endpoint `users`

`GET /?route=users` (requiere `Authorization: Bearer <token>`) — lista usuarios vía `User::getAll()`.

Otros métodos (`POST`, `PUT`, `DELETE`) están mapeados en [controllers/UserController.php](controllers/UserController.php) hacia `User::create()`, `User::update()`, `User::delete()`, pero **aún no reciben los datos del body** (`$_POST`/`json_decode`) ni los parámetros que sus firmas exigen — ver sección de pendientes.

## Modelo `User` ([models/User.php](models/User.php))

| Método | Descripción |
|---|---|
| `getAll()` | Lista usuarios. ⚠️ consulta la tabla `user` (singular) y columnas `first_name`/`last_name`, mientras el resto del modelo usa `users`/`name` — revisar contra el esquema real |
| `findById(int $id)` | Busca por id en `users` |
| `findByEmail(string $email)` | Busca por email, incluye `password` (hash) |
| `create(string $name, string $email, string $password)` | Inserta usuario, hashea password con `password_hash` |
| `update(int $id, string $name, string $email)` | Actualiza nombre/email |
| `delete(int $id)` | Elimina usuario |
| `updatePassword(int $id, string $newPassword)` | Actualiza password (hasheado) |

Todas las consultas usan sentencias preparadas (`PDO::prepare` + parámetros nombrados), lo que previene SQL Injection.

## Pendientes conocidos (no bloquean el uso básico, pero deben resolverse antes de producción)

1. `User::getAll()` consulta la tabla `user` con columnas `first_name`/`last_name`; el resto del modelo usa `users`/`name`. Unificar según el esquema real de la base de datos.
2. `UserController::procesarPeticion()` llama a `create()`, `update()`, `delete()` sin pasarles argumentos, pero esos métodos en `User` los requieren — falta leer el body (`json_decode(file_get_contents('php://input'))`) y pasar los datos.
3. `JWT_SECRET` en `.env` debe reemplazarse por un valor aleatorio largo antes de producción (actualmente placeholder).
4. CORS actualmente permite `*` — restringir a los orígenes de `CORS_ALLOWED_ORIGINS` en producción.
5. `ProductoController` está referenciado en las rutas pero no existe todavía.

## Ejemplo rápido con Postman

1. **Login**: `POST /?route=login` con `email`/`password` → copiar `token` de la respuesta.
2. **Users**: `GET /?route=users` con header `Authorization: Bearer <token>`.
3. Sin token o con token expirado/incorrecto → `401`.
