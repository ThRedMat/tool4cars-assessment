# Technical Assessment - Gestionnaire de flotte automobile

Ce projet est une solution web modulaire permettant à différents professionnels de l'automobile (Client A, B et C) de gérer leurs flottes de véhicules et leurs garages partenaires via une interface centralisée.

L'application repose sur une architecture "Multi-tenant" hébergeant un socle commun tout en permettant une isolation et une personnalisation stricte des règles métier de chaque client.

## Prérequis et Installation

1. Cloner ce dépôt sur votre machine locale.
2. Ouvrir un terminal à la racine du projet.
3. Lancer le serveur web interne de PHP :
   php -S localhost:8000
4. Accéder à l'application depuis un navigateur à l'adresse : http://localhost:8000

## Choix Techniques et Architecture

Le projet a été conçu pour être évolutif (scalable) en limitant le rechargement des pages et en optimisant l'expérience utilisateur.

- **Interface Dashboard (Dark Mode)** : L'interface a été développée sous forme de dashboard moderne pour répondre aux standards des logiciels SaaS actuels, incluant une navigation latérale et une gestion dynamique de l'affichage.

- **Routage dynamique (AJAX)** : Le fichier index.php agit comme un point d'entrée unique. Les événements utilisateur (changement de client, navigation) sont interceptés par jQuery qui met à jour l'interface dynamiquement via des requêtes AJAX ciblées.

- **Architecture Modulaire** : Le routage s'appuie sur des attributs HTML (data-module) pour construire les chemins d'accès dynamiquement. Chaque client possède son propre répertoire dans /customs/, ce qui permet d'ajouter des modules exclusifs (comme le module Garage du Client B) sans impacter le noyau dur de l'application.

- **Jointure de données** : Le système effectue des croisements dynamiques entre les fichiers JSON (cars.json et garages.json) pour afficher les informations contextuelles (ex: remplacer les ID de garages par leurs noms réels pour le Client B).

## Étape 6 : Analyse de Sécurité et Recommandations

Dans le cadre d'une mise en production réelle, voici les vulnérabilités identifiées sur cette architecture et les solutions préconisées :

### 1. Faille de cloisonnement (IDOR) via le Cookie

- **Risque** : L'identité du client est actuellement stockée dans un cookie côté navigateur. Un utilisateur peut modifier ce cookie manuellement pour accéder aux données d'un autre client.
- **Solution** : Utiliser les sessions PHP ($\_SESSION) gérées côté serveur après une authentification sécurisée.

### 2. Accès direct aux sources de données

- **Risque** : Les fichiers JSON sont dans un répertoire public. Un utilisateur averti peut y accéder directement via l'URL.
- **Solution** : Déplacer le dossier /data/ en dehors du répertoire public du serveur ou interdire l'accès via un fichier .htaccess (Require all denied).

### 3. Exécution directe des scripts PHP

- **Risque** : Les scripts dans /customs/ peuvent être appelés individuellement par URL, contournant le flux normal de l'application.
- **Solution** : Définir une constante de sécurité dans index.php et vérifier sa présence au début de chaque fichier inclus.

### 4. Injections XSS (Cross-Site Scripting)

- **Risque** : Affichage de données malveillantes injectées dans les fichiers JSON.
- **Solution (Implémentée)** : Toutes les données affichées passent systématiquement par la fonction PHP htmlspecialchars(), neutralisant ainsi toute tentative d'exécution de code JavaScript dans le navigateur.
