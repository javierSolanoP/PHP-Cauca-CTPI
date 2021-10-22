# API DE LA APP 'HEALTH' 

## CONFIGURACIÓN: 

Al momento de clonar el repositorio, deberá realizar las siguientes configuraciones para el correcto funcionamiento del servicio: 

El servicio requiere de las dependencias del framework, 
por defecto, estas dependecias no se suben al repositorio remoto directamente. Deberá requerirlas con el siguiente comando, este comando es del gestor de dependencias 'composer', por lo tanto, asegurese de tenerlo instalado localmente, debe ejecutarse en el siguiente path: 'PHP-Cauca-CTPI\backend': 

´´´ 
composer install
´´´

Para poder hacer uso de la base de datos, cree la base de datos en su gestor de bases de datos local (MySQL), el nombre de la base de datos la puede encontrar en las variables de entorno del archivo '.env': 

´´´
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=health
DB_USERNAME=root
DB_PASSWORD=
´´´

Por ultimo, debe migrar las entidades que requiere la base de datos con el siguiente comando: 

´´´
php artisan migrate
´´´

## USAR EL SMTP DE MAILER

Para poder hacer uso del servicio de emails, deberá tener la siguiente configuracion en las variables de entorno del archivo '.env': 

´´´
MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=fedesoft_health@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
´´´

