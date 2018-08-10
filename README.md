# CALIPER

El sistema para la generación integral de certificados de calibración a equipos médicos, es un sistema desarrollado para **CR EQUIPOS SA** el cual permite generar certificados de calibración en formato de **PDF**, a partir de los resultados obtenidos en las diferentes pruebas realizadas a dispositivos de uso médico en el proceso de calibración. Optimizando la entrega del informe al cliente y manteniendo un registro del proceso realizado.

## ASPECTOS TÉCNICOS

  * Leguage de Desarrollo: PHP
  * Servidor de Desarrollo: PHP en Windows (IIS)
  * Arquitectura Lógica:	MVC
  * Arquitectura Física: Cliente Servidor 3 Niveles
  * Base de datos: PostgreSQL + MongoDB
  
## DESCRIPCIÓN DEL DESARROLLO

Este desarrollo es una mejora a la versión original soportada bajo Microsoft SQL Server, en donde se decide reestructurar la aplicación a nivel de datos para permitir el almacenamiento compartido por empresas en una sola base de datos, esa reestructura se implementa sobre **PostgreSQL**.

Por otro lado el sistema se apoya en una base de datos en **MongoDB** para el almacenamiento de la información de las calibraciones y las pruebas que se le realizan a los equipos, aplicando los siguientes aspectos:

 - Debido a que las pruebas que se les realizan a los equipos son muy variables, tener esta informacion en tablas separadas en una base de datos relacional trae sus inconvenientes al momento de consultar y consolidar la informacion de cada informe y almacenar los datos de las pruebas en un campo de texto en formato **JSON** no es una opción ya que se pretende almacenar los gráficos de cada prueba para evitar realizar el render de estos cada ver que se consulte un informe
