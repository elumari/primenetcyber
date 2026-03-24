# PrimeNet Cyber Ngaoundéré

Application web de gestion d'un cyber café, développée en PHP avec une base de données MySQL. Elle permet aux clients de faire des réservations en ligne et à l'administrateur de suivre les sessions, paiements et clients depuis un tableau de bord.

---

## Ce que fait l'application

Côté client :
- Voir les services disponibles et leurs tarifs
- Faire une réservation (nom, téléphone, service, date, durée, mode de paiement)
- Recevoir une confirmation via WhatsApp automatiquement après la réservation
- Contacter le cyber café directement

Côté admin :
- Se connecter de façon sécurisée (mot de passe haché)
- Voir le tableau de bord avec les statistiques : nombre de clients, réservations, revenus, paiements en attente
- Gérer les réservations et démarrer les sessions
- Valider les paiements
- Générer et télécharger les factures en PDF

---

## Technologies utilisées

- PHP 8.x
- MySQL 
- Bootstrap 5 (CSS uniquement, pas de CSS custom complexe)
- Bootstrap Icons
- Dompdf (génération PDF des factures)
- Sessions PHP pour l'authentification admin

---

## Structure du projet

```
Cyber-cafe/
├── index.php               accueil
├── services.php            liste des services
├── tarifs.php              grille tarifaire
├── reservation.php         formulaire de réservation
├── contact.php             coordonnées du cyber
├── config/
│   └── db.php              connexion à la base de données
├── includes/
│   ├── header.php          header + navbar communs
│   └── footer.php          footer commun
├── admin/
│   ├── login.php           connexion admin
│   ├── dashboard.php       tableau de bord
│   ├── reservations.php    liste des réservations
│   ├── sessions.php        suivi des sessions actives
│   ├── paiements.php       gestion des paiements
│   ├── facture.php         génération PDF
│   ├── start_session.php   démarrage d'une session
│   ├── valider.php         validation d'un paiement
│   ├── logout.php          déconnexion
│   └── includes/
│       ├── admin_header.php    navbar admin
│       └── admin_footer.php    footer admin
├── assets/
│   ├── css/style.css
│   ├── js/script.js
│   └── images/log.png
├── vendor/                 dépendances Composer (Dompdf)
├── composer.json
└── cyber.sql               base de données complète
```

### Prérequis

- XAMPP  (PHP 8+ et MySQL)
- Composer installé

### Étapes

1. Copier le dossier `Cyber-cafe` dans `htdocs/` (XAMPP)

2. Ouvrir phpMyAdmin, créer une base de données nommée `cyber`

3. Importer le fichier `cyber.sql` dans cette base

4. Vérifier les paramètres de connexion dans `config/db.php` :

```php
$host     = "localhost";
$user     = "root";
$password = "";       // adapter si besoin
$dbname   = "cyber";
```

5. Installer les dépendances PHP :

```bash
composer install
```

6. Ouvrir le navigateur sur `http://localhost/Cyber-cafe/`

---

## Accès administrateur

URL : `http://localhost/Cyber-cafe/admin/login.php`

Identifiants par défaut :

| Champ | Valeur |
|---|---|
| Nom d'utilisateur | `admin` |
| Mot de passe | `1234` |

---

## Base de données

7 tables principales :

| Table | Rôle |
|---|---|
| `admin` | compte administrateur |
| `clients` | clients enregistrés lors des réservations |
| `services` | types de services proposés |
| `tarifs` | prix par service et par unité |
| `reservations` | réservations effectuées |
| `paiements` | paiements liés aux réservations |
| `sessions` | sessions de navigation démarrées par l'admin |

---

## Sécurité

- Requêtes préparées partout (protection injection SQL)
- `htmlspecialchars()` sur tous les affichages (protection XSS)
- Mot de passe admin haché avec `password_hash()` / `password_verify()`
- Vérification de session sur toutes les pages admin
- `session_regenerate_id()` à chaque démarrage de session

---

## Auteur

Projet réalisé dans le cadre d'un TPE d'Ingenerie des Applications Web — Par Oumar Mahadjir
