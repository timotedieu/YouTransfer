# YouTransfer

Bienvenue sur le projet **YouTransfer**, une plateforme permettant la gestion des utilisateurs, l'upload et le téléchargement de fichiers, ainsi qu'un système de réservation pour les téléchargements. Ce projet utilise PHP, MySQL et Bootstrap pour le design.

## Auteurs

- **Lucas MONIEZ**  
- **Timoté DIEU**

## Description

Le projet permet de gérer les utilisateurs via un système d'inscription et de connexion, ainsi que de gérer l'upload, le suivi et la suppression de fichiers. Un système de réservation pour le téléchargement de fichiers est également intégré, afin de mieux organiser les téléchargements en fonction de la demande.

## Fonctionnalités

- **Création de compte** : Permet aux utilisateurs de s'inscrire sur la plateforme.  
- **Connexion utilisateur** : Permet aux utilisateurs de se connecter avec leur compte.  
- **Modification du profil** : Les utilisateurs peuvent mettre à jour leurs informations personnelles.  
- **Envoi et téléchargement de fichiers** : Les utilisateurs peuvent envoyer et télécharger des fichiers.  
- **Suivi du nombre de téléchargements** : Le nombre de téléchargements est comptabilisé pour chaque fichier.  
- **Suppression de fichiers** : Les utilisateurs peuvent supprimer leurs fichiers.  
- **Système de réservation pour le téléchargement** : Les utilisateurs peuvent réserver un créneau pour le téléchargement d'un fichier.

## Technologies utilisées

- **PHP** : Langage de programmation pour la gestion des utilisateurs et des fichiers.
- **MySQL** : Base de données pour stocker les informations des utilisateurs et des fichiers.
- **PDO** : Méthode sécurisée pour interagir avec la base de données.
- **Bootstrap** : Framework CSS pour le design responsive et moderne.

## Installation

Voici les étapes pour installer et utiliser ce projet :
1. Clonez ce dépôt ou téléchargez les fichiers.  
2. Configurez votre serveur local avec PHP et MySQL.
3. Importez la base de données à partir du fichier `database.sql` (inclus dans le projet).
4. Assurez-vous d'avoir les bonnes configurations dans le fichier de connexion à la base de données (`db.php`).
5. Lancez votre serveur local et ouvrez `index.php` dans votre navigateur.

## Structure des fichiers

- `index.php` : Page d'accueil de la plateforme.  
- `signup.php` : Page d'inscription des utilisateurs.  
- `login.php` : Page de connexion des utilisateurs.  
- `profile.php` : Page permettant de modifier le profil.  
- `upload.php` : Page pour télécharger des fichiers.  
- `download.php` : Page pour télécharger les fichiers réservés.  
- `delete.php` : Page permettant de supprimer des fichiers.  
- `reserve.php` : Page de réservation pour le téléchargement des fichiers.  
- `db.php` : Fichier de configuration de la base de données.  
- `database.sql` : Script pour créer la base de données et ses tables.

## Inspirations

Ce projet s'inspire des plateformes modernes de gestion de fichiers et de réservations, avec une interface simple et intuitive.

---

Merci d'explorer notre projet ! Nous espérons que vous apprécierez l'expérience.
