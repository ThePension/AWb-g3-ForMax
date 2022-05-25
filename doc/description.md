# Description du projet ForMax

[[_TOC_]]

## Titre du projet : ForMax

## Paragraphe explicatif

Nous pensons créer un forum classique géré par les utilisateurs. Notre forum regroupera deux types de sujets :

- **Sujets publics** : Tout le monde peut les visiter et y réagir (j'aime, je n'aime pas, favori et commentaire)
- **Sujets privés** : Seuls les utilisateurs authentifiés et ayant accès aux sujets peuvent y participer

Il y aura aussi deux types d'utilisateurs, des utilisateurs authentifiés classiques et des visiteurs.

**Utilisateurs authentifiés :**
- Possèdent un compte et la possibilité de le personnaliser (description, photo, etc.)
- Peuvent créer des sujets publics et privés et les "modérer"
- Consulter des sujets publics et y réagir
- Rejoindre des sujets privés à l'aide d'une clé et y réagir

**Visiteurs :** 

- Pas besoin de s'authentifier 
- Accès en lecture uniquement aux sujets publics

**Autres focntionnalités**

- Chaque utilisateur authentifié reçoit des notifications lorsqu'il y a des ajouts dans un sujet qu'il a créé.
- L'explorateur de sujets affiche en priorité et en plus grand les sujets les mieux référencés.

## Objectifs généraux priorisés

| numéro | description | état |
|---|---|---|
| 1 | Visualiser les différents sujets (données simulées) | DONE |
| 2 | Modération des sujets par leur créateur (CRUD sur des données réelles) | DONE |
| 3 | Gestion des comptes (login) | DONE |
| 4 | Mode visiteur | DONE |
| 5 | Mise en place des sujets privés avec clé d'accès | DONE |
| 6 | Espace commentaire + Like, Dislike | DONE |
| 7 | Possibilité de personnaliser son compte | TODO |
| 8 | Notifications asynchrones | TODO |
| 9 | Sujets favoris plus facilement accessibles | TODO |
| 10 | Ordonner les sujets en fonction de leur référencement | TODO |

(numéro plus haut == plus basse priorité)
