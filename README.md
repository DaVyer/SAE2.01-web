# SAE2-01 : Developpement d'application web

## Auteur du projet

    - GOMES Raphael Gome0052
    - RODRIGUES Gwendal Rodr0089

## Présentation du projet :
Ce projet consiste en la création d'une application web équivalente au TP "CRUD Music" transposé à la base de donnée
fournie.

#### WebPage.php et AppWebPage.php:

Ces deux classes constituent l'ossature en html du futur site web.

#### Serveur Web Local:

Afin de lancer le serveur web en local, il suffit d'ouvrir un terminal, de se placer dans le dossier du projet,
ici `sae2-01` et enfin de faire la commande `php -d display_errors -S localhost:8000 -t public/`.

Afin de lancer le serveur sur windows, il suffit de taper la requête suivante dans l'invite de commande de l'éditeur:

- `composer start:windows --timeout=0`

Et pour linux:

- `composer start:linux --timeout=0`

#### CS-FIXER

Afin de styliser le code, on peut éxecuter la requête suivante :

- `composer run-script test:cs`

Cette requête run la commande `php vendor/bin/php-cs-fixer fix --dry-run` qui permet de faire un "test à blanc", qui pointera les problèmes sans pour autant les modifier. 

Qui permet de visualiser les modifications dans les fichiers

- `composer run-script fix:cs`

Cette requête run la commande `php vendor/bin/php-cs-fixer fix` qui permet de modifier les problèmes de styles rencontrés. 