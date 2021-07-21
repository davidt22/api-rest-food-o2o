# Solucion ejercicio de entrevista técnica

## Primeros pasos 

El proyecto usa Docker para correr el API con las librerias necesarias 
sin tener que instalar nada en el equipo de forma local y evitar problemas con
distintas versiones en los distintos equipos.

Para lanzar el proyecto hay que ejecutar los siguientes comandos:

- $ docker-compose up -d --build --force-recreate

Este comando arranca los contenedores Docker de Nginx y PHP-FPM.

Una vez esten corriendo los contenedores, hay que instalar las dependencias con:
- $ docker-compose exec php-fpm composer install

Al terminar, se podra consultar la API desde la siguiente URL:
- 127.0.0.1:12000

## Endpoints

Existen dos endpoints para consultar cervezas segun la comida recomendada.
Dichos endpoints se pueden consultar desde el navegador o desde Postman(GET).

- 127.0.0.1:12000/food/{comida} : Devuelve los tipos de cerveza recomendados para dicha comida (id, nombre, descripción)

- 127.0.0.1:12000/food/detail/{comida} : Devuelve los tipos de cerveza recomendados para dicha comida con información detallada (id, nombre, descripción, imagen, slogan y fabricación)

## Tests (PHPUnit)
Se han incluido tests unitarios, y funcionales para testear que tanto los application service como los controllers hacen lo que tienen que hacer y devuelven la información que se pide en el ejercicio.

Para correr la suite de test hay que ejecutar el comando:

- $ docker-compose exec php-fpm php vendor/bin/phpunit

## Eliminar contenedores de Docker

Para eliminar los contenedores creados para este proyecto, limpiar espacio y dejar libre los puertos se debe ejecutar este comando:

- $ docker-compose down

## Breve resumen 
El proyecto se ha desarrollado usando Arquitectura Hexagonal y DDD. La estructura se divide en:
- Application
- Domain
- Infrastructure

En cada directorio se han incluido las clases necesarias para seguir esta arquitectura, asi como los servicios que he creido convenientes 
para separar la logica en capas.

Los tests siguen la misma estructura de directorios.

La dodificación sigue los PSR marcados.

El proyecto usa git-flow, el cual contiene las siguientes ramas:

- main 
- develop
- feature/XXX (donde cada feature tiene su propia rama segun su contexto)

Las peticiones HTTP al API original se han realizado usando la libreria de Guzzle.