# TaskList Reloaded

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/Symfony-8.0-000000?style=for-the-badge&logo=symfony&logoColor=white" alt="Symfony 8">
  <img src="https://img.shields.io/badge/Doctrine-ORM-FC6A31?style=for-the-badge&logo=doctrine&logoColor=white" alt="Doctrine ORM">
  <img src="https://img.shields.io/badge/Twig-3-000000?style=for-the-badge&logo=twig&logoColor=white" alt="Twig">
  <img src="https://img.shields.io/badge/TailwindCSS-38BDF8?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Stimulus-77E8B9?style=for-the-badge&logo=stimulus&logoColor=black" alt="Stimulus">
</p>

Application Symfony de gestion de tâches personnelles avec authentification, priorités, dossiers, statuts et filtres.

Ce dépôt est un fork de [CHAOUCHI/phase3-symfony-tasklist-reloaded](https://github.com/CHAOUCHI/phase3-symfony-tasklist-reloaded).

## Fonctionnalités vérifiées

- inscription avec email, nom d'utilisateur et mot de passe haché ;
- connexion et déconnexion Symfony Security ;
- tâches associées à l'utilisateur connecté ;
- création, affichage, modification et suppression d'une tâche ;
- statuts `En cours`, `Terminée` et `Archivée` ;
- changement rapide du statut via un contrôleur Stimulus ;
- priorités personnalisées avec niveau d'importance et couleur ;
- priorités par défaut `Urgent`, `Important` et `Normal` disponibles via les fixtures ;
- dossiers personnels avec nom et couleur ;
- filtrage côté interface par statut, dossier et priorité.

L'entité `Task` contient également le champ `isPinned`, mais le code actuel ne contient pas de route dédiée pour basculer cette valeur.

## Stack et données

Le projet utilise Symfony 8, PHP 8.4, Doctrine ORM, Twig, Stimulus et le bundle Tailwind.

La configuration par défaut de `.env` utilise SQLite :

```text
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data_%kernel.environment%.db"
```

Le dépôt fournit aussi une configuration Docker Compose pour PostgreSQL 16.

## Installation

```bash
git clone https://github.com/loic31000/phase3-symfony-tasklist-reloaded.git
cd phase3-symfony-tasklist-reloaded
composer install
php bin/console doctrine:migrations:migrate
```

Pour charger les priorités par défaut sur une base de développement :

```bash
php bin/console doctrine:fixtures:load
```

Attention : la commande Doctrine Fixtures purge la base ciblée avant le chargement.

Si Symfony CLI est installé :

```bash
symfony serve
```

## PostgreSQL avec Docker

```bash
docker compose up -d database
```

Dans ce cas, adaptez `DATABASE_URL` à PostgreSQL dans un fichier local non versionné.

## Structure

```text
src/
├── Config/
├── Controller/
├── DataFixtures/
├── Entity/
├── Form/
└── Repository/

assets/controllers/
├── task_checkbox_controller.js
└── task_filter_controller.js
```

## Tests

PHPUnit est configuré dans `composer.json` et `phpunit.dist.xml`. Le dossier `tests/` contient actuellement le bootstrap mais pas de cas de test métier.

## Origine pédagogique

Le cahier des charges d'origine est conservé dans l'historique du projet. Ce README décrit l'état réel du code présent sur cette branche.
