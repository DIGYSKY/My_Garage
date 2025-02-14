# My Garage - Application de Gestion de Véhicules

## 📝 Description

My Garage est une application web full-stack permettant de gérer une collection de véhicules et leurs documents associés. Elle utilise une architecture moderne avec un backend PHP et un frontend React.

## 🛠 Technologies Utilisées

### Backend
- PHP 8.4
- MySQL 8.0
- Nginx
- Docker & Docker Compose
  - Installation de Docker : [Guide d'installation Docker](https://docs.docker.com/get-docker/)
  - Installation de Docker Compose : [Guide d'installation Docker Compose](https://docs.docker.com/compose/install/)

### Frontend
- React 19
- TypeScript
- Tailwind CSS
- React Router 7
- Axios

## 🏗 Architecture

Le projet est divisé en deux parties principales :

### API (Backend)
- Architecture MVC
- Système de routage personnalisé
- Gestion des logs
- Gestion des CORS
- Base de données relationnelle

### Application (Frontend)
- Interface utilisateur moderne
- Gestion d'état avec React Query
- Routage côté client
- Composants réutilisables

## 📊 Structure de la Base de Données

Trois tables principales :
- `cars` : Informations sur les véhicules
- `documents` : Documents associés aux véhicules
- `images` : Images des véhicules (à venir)

## 🚀 Installation

1. Cloner le repository :
```bash
git clone [url-du-repo]
cd my-garage
```

2. Lancer les containers Docker :
```bash
cd api
./manage start
```

3. Installer les dépendances frontend :
```bash
cd ../app
yarn install
```

4. Lancer l'application frontend :
```bash
yarn dev
```

## 📡 Points d'Accès

- Frontend : `http://localhost:5173`
- API : `http://localhost:81`
- PHPMyAdmin : `http://localhost:8080`
- MySQL : `localhost:3307`

## 🛠 Commandes Utiles

### Backend (via le script manage)

```bash
./manage start        # Démarre tous les services
./manage stop         # Arrête tous les services
./manage restart      # Redémarre tous les services
./manage logs api     # Affiche les logs de l'API
./manage status      # Affiche le status des services
```

### Frontend

```bash
yarn dev          # Lance le serveur de développement
yarn build        # Build l'application
yarn typecheck    # Vérifie les types TypeScript
```

## 🔐 Configuration

### Base de Données
Les configurations de la base de données se trouvent dans :
```bash
api/src/config/config.json
```

### CORS
La configuration CORS est gérée dans :
```bash
api/src/utils/CorsHandler.php
```

## 📁 Structure des Dossiers

```
.
├── api/
│   ├── My_Garage/         # Configuration Docker
│   ├── src/
│   │   ├── controllers/   # Contrôleurs
│   │   ├── models/        # Modèles
│   │   ├── utils/         # Utilitaires
│   │   └── routes/        # Configuration des routes
│   └── logs/             # Fichiers de logs
└── app/
    ├── app/
    │   ├── Components/    # Composants React
    │   └── routes/        # Routes React Router
    └── public/           # Assets statiques
```

## 🤝 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push sur la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 License

[GNU GPLv3 License](LICENSE)
