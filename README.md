# Administrador de comunidades

Eugenio Navarro Mas (enavarro@cifpfbmoll.eu).   
Proyecto final de CFGS de Desarrollo de aplicaciones web.   
CIFP Francesc de Borja Moll.

- [Descripción](#descripcion)
- [Desarrollo](#desarrollo)
- [Despliegue](#despliegue)

---

## Descripción

Se ha desarrollado una aplicación para llevar a cabo la administración de comunidades de propietarios.

Se ha diseñado esta aplicación para que los administradores puedan llevar la gestión de las comunidades de manera simple y los propietarios puedan acceder a su información y poder ver el estado de las cuentas de las comunidades a las que pertenecen de manera que la administración se lleve de forma totalmente transparente para los propietarios.

Para la implementación de esta aplicación se han utilizado las siguientes tecnologías:
- Framework PHP [Laravel 7](https://laravel.com/): para el desarrollo de la API Restful y diseño de vistas.
- Framework Javascript [Vue.js](https://vuejs.org/): para la implementación del cliente.
- Framework CSS [Bootstrap 4](https://getbootstrap.com/): para diseño web.
- Base de datos relacional [PostgreSQL](https://www.postgresql.org/).

---

## Desarrollo

Para esta aplicación se ha desarrollado:
- Una API que proporcionará los datos que mostrará un cliente web.
- Web con la que se accederá a la aplicación.
- Base de datos donde se almacenará la información de la aplicación.
- Un servidor remoto donde se desplegará la aplicación.

La aplicación desarrollada con el Framework Laravel consta de:
- Migraciones ([*database/migrations*](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/database/migrations)) 
- Seeder ([*database/seeds*](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/database/seeds))
- API Restful
    - Controladores ([*app/controllers/API*](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/app/Http/Controllers/API))
    - Rutas ([*routes*](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/routes))
- Sistema de login que diferencia usuarios básicos de administradores.
- Plantillas, vistas ([*resources/views*](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/resources/views)) y componentes Vue ([*resources/js/components*](https://github.com/enm1986/DAW-Proyecto-Final/tree/master/resources/js/components)).


### Migraciones

Usadas para crear las tablas de la base de datos.   

### Seeders
Usados para poblar automáticamente la base de datos con datos aleatorios y poder hacer pruebas.   
Se han poblado algunas tablas como las de *Comunidades*, *Propietarios*, *Propiedades*, *Propiedades_Propietarios*, *Proveedores*, *Fondos* y *Cuentas*.

### Controladores
Donde se agrupan los métodos que gestionan la lógica tras las peticiones a la API.   
Prácticamente se ha implementado un controlador para cada tabla.   
Los métodos que se han implementado en ellos consisten en *querys* a la base de datos.   
La mayoría de *querys* han sido construidas con el *Query Builder* de manera que si se cambia de DBMS no será necesario rehacer las *querys*.   
Alguna *query* más complicada ha sido construida de forma pura (*Raw SQL Queries*). ([Ejemplo](https://github.com/enm1986/DAW-Proyecto-Final/blob/9be8bc494dbbe3a8f994cb4b9d20fc57c1b610c2/app/Http/Controllers/API/ContCuentasController.php#L12))

### Rutas
Tanto para la interfaz web como para la API.   
Con ellas se podrá interactuar con la aplicación.   
Las peticiones a la API apuntan a las rutas de API, y estas a su vez apuntan a los métodos implementados en los controladores.   
También se ha implementado un *middleware* que actua sobre varias rutas de la API para restingir el acceso a usuarios que no sean administradores de las comunidades.   
 
### Plantillas, vistas y componentes Vue
Se han diseñado varias plantillas que comparten varias vistas implementado componentes Vue usados en distintas vistas.   
Las plantillas y vistas se han diseñado con el sistema *Blade* de Laravel y *Bootstrap* para el CSS.   
Los componentes Vue visualizan elementos reactivos y se encargan de realizar las peticiones a la API.   
Se ha usado el cliente HTTP [axios](https://github.com/axios/axios) para realizar las peticiones a la API.   

---

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

user: usuario@com1.com   
pass: usuario   


