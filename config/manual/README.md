fastcgi_pass unix:/run/php/php7.2-fpm.socket;



CREATE DATABASE randomovies;
CREATE USER 'randomovies'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON randomovies.* TO 'randomovies'@'localhost';
FLUSH PRIVILEGES;

 mysql -u randomovies -p randomovies < /home/orangepi/randomovies_database_prod.sql
 
 ---
 
 Configurer Symfony pour fonctionner avec un unix_socket pour la base de données
