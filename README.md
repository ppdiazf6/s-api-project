
# PRUEBA API REST SERVITEL 
SERVITEL API

## INSTALACION DEL PROYECTO
1. Clonar el proyecto
https://github.com/ppdiazf6/s-api-project

2. Ejecutar npm install & npm run build para realizar las instalaciones necesarias

3. Configurar archivo .env
DB_DATABASE=api_system
DB_USERNAME=root
DB_PASSWORD=

4. Generar una api key para la API Externa de de Clima y cambiar en el archivo .env
OPENWEATHER_API_KEY={MI_API_KEY}
OPENWEATHER_BASE_URL=https://api.openweathermap.org/data/2.5

5. Generar el secret de JWT
php artisan jwt:secret

Si fuera necesario, publicar configuracion
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

6. En el archivo conf/auth.php debe contener lo siguiente
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],


## BASE DE DATOS
Ejecutar las migraciones para la creacion de la BD.
php artisan migrate

## ENDPOINTS
Enpoints en postman:

1. Crear un enviroment Servitel_API
base_url: http://127.0.0.1:8000/api
token: (vacío por el momento)

2. Crear un request para registrar
POST {{base_url}}/auth/register

En la pestaña Body con JSON
{
    "email": "test@test.com",
    "password": "123456789"
}

Enviar

3. Crear un request para el login 
POST {{base_url}}/auth/login

En la pestaña headers: 
Accept: application/json

En la pestaña Body con JSON
{
    "email": "test@test.com",
    "password": "123456789"
}

En la pestaña Test: 
const jsonData = pm.response.json();
if (jsonData.token) {
    pm.environment.set("token", jsonData.token);
    console.log("Token guardado correctamente");
} else {
    console.error("No se encontró la clave 'token' en la respuesta");
}

Enviar

4. Crear request para productos y/o notas

En la pestaña headers
Authorization: Bearer {{token}}
Accept: application/json
Content-Type: application/json

Endpoints Notas 
GET /items
GET /items/{id}
POST /items
PUT /items/{id}
DELETE /items/{id}

5. Consumo de API Externa (CLIMA o PELICULAS)
GET /weather

Para consumir el API de peliculas se debe generar api key 

GET /movies/
GET /movies/{title}


## EJECUCION DEL PROYECTO
Ejecutar el servidor local
php artisan serve

# LINK a considerar
Web para API KEY 

PELICULAS: http://www.omdbapi.com/
CLIMA: https://api.openweathermap.org/data/2.5
