# Slim City

Application permettant de rechercher (avec tri) les villes de France selon leur départemement, à l'aide notamment de jQuery UI autocomplete et jQuery DataTables.
  
Afin de regénérer la base de données, il suffit d'executer le script dump.sql à la racine du projet (depuis PhpStorm par exemple)

## Un projet orienté best practises et performance :
- Utilisation de PHP7.1
- Documentation REST avec [gulp-apidoc](https://www.npmjs.com/package/gulp-apidoc)
- Concaténation et minification des assets avec [gulp](https://www.npmjs.com/package/gulp)
- Côté javascript : jQuery, ES6, Ajax, et Promises !
- Mise en cache des requêtes SQL avec Redis

## Commandes d'installation :

    composer install
    npm install
    gulp

Puis configurer le fichier .env automatiquement créé. Sinon faire :
    
    >mv .env-example .env

## Servir le dossier "doc" de l'API (exemple avec nginx) :

_/etc/nginx/sites-available/slim-city.conf :_
        
        ...
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
    
        ## APIDOC ##
        location /doc {
            alias "/var/www/slim-city/doc";
            index index.html index.htm;
            try_files $uri $uri/ /index.html;
        }
        ...
    
## Environnement de développement recommandé : 
PhpStorm + Vagrant homestead

