# symfony-blog
Simple blog built with symfony ( work in progress )

## Getting started

( using symfony binary )  

**- install dependencies**
```
symfony composer install
```  

**- create user "symfony"
 with password "password"
 with all privileges on "blog"**
```
sudo mysql
mysql>CREATE USER 'symfony'@'localhost' IDENTIFIED BY 'password';
mysql>GRANT ALL PRIVILEGES ON blog.* TO 'symfony'@'localhost';
mysql>FLUSH PRIVILEGES;
```  

**- create database, tables & fake data**
- configure .env file line "DATABASE_URL" line with user="symfony" password="password" and database="blog"
- then type in CLI :
```
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load
```  
