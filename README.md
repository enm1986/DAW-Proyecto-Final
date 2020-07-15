# Administrador de comunidades

Eugenio Navarro Mas (enavarro@cifpfbmoll.eu).   
Proyecto final de CFGS de Desarrollo de aplicaciones web.   
CIFP Francesc de Borja Moll.   

---

## Descripción

Se ha desarrollado una aplicación para llevar a cabo la administración de comunidades de propietarios.

Se ha diseñado esta aplicación para que los administradores puedan llevar la gestión de las comunidades de manera simple y los propietarios puedan acceder a su información y poder ver el estado de las cuentas de las comunidades a las que pertenecen de manera que la administración se lleve de forma totalmente transparente para los propietarios.

Para la implementación de esta aplicación se han utilizado las siguientes tecnologías:
- Framework PHP [Laravel 7](https://laravel.com/): para el desarrollo de la API Restful y diseño de vistas.
- Framework Javascript [Vue.js](https://vuejs.org/): para la implementación del cliente.
- Framework CSS [Bootstrap 4](https://getbootstrap.com/): para diseño web.
- Base de datos relacional [PostgreSQL](https://www.postgresql.org/).


## Desarrollo

Para esta aplicación se ha desarrollado:
- Una API que proporcionará los datos que mostrará un cliente web.
- Web con la que se accederá a la aplicación.
- Base de datos donde se almacenará la información de la aplicación.
- Un servidor remoto donde se desplegará la aplicación.

La aplicación desarrollada con el Framework Laravel consta de:
- [Migraciones](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/database/migrations) 
- [Seeder](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/database/seeds)
- API Restful
    - [Controladores](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/app/Http/Controllers/API)
    - [Rutas](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/routes)
- Sistema de login que diferencia usuarios básicos de administradores.
- Plantillas, [vistas](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/resources/views) y [componentes Vue](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/resources/js).


### Migraciones

Usadas para crear las tablas de la base de datos.

### Seeders
Usados poblar automáticamente la base de datos y poder hacer pruebas.   
Se han poblado algunas tablas con datos medianamente realistas.

### Controladores
que implementan las funciones que gestionarán las peticiones. Prácticamente se ha implementado un controlador para cada tabla.

### Rutas
con las que poder interactuar con la aplicación. Las peticiones a la API apuntan a estas rutas, y estas a su vez apuntan a los métodos implementados en los controladores.

### Plantillas, vistas y componentes Vue
visualizan elementos reactivos y realizan las peticiones a la API.


## Despliegue:

#### Site remoto

*Hostname* de [No-IP](https://www.noip.com/):
- http://enavarro.sytes.net

VPS en [Amazon](https://aws.amazon.com/es/): 
- ubuntu 18.04
- Apache 2.4
- PHP 7.4
- PostgreSQL 12 

#### Usuarios de prueba

user: admin@com1.com   
pass: admin   

user: usuaruo@com1.com   
pass: usuario   


