# kawaii-checking-website
Application auto hebergé pour verifier l'accécibilité d'un site internet et sa configuration public fait avec Symfony3 et des Kawaii Potato. 

## Français

### Dépendances 

- Symfony 3.4 Standard Edition
- Taches planifiées
    - serveur dédié/vps pour utiliser Cron
    - Hebergeur avec systeme de planification de tache.
- cURL ou cURLPHP
- PHP 7.0 (5.6 peut fonctionner mais pas de support prévus de ma part)
- Apache ou Nginx (serveur php de Symfony en dev certainement fonctionnel)
- MSQL ou autre compatible Doctrine

### Bundles Symfony / Dépendances utilisé

- KnpSnappy https://packagist.org/packages/knplabs/knp-snappy-bundle
- easyadmin-bundle https://packagist.org/packages/javiereguiluz/easyadmin-bundle

### Vues
#### Public

- Voir une liste des sites administré si en ligne, sinon possibiliter de voir l'état de la maintenance.
- S'inscrire afin de recevoir une notification par mail ou notif navigateur si une sélection de site est tombé.

#### Admin
LAMS = Lister Ajouter Modifier Supprimer 
- LAMS sites
    - plusieurs niveau d'importance (influs sur la régularité des ping et cron)
        - Temps reel
        - Normal
        - Faible
        - Journalier
        - Manuel
    - Vérification de l'accécibilité du site
        - Ping
        - Codes d'erreur via curl
        - DNS propagation
            - serveur personalisable

    - Scan simple :
        - présence de rêgles de sécurité et optimisation basique
            - deflate
            - gzip
            - Accept-Encoding: gzip, compress, br
            - server Version
            - strict-transport-security
            - x-content-type-options	
            - Spdy	
            - x-frame-options	
            - x-ua-compatible	
            - x-xss-protection	
            - content-security-policy	
            - content-type	

        - verification simple du ssl
            - avancé avec https://tls.imirhil.fr/https/monsite.fr.json
    - Scan avancé 
        - Autorisation du scan à distance avancée par l'installation de deux fichiers à la raçine du site
            - Un ficher txt avec un token qui devra être validé
            - Un fichier php qui permetra :
                - DL le Htaccess pour analyse
        

- LAMS des utilisateurs
    - 3 groupes :
        - Utilisateurs
        - Gestionnaires
        - Administrateurs
        - Dieu suprème (Compte unique)

### Changements

## English

PHP WebApp for checking website availability &amp; standard configuration. Build with symfony &amp; Kawaii Potato.