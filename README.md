# Laramotely

## Files Locations

routes/web contails all project related routes
app/http/controllers contain all project related controllers
app/repositories/jobsrepository.php contains all database related functions
app/services contains all project related business logic classes

database/seeders and database/factories contains job factory and seeder

resources/css contains any global css styles
resources/js contains any vue components

## Project Setup/ Docker

1. Step 1 - Setup repository
   git init
   git remote add origin ...
   git pull origin master

2. Step 2 - Setup docker containers
   sudo rm -r docker/mysql && sudo mkdir docker/mysql && sudo chmod 775 docker/mysql
   docker compose up nginx --build

#Use this ip to connect to your database using MySQL Workbench, or get them from the yaml file if using static ips
docker inspect db | grep IPAddress

#Use this ip to map your domain in etc/hosts, or get them from the yaml file if using static ips
docker inspect nginx | grep IPAddress

3. Step 3 - Install composer dependancies
   docker compose run --rm composer install

4. Step 4 - Instal npm dependancies
   docker compose run --rm npm install

5. Step 5 - Run artisan commands
   #add correct values to db connection in .env
   docker compose run --rm artisan optimize

6. Fix file permissions
   sudo chmod -R o+w storage/ bootstrap/

#Use docker ps to list your containers
docker ps

#Use docker compose ps to list your services
docker compose ps

#Use exec to connect to your container and run commands
docker exec -it <container_id> bash

#Stop mysql in local Ubuntu in order to be able to use port
sudo service mysql stop
