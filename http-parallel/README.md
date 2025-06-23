# Exemple de requêtes paginées parallélisées avec Symfony HTTP Client, des Generators et FrankenPHP

Je cherchais depuis un petit moment un moyen efficace de consommer une API paginée en PHP.
Avec cet exemple, tu vas apprendre facilement à paralléliser massivement des requêtes HTTP sur une API paginée pour un résultat ultra rapide,
avec un minimum d'adhérence entre le client et le serveur.

On va donc faire **simple et performant** en utilisant une fonctionnalité peu utilisée de PHP depuis la version 5.5 (2013!).


Pour cela on va utiliser:
- frankenphp+symfony pour le serveur
- un Generator bidirectionnel pour le client

Pour ceux qui trouvent Symfony compliqué, j'ai juste crée 1 fichier après avoir crée le projet !

## Utilisation

### Prérequis

- docker
- make
- composer

### Initialisation

```bash
make build
```

### Exécution

dans 2 terminaux différents:

```bash
make run-server
make run-client
```

## Explications

### client

#### Consommation naïve de l'API


- utilisation de la fonctionnalité des requêtes concurrentes du [client HTTP Symfony](https://symfony.com/doc/current/http_client.html#concurrent-requests)
- le client effectue une première requête et récupère la taille de l'intervalle par défaut renvoyé
- pour cela le Generator récupère le résultat de la requête qu'il a lui même propagée
- pour les requêtes suivantes on parallélise en utilisant l'intervalle déduit, par lot de 100
- le Builder recrée un iterable à partir des ResponseInterface renvoyées par le Generator. Il s'arrête lorsque l'API est hors limite (code HTTP 416)
- le Builder masque l'utilisation d'un Generator à l'appelant (client.php). 
- pas de système de pagination compliqué avec des calculs de page: on consomme tant qu'il y a des résultats avec un garde-fou
- le client n'a pas connaissance de la parallélisation ni de la taille des lots côtés client ou serveur

### Serveur

- se contente de renvoyer des résultats dans un intervalle donné, par lot de 7 résultats
- simule une requête de durée 100 ms

## Résultats

Le client va consommer l'API de la manière suivante:

- **nombre d'éléments retournés à chaque requête** 7
- **nombre de requêtes éxecutées** 144
- **temps d'exécution total des requêtes** 2714 ms

Vous pouvez modifier la taille de l'intervalle en ajustant la variable d'environnement dans le Makefile.


On observe que tous les résultats renvoyés par le serveur dans un même batch ont la même date, elles sont donc bien parallélisées.
Avec une fenêtre de 1 on cumule tous les temps serveurs, on arrive donc à 14,4 secondes d'exécution.

La parallélisation permet donc de diviser par 7 le temps d'éxécution.

## Test de charge avec Artillery

A venir ;-)

## Références

https://markbakeruk.net/2016/10/08/php-generators-sending-gotchas/
https://www.php.net/manual/en/generator.send.php
https://symfony.com/doc/current/http_client.html#concurrent-requests