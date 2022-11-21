## EnchereAuto/Autoriko

**Projet développé par :**
- PORTARO Lucas

**Information :**
- Ce projet a été réalisé durant mon stage de licence : j'avais pour objectif de créer un site de ventes aux enchères du début à la fin - mon seul package était une maquette Photoshop développer par un freelance. J'avais 3 mois pour développer cette application en ligne que je n'ai pas pu finaliser car au bout du deuxième mois les deux directeurs de l'entreprise on décidaient de mettre fin au projet pour des raisons personnelles que je n'ai jamais pu savoir.. Ils ont mis totalement fin à leur projet.
- La création du MCD (Modèle conceptuel de données) a été réalisé avec l'outil JMerise (outil payant pour ce type de projet) - une image du MCD est disponible dans ./SQL/model_conceptuel_donnees.png
- Un thème m'avait été fourni par mon tuteur de stage pour le Backoffice

**Bibliothèque/framework & outil utilisé :**
- CSS: Préprocesseur Sass
- JS: Framework VueJS (v3) (w: vuex, vue-router), Axios, momentJS, jQuery
- PHP: Micro-framework Slim, Twig, Firebase php-jwt, Eloquent, Monolog, phpmailer
- SMTP: MailDev (environment pour tester l'envoi des mails)

## Installation générale du projet

**Installation** :

Création du style de mes fichiers (CSS) dans le dossier /FrontOffDesign
Nous pouvons y retrouver mes fichiers sass

Création de l'application VueJS dans le dossier /FrontOffice
Je récupérais les fichiers build à l'intérieur du dossier /dist que je transférai à l'intérieur de mon docker par la suite
Je faisais comme ça pendant mon stage c'était vraiment casse tête.. à l'heure d'aujourd'hui je sais qu'il existe des façon beaucoup plus simple notamment grâce à Symfony qui peut prendre en charge du code scss et build directement une app VueJS dans le même directory

Pour visualiser le projet final :
- nano /etc/hosts
- ajouté l'IP et le DNS comme ceci : '127.0.0.1 autoriko.fr'

Lancement des containers Docker (docker-compose) :
- cd Autoriko
- docker-compose up -d

Import de la base de données MySQL :
- Se rendre sur http://localhost:12780/
- Identifiants : com:com
- Importer le fichier SQL se trouvant ici : ./Autoriko/SQL/autoriko.sql

Rendez-vous sur votre navigateur préféré :
- http://autoriko.fr:12080/

Une confirmation pour la création de son compte sera envoyé par mail.
Pour tester cette fonctionnalité veuillez vous rendre sur : http://localhost:1210/ (lien to MailDev)

**Accès FrontOffice** :
- portaro.lucas@gmail.com | Mot de passe : azerty
- http://autoriko.fr:12080/

**Accès MailDev** :
- http://localhost:1210/

**Accès BackOffice** :
- john@local.dev | Mot de passe : azerty
- http://autoriko.fr:12080/admin

**Accès Base de données** :
- com | Mot de passe : com
- http://localhost:12780/
