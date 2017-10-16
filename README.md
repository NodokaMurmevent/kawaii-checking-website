# kawaii-checking-website
Application auto hebergé pour verifier l'accécibilité d'un site internet et sa configuration public fait avec Symfony3 et des Kawaii Potato. 

Tout ce qui suis est plus une feuille de route perso pour le futur.

## Français
### Theme 
- Administration https://adminlte.io/themes/AdminLTE/index2.html
- Public
### Vues
#### Public

- Voir une liste des sites administré si en ligne, sinon possibiliter de voir l'état de la maintenance.
- Possibilité de s'inscrire afin de recevoir une notification par mail ou notif navigateur si une sélection de site est tombé.


#### Admin
LAMS = Lister Ajouter Modifier Supprimer 
- LAMS sites
    - plusieurs niveau d'importance (influs sur la régularité des ping et cron)
        - Temps reel
        - Normal
        - Faible
        - Journalier
        - Manuel
    - Vérification de l'accésibilité du site
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
            - voir très avancé avec https://tls.imirhil.fr/https/monsite.fr.json
    - Vérification whois
    - Scan avancé 
        - Autorisation du scan à distance avancée par l'installation de deux fichiers à la raçine du site
            - Check DNS paternité
            - Un ficher txt avec un token qui devra être validé pour assurer de l'identité 
            - Un fichier php avec une partie du nom aléatoire qui permetra :
                - DL le Htaccess pour analyse
                - De faire un PHP Info et de l'analyser

- LAMS des utilisateurs
    - 3 groupes :
        - Utilisateurs / Proprio
        - Gestionnaires
        - Administrateurs
        - Dieu suprème (Compte unique)

### Idées :
Possibilité de se financer :
- Pour les comptes gratuits :
    - Limité à 1 site avec une vérification journalière uniquement aucun acces aux infos simple ou avancé
    - Administrateurs peuvent ajouter de la pub OU miner avec le CPU des utilisateurs de la crypto monnaie (après accord du client pour enlever la pub)
- Comptes payants :
    - OMG Real Time : 1 compte, vérification toutes les heures
    - I see the light : 5 comptes 
    - Master of Omnicience : aucune limite
    - Paiment via Paypal & paybox
Autentification :
- oTP 
- U2F
- google facebook twitter login
- Qualité du code avec : 
    - travis https://travis-ci.org/
    - insight https://insight.sensiolabs.com/


### Dépendances 

- Symfony > 3.4 Standard Edition
- Taches planifiées
    - Serveur dédié/vps pour utiliser Cron
    - Hebergeur avec systeme de planification de tache.
    - (alternative possible) Page php sans paramètres de type https://domain.ntl/cron.php
- cURL ou cURLPHP
- PHP 7.0 (5.6 peut fonctionner mais pas de support prévus de ma part)
- Apache ou Nginx (serveur php de Symfony en dev certainement fonctionnel)
- MSQL ou autre compatible Doctrine

### Bundles Symfony / Dépendances utilisé

- KnpSnappy https://packagist.org/packages/knplabs/knp-snappy-bundle
- Ckeditor https://packagist.org/packages/egeloen/ckeditor-bundle
- Imagine https://packagist.org/packages/liip/imagine-bundle
- Gravatar https://packagist.org/packages/ornicar/gravatar-bundle
- Uploader https://packagist.org/packages/vich/uploader-bundle
- u2f https://packagist.org/packages/r/u2f-two-factor-bundle
- HWIOAuthBundle https://github.com/hwi/HWIOAuthBundle

## English

PHP WebApp for checking website availability &amp; standard configuration. Build with symfony &amp; Kawaii Potato.