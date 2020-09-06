# Product Crud
This is a work challenge for a job at Flexy made with Symphony 5.1. The Project consists of a basic Crud application of products containing tags and images associated.

## Requirements
Docker

## Tech
Symphony 5.1, Twig, Docker, PHP 7.4 or greater, Composer, MySQL, ELK Stack.


## TODO
- [X] DOCKERIZE 
- [ ] FINISH THIS README
- [ ] IMPLEMENT FRONT LAYOUT WITH UX UPGRADE
- [ ] REFACTOR TO CLEAN CODE
- [X] CREATE FIXTURE FOR INITIAL IMPORT
- [X] CREATE MIGRATIONS AND SCRIPT FOR INSTALATION
- [ ] BUGFIX IMAGE VALIDATION

## Instalation
* Make sure you have docker and docker-compose installed.

### Windows
To install this aplication, run docker/install.cmd.
Then go to your hosts file (c:/windows/system32/drivers/etc/hosts in windows) edit as an administrator, and add this line in the end of the file:
```
127.0.0.1 product.local
```

### Linux/Mac OS
 If you are running this from a Unix OS, run this commands in a terminal, in /product/docker/
```
sudo service docker start
chmod a+x install.cmd 
./install.cmd 
# Run this command if you are running the application from your own machine to make ir serve in dns product.local
sudo echo $(docker network inspect bridge | grep Gateway | grep -o -E '([0-9]{1,3}\.){3}[0-9]{1,3}') "product.local" >> /etc/hosts
```

#### Error
```
ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?

If it's at a non-standard location, specify the URL with the DOCKER_HOST environment variable.
```
If you get this error while running ./install.cmd, try running with sudo:
```
sudo ./install.cmd
```

### DONE!
Run http://product.local in your browser!

If you need to turn off docker containers:
```
docker-compose down
```
To turn it on again:
```
docker-compose up -d
```
## Usage
    Product Crud :  http://product.local 
    Logs (Kibana): http://product.local:81
    Logs (files location): logs/nginx and logs/symfony
