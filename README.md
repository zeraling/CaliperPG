# CALIPER

El sistema para la generación integral de certificados de calibración a equipos médicos, es un sistema desarrollado para **CR EQUIPOS SA** el cual permite generar certificados de calibración en formato de **PDF**, a partir de los resultados obtenidos en las diferentes pruebas realizadas a dispositivos de uso médico en el proceso de calibración. Optimizando la entrega del informe al cliente y manteniendo un registro del proceso realizado.

## ASPECTOS TÉCNICOS

| Lenguaje de Desarrollo | PHP + JQuery + HTML5|
|--|--|
| Servidor de Desarrollo  | PHP en Windows (IIS)|
| Arquitectura Lógica| MVC |
| Arquitectura Física  | Cliente Servidor 3 Niveles |
|  Base de datos|  PostgreSQL + MongoDB |
  

> Templete Base  **Twitter bootstrap 3 admin template** [http://ace.jeka.by](http://ace.jeka.by/) 

# DETALLES DEL DESARROLLO

A continuación se describen los aspectos que se han cambiado en el desarrollo del sistema con respecto a su versión original, la cual tiene una estructura algo complicada que dificulta la ampliación de funciones y el soporte general de la aplicación.

 - El sistema esta disponible para tres empresas por lo tanto sus funciones se comparten entre estas y pero sus datos se almacenan en bases de datos distintas igualmente almacenadas en **SQL Server**


## Implementacion de Composer 

Por medio del Componer que es el manejador de dependencias y paquetes de PHP, se implementa el estándar [**PSR-4: Autoloader**](https://www.php-fig.org/psr/psr-4/) para la auto carga de las clases propias generadas en la aplicación y los paquetes de terceros que complementan la implementacion del sistema.

 1. [Phroute](https://packagist.org/packages/phroute/phroute) : Enrutador para la carga de de vistas de la aplicación 
 2. [Twig](https://packagist.org/packages/twig/twig): Motor de plantillas flexible, rápido y seguro para PHP
 3.  [Twig Extensions](https://packagist.org/packages/twig/extensions):  Características adicionales comunes para Twig que no estan disponibles en el paquete principal
 4. [Monolog](https://packagist.org/packages/monolog/monolog): Esta biblioteca implementa la interfaz PSR-3: Logger Interface para generar archivos log de la aplicación
 5. [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet): Liberia que permiten leer y escribir en diferentes formatos de archivo de hoja de cálculo como Excel.
 6. [Html2Pdf](https://github.com/spipu/html2pdf):  Permite la conversión de HTML en formato PDF, para generar los informes, Utiliza TCPDF para la parte generación del PDF.
 7. [MongoDB](https://github.com/mongodb/mongo-php-library):  Esta biblioteca proporciona una abstracción de alto nivel en torno al [controlador PHP para MongoDB](https://github.com/mongodb/mongo-php-driver) 

## Reestructuracion de capa de datos

Este desarrollo es una mejora a la versión original soportada bajo Microsoft SQL Server, en donde se decide reestructurar la aplicación a nivel de datos para permitir el almacenamiento compartido por empresas en una sola base de datos, esa reestructura se implementa sobre **PostgreSQL**.

## Apoyo de una segunda base de datos

Por otro lado el sistema se apoya en una base de datos en **MongoDB** para el almacenamiento de la información de las calibraciones y las pruebas que se le realizan a los equipos, aplicando los siguientes aspectos:

 - Debido a que las pruebas que se les realizan a los equipos son muy variables, tener esta informacion en tablas separadas en una base de datos relacional trae sus inconvenientes al momento de consultar y consolidar la informacion de cada informe y almacenar los datos de las pruebas en un campo de texto en formato **JSON** no es una opción ya que se pretende almacenar los gráficos de cada prueba para evitar realizar el render de estos cada ver que se consulte un informe

## Estado Actual

> En desarrollo :)
