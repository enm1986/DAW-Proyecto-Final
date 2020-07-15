# Administrador de comunidades

Proyecto final de CFGS de Desarrollo de aplicaciones web.

Para la implementación de esta aplicación se han utilizado las siguientes tecnologías:
- Framework PHP [Laravel 7](https://laravel.com/): para el desarrollo de la API Restful y diseño de vistas.
- Framework Javascript [Vue.js](https://vuejs.org/): para la implementación del cliente.
- Framework CSS [Bootstrap 4](https://getbootstrap.com/): para diseño web.
- Base de datos relacional [PostgreSQL](https://www.postgresql.org/).

## Descripción

Se ha desarrollado una aplicación para llevar a cabo la administración de comunidades de propietarios.

Se ha diseñado esta aplicación para que los administradores puedan llevar la gestión de las comunidades de manera simple y los propietarios puedan acceder a su información y poder ver el estado de las cuentas de las comunidades a las que pertenecen de manera que la administración se lleve de forma totalmente transparente para los propietarios.

## Análisis

Para esta aplicación se ha desarrollado:
- Una API que proporcionará los datos que mostrará un cliente web.
- Web con la que se accederá a la aplicación.
- Base de datos donde se almacenará la información de la aplicación.
- Un servidor remoto donde se desplegará la aplicación.

La API desarrollada con el Framework Laravel consta de:
- Migraciones para crear las tablas de la base de datos.
- Seeder para poblar la base de datos y poder hacer pruebas.
- Controladores que implementan las funciones que gestionarán las peticiones.
- Rutas con las que poder interactuar con la aplicación.

Además con Laravel también se han implementado:
- Sistema de login.
- Vistas de usuario usando componentes en Vue.
## Remoto:

[Administrador de comunidades](http://enavarro.sytes.net)

## Usuario de prueba

user: admin@com1.com
pass: admin

