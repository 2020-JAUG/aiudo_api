<a name="top"></a>
<h1 align ="center"> API Bank </h1>
<br>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# <p align ="center">Puesta en marcha</p>

## Configuracion inicial

En la raíz del proyecto debes encontrar el fichero `.env.example` que debe ser renombrado como `.env`

## Instalación de dependencias

El proyecto utiliza Docker. Las únicas dependencias son:

- `make`
- `docker`
- `docker-compose`

## Configuración de Docker

Para configurar Docker, simplemente ejecute el siguiente comando:

```bash
$ make up
```

## Para reestablecer los contenedores:

```bash
$ make down && make prune && make up
```

User `composer` y `php` a través de la consola:

## Laravel

```bash
$ make shell php

$ php -v
$ composer -v

# Set permissions to create logs
$ chmod -R 775 storage/*

# Install the PHP dependencies
$ composer install

# APP token:
$ php artisan key:generate

# If you want to remove the routes cache on your server
$ php artisan route:clear
# If you want to cache on your server
$ php artisan cache:clear
# If you want to clean views compilation
$ php artisan view:clear

# In case you want to exit the shell you just have to type
$ exit
```

# <h1 align ="center"> Index </h1>

- [¿Qué es? 🧐](#about)
- [Entidad Relación](#entidad)
- [Factories](#seed)
- [Requerimientos ⚙️](#requirements)
- [Tecnologías](#tecnol)

<a name="about"></a>
# <h1 align ="center"> ¿Qué es?  </h1>

Es una API REST privada creada con Laravel. Simula un sistema bancario básico donde los usuarios realizan diferentes operaciones, por ejemplo:

- Crear cuentas bancarias.
- Crear préstamos.
- Historial de pagos.
- Sistema seguro de login.
- Recuperación de contraseña. Para la recuperación de contraseña.

<a name="entidad"></a>
# <h1 align ="center"> Entidad Relación  </h1>

He creado tres tablas y las relacione junto con la tabla de usuarios. Solo los dueños de sus cuentas podrán acceder a su información, consigo esta autenticación por medio del sistema <b>Sanctum</b>.

Para poder crear una cuenta un préstamo o un historial de pagos, necesitas ser un administrador. En el archivo de rutas dejo credenciales de uno, para sus pruebas.

<img src="resources/assets/DDBB.png" width="1000">

<a name="seed"></a>
# <p align ="center">Factoriyes - Seeds ⚒</p>
- Para generar datos aleatorios en la base de datos, he utilizado la libreria <b>Faker</b>. Para poder hacer uso de las <b>Factories</b>.
#### Implementación:
- [Crear usuarios, línea 23 a 37](database/factories/UserFactory.php).
- [Crear cuentas manteniendo la entidad referencial, línea 23 a 28](database/factories/CuentaFactory.php).
- [Instanciamos los modelos para poder hacer uso de las seeds, línea 17 a 20](database/seeders/DatabaseSeeder.php).


<br/>

<a name="tecnol"></a>
# <p align ="center">Tecnologías 💻</p>

<a href="https://git-scm.com/" target="_blank"> <img src="https://www.vectorlogo.zone/logos/git-scm/git-scm-icon.svg" alt="git" width="40" height="40"/> <a href="https://www.php.net/" target="_blank"> <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="php" width="40" height="40"/> </a><img src="resources/assets/laravel.png" alt="laravel" height="56" width="60"> <img src="resources/assets/composer.png" alt="composer" height="52" width="47">  <a href="https://postman.com" target="_blank"> <img src="https://www.vectorlogo.zone/logos/getpostman/getpostman-icon.svg" alt="postman" width="40" height="40"/> </a> </a> <img src="resources/assets/workbench.png" alt="workbench" width="40" height="40"/> <img src="resources/assets/docker-logo.png" alt="docker" width="60" height="57"/></a>


[UP](#top)
