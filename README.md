<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/djhrcode/alegra/main/public/img/github-cover-image.png?token=ALGL4UKZ3QLZ63NGM7U6253BMHIVW"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Reto "Vendededores a Correr" para Frontend Developer en Alegra 

Esta aplicación ha sido construida como parte de un reto técnico para ser Frontend Developer en Alegra. En este documento se dan detalles de como funciona y fue construido el proyecto, y las cosas necesarias para que el proyecto funcione.



(#general-introduction)

### Introducción general

El proyecto está construido con las siguientes tecnologías de acuerdo al entorno. **Ambos entornos están totalmente desacoplados**, a pesar de que se encuentran en el mismo repositorio para objetivos de esta prueba.  Así que podrían estar perfectamente en repositorios o incluso servidores diferentes y funcionar sin ningún problema.  

La aplicación se ha desarrollado usando Vue.js y Laravel, además previamente al proyecto se ha diseñado una pequeña **[Guia de estilo y parte de la Interfaz en Figma.](https://www.figma.com/file/kb3IsXhg60S7zDF4dBpcw1/Prueba-Técnica-Alegra-Vendedores-a-Correr?node-id=0%3A1)**  Esto se ha hecho con el objetivo de tener claro desde el inicio un diseño y un estilo uniforme y así brindar la mejor experiencia de usuario posible.

Además también se realizó la integración con la **API de Alegra** para crear las facturas y crear los vendedores y la **API de Unsplash** para obtener las imágenes a partir de un criterio de busqueda.

Aunque la aplicación se puede clonar para funcionar en local, está publicada y funcionando en producción en la siguiente url **https://worldwide-images.herokuapp.com**



(#frontend-tools)

### Tecnologías usadas en el front-end 

* **[Vite.js:](https://vitejs.dev/)** es un compiler y bundler para desarrollar proyectos de frontend y es un reemplazo de Webpack o Laravel Mix. Vite.js ofrece un desarrollo más rápido y sencillo.
* **Vue.js:** como framework principal de frontend para manejo de componentes. Este proyecto está construido usando la versión 3 de Vue y aplicando algunos de los conceptos ofrecidos por esta nueva versión, como la Composition API.
* **Vuex:** para implementar manejo de estado global siguiendo la arquitectura Flux.
* **VueRouter:** para implementar enrutamiento, navegación, guards y layouts en Vue.js.
* **Ky**: una librería de consultas HTTP (reemplazo de Axios) siendo esta mucho más escalable, fácil de reutilizar, extender y muchisimo más ligera.
* **Bulma:** como framework de CSS que nos ofrece utilidades, fácil customización y un set de estilos para componentes básicos.
* **SASS**: como preprocesador de CSS para crear, modularizar y reutilizar estilos.
* **Jest & Testing Library**: para implementar test unitarios a los componentes de Vue así como parte de la lógica del código.  
* **PostCSS & PurgeCSS**: para implementar la utilidad de PurgeCSS y así eliminar los selectores CSS no utilizados de las hojas de estilos al compilar a producción.



(#backend-tools)

### Tecnologías usadas en el back-end

* **Laravel**: como framework principal de desarrollo de la aplicación en general. Este proyecto fue construido usando PHP 8 y Laravel 8. Para efectos de esta prueba Laravel se ha utilizado como una API RESTful, lo que significa que la autenticación y la comunicación cliente-servidor es totalmente stateless. Entre las funcionalidades implementadas de Laravel podemos mencionar:
  * Dependency Injection con ServiceProviders
  * Application Routing
  * Application Middlewares
  * Database Seeders
  * Database Migrations
  * Application Controllers
  * Database Eloquent Models
  * Database Factories (Class-based por Laravel 8)
  * Application FormRequests (Validations)
  * Application Events & Listeners
* **Laravel Sanctum**: una nueva utilidad ofrecida por Laravel para simplicar el manejo de autenticación en SPAs y que ofrece manejo de personal access tokens.
* **Laravel Vite:** es una libreria que permite implementar los archivos compilados de ViteJS de forma más sencilla en las vistas de Laravel. 
* **The PHP League Fractal:** es una librería que permite un manejo más completo y escalable de JSON resources en APIs, que el que nos ofrece la utilidad de Resources que viene built-in en Laravel. 



​	(#run-project)

 ### ¿Cómo ejecutar el proyecto localmente?

 A continuación destaco las instrucciones y pasos a seguir en caso de necesitar correr el proyecto en un entorno local. 



1. Crear archivo **.env** y definir las siguientes variables:

       # Token generado para consultar API de Alegra
       ALEGRA_CLIENT_SECRET="{{ALEGRA_BASE64_TOKEN}}"
       
       # Número de Vendedores a crear en Alegra
       ALEGRA_SELLERS_TO_SEED=20
       
       # Token entregado por la  API de Unsplash
       UNSPLASH_CLIENT_SECRET="{{UNSPLASH_CLIENT_SECRET}}"
       
       # Variables de la aplicación de Laravel
       APP_DEBUG=false
       APP_ENV=local
       APP_KEY="{{LARAVEL_ENCRYPTION_KEY}}"
       APP_NAME="Worldwide Images"
       APP_URL="{{LOCAL_APP_URL}}"
       ASSET_URL="{{LOCAL_APP_URL}}"
       
       # Url del API de Laravel que usa
       # el código de Vue.js
       VITE_WORLWIDE_API_URL="{{LOCAL_APP_URL}}/api/v1/"
       
       # Por defecto el proyecto está configurado 
       # para funcionar con REDIS
       CACHE_DRIVER="array"
       
       # Toda la información para realizar conexión
       # a la base de datos con Laravel
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=worlwide_images
       DB_USERNAME=root
       DB_PASSWORD="{{YOUR_DATABASE_PASSWORD}}"

2. Instalar las dependencias corriendo  `composer install` y luego  `npm install` 

3. Correr las migraciones y los seeders con  `php artisan migrate --seed`. Este comando  creara las tablas en nuestra base de datos y adicionalmente generar los datos iniciales que necesita la aplicación para funcionar.

4. Compilar la aplicación usando `npm run dev` si desea compilar para modo de desarrollo o  `npm run build` si quiere compilar para producción. 



(#project-structure)

 ### ¿Cómo está organizado el proyecto?

La carpeta raiz del repositorio contiene la estructura común de un repositorio de Laravel sin embargo hay algunas excepciones y particularidades que podemos mencionar:

* En la carpeta `/resources/js` esta todo el código fuente del front-end. Aunque se han implementado tests unitario usando Jest y Testing Library, solo se han aplicado tests unitarios a los componentes elementales, aunque caba destacar esto no sería lo ideal para una aplicación en producción. Dentro de esta carpeta encontraremos:

  * El archivo `main.js` que es el archivo raíz de la aplicación de Vue.js

  * La carpeta `assets/` donde están algunos archivos como iconos o imagenes.

  * La carpeta `components/` donde están los componentes más reutilizables. Entre esos componentes tenemos 1) `components/elements/` que son elementos básicos más reutilizables como Input y Button y  2)  `components/sections/` que son componentes que representan secciones más específicas de la interfaz que pueden tambien estar relacionados a los modelos de datos, por ejemplo: SellerImageCard y SearchInput.

  * La carpeta `helpers/` donde se incluyen algunas funciones que simplifican y abstraen el uso de algunas librerias como Vuex y Ky.

  * La carpeta `pages/` contiene los componentes que representan directamente una ruta definida con el VueRouter en el archivo `plugins/router.js`.

  * La carpeta `layouts/` además de layouts reusables contiene el component `_handler.vue` que es un componente para simplificar el manejo de layouts en Vue.js. 

  * La carpeta `styles/` contiene la hoja de estilos principal la cual se está desarrollando usando SASS y donde se importan los módulos de Bulma.

  *  La carpeta `router/` contiene archivos helpers que simplifican la interacción con la navegación así como el manejo de navigation guards en Vue.js.

  * La carpeta `http/` contiene los archivos relacionados a la implementación de las consultas HTTP usando Ky como los hooks de ky, las error classes, entre otros.

  * La carpeta `models/` contiene directamente la definicion de los principales modelos de datos con los que trabaja el repositorio. Entre ellos tales como: Authentication, Contest, Seller y Notification.

    

* La carpeta `/app` de Laravel no sigue la estructura  por defecto que trae Laravel, donde todo se organiza por Modelos, Controladores, Policies, Requests, etc. Al contrario en este proyecto implementé el esquema de diseño de software DDD (Domain Driven Design). Este esquema consiste en aplicar una serie de patrones de diseños y principios con el objetivo de que el código refleje un entendimiento de la lógica del negocio y los requerimientos del mismo, siendo además prioridad la alta escalabilidad y respuesta al cambio del código. Por esta razón, en la carpeta  `/app` están las siguientes carpetas: `/Contest`, `/Invoice`, `/Seller`, `/Setting`, `/Images`, `/User`, `/Vote`, `/Shared`. Cada una de estas carpetas tendrá dentro las siguiente estructura.

  ```
  ├───Contest
  │   ├───Application
  │   ├───Domain
  │   └───Infrastructure
  ├───Images
  │   ├───Application
  │   ├───Domain
  │   └───Infrastructure
  ├───Shared
  │   ├───Application
  │   ├───Domain
  │   └───Infrastructure
  ```

  Siguiendo esta estructura cada carpeta contiene lo siguiente:

  * **Application:** representa la capa de la aplicación donde se definen entidades como Controladores, Requests, Providers, Events, Listeners de Laravel y la implementación de Json Resources usando Fractal. Esta capa viene en cierta forma, siendo un punto medio entre la capa de **Dominio** y la capa de **Infrastructure**. La capa de Application puede depender en las otras capas.
  * **Domain**: la capa de dominio contiene todas las entidades que representan y reflejan directamente las entidades de la lógica del negocio y además también sirven para generar abstracciones de algunas entidades como los repositories. La capa de dominio no debe depender en las capas de Infrastructure o Application
  * **Infrastructure**: la capa de infraestructura representan la implementación de todas aquellas entidades que representan un recurso muy concreto. Ejemplo: las clases que hacen consultas a la base de datos usando el ORM de Eloquent, o la implementación de un recurso de una API como las APIs de Unsplash y Alegra. La capa de Infrastructure no debe depender en la capa de Application.

  Entendiendo ya esta estructura, la carpeta del dominio Seller, que tiene una integración con una API y el eloquent ORM más en profundidad:

  ```
  ├───Seller
  │   ├───Application
  │   │   ├───Controllers
  │   │   │       SellerImagesSearchController.php
  │   │   │       SellerSearchController.php
  │   │   │       SellerShowController.php
  │   │   │       SellerUpvoteController.php
  │   │   │
  │   │   ├───Events
  │   │   │       SellerHasBeenCreated.php
  │   │   │
  │   │   ├───Listeners
  │   │   │       SyncCreatedSellerWithAlegra.php
  │   │   │
  │   │   ├───Providers
  │   │   │       SellerEventServiceProvider.php
  │   │   │       SellerServiceProvider.php
  │   │   │
  │   │   ├───Requests
  │   │   │       SellerImagesSearchRequest.php
  │   │   │
  │   │   └───Resources
  │   │           SellerImageResource.php
  │   │           SellerResource.php
  │   │
  │   ├───Domain
  │   │   │   Seller.php
  │   │   │   SellerCollection.php
  │   │   │   SellerImage.php
  │   │   │   SellerRepository.php
  │   │   │   SellerSearchCriteria.php
  │   │   │
  │   │   └───ValueObjects
  │   │           SellerAlegraId.php
  │   │           SellerAvatar.php
  │   │           SellerId.php
  │   │           SellerName.php
  │   │           SellerPoints.php
  │   │           SellerRemainingPoints.php
  │   │           SellerVotes.php
  │   │           SellerWinningPoints.php
  │   │
  │   └───Infrastructure
  │       ├───Http
  │       │   └───Alegra
  │       │           AlegraSeller.php
  │       │           AlegraSellerRepository.php
  │       │
  │       └───Persistence
  │           └───Eloquent
  │               │   SellerFactory.php
  │               │   SellerModel.php
  │               │   SellerRepository.php
  │               │
  │               ├───Scopes
  │               │       OnlySellerSynced.php
  │               │
  │               └───Traits
  │                       SellerTransformMethods.php
  ```