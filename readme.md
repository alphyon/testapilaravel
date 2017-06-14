# para poder cargar el proyecto
para poder cargar el proyecto en los entornos primero hay que crear una base de datos
con la base de datos creada
ejecutar desde la consola los comandos 

```
php artisan migrate
```

al ejecutar sin errores el comando ejeuctar el siguiente

```
php artisan db:seed
```
con esto se cargan los datos de prueba

ya con dichos datos cargados hacemos las pruebas 

accediendo a la url de acuerdo a nuestro entorno ejemplo 

http://localhost/users  --- esto carga el enpoint con todos los datos del usuario



