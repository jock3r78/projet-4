projet-3 
=======

OpenClassrooms Blog Ecrivain 
===============================

Installation
---------
```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:run
```

