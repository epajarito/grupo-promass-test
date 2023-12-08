# Grupo Promass - Prueba tecnica


### Tecnologías usadas
- PHP 8.1
- Laravel 10
- Mysql
- Pest
- Postman

## Instalación

Usar composer para instalar dependencias de Laravel

```bash
composer install
```

## Crear archivo .env
```bash
cp .env.example .env
```
## Ejecutar el siguiente comando para generar el app key de la aplicación
```bash
php artisan key:generate
```

## Generar enlace simbolico
```bash
php artisan storage:link
```
## Configurar base de datos (en este caso usa Mysql)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu-base-de-datos
DB_USERNAME=tu-usuario
DB_PASSWORD=tu-contraseña
```

## Ejecutar migraciones
```bash
php artisan migrate --seed #se genera tablas con datos ficticios
```

## Levantar proyecto en local
```bash
php artisan serve --port=8081
```
## Ejecutar tests
```bash
php artisan test
or 
./vendor/bin/pest
```

### Acceder a la API con las siguientes credenciales ADMIN
```bash
telephone: 1234567892
password: password
```

### Acceder a la API con las siguientes credenciales USUARIO
```bash
telephone: 1234567891
password: password
```

### Dentro de la carpeta public se encuentra el archivo de postman para probar la API
```bash
promass.postman_collection.json
```

Solo será necesario generar una variable de entorno llamado 
```bash
url
```