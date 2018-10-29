fastcgi_pass unix:/run/php/php7.2-fpm.sock;

CREATE DATABASE startuper;
CREATE USER 'startuper'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON startuper.* TO 'startuper'@'localhost';
FLUSH PRIVILEGES;

 mysql -u startuper -p startuper < /var/www/startuper/config/manual/startuper_database2018-10-25.sql
