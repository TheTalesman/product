# Product Crud
This is a work challenge for a job at Flexy made with Symphony 5.1. The Project consists of a basic Crud application of products containing tags and images associated.

## Requirements
Docker

## Tech
Symphony 5.1, Twig, Docker, PHP 7.4 or greater, Composer, MySQL.


## TODO
- [X] DOCKERIZE 
- [ ] FINISH THIS README
- [ ] IMPLEMENT FRONT LAYOUT WITH UX UPGRADE
- [ ] REFACTOR TO CLEAN CODE
- [X] CREATE FIXTURE FOR INITIAL IMPORT
- [X] CREATE MIGRATIONS AND SCRIPT FOR INSTALATION
- [ ] BUGFIX IMAGE VALIDATION

## Instalation
To install this aplication, run docker/install.cmd. If you are running this from a Unix OS, run this command in a terminal 
```
chmod a+x ./myscript.cmd 
```

### Windows
Go to your hosts file (c:/windows/system32/hosts in windows) edit as an administrator, and add this line in the end of the file:
```
127.0.0.1 product.local
```

### Linux/Mac OS
```
$ sudo echo $(docker network inspect bridge | grep Gateway | grep -o -E '([0-9]{1,3}\.){3}[0-9]{1,3}') "product.local" >> /etc/hosts
```

### DONE!
Run http://product.local in your browser!

## Usage
    Product Crud :  http://product.local 
    Logs (Kibana): http://product.local:81
    Logs (files location): logs/nginx and logs/symfony
