# Projet QCM

Ce projet est une application web permettant aux utilisateurs de créer, modifier et participer à des questionnaires à choix multiples (QCM). Il inclut un système d'authentification, la gestion des QCM et l'envoi d'emails de confirmation via PHPMailer et Mailtrap.

## 📌 Fonctionnalités

✅ Inscription et connexion sécurisées des utilisateurs  
✅ Création, modification et suppression de QCM  
✅ Participation aux QCM avec suivi des résultats  
✅ Envoi d'emails de confirmation via **PHPMailer** et **Mailtrap**  

## 🛠 Technologies utilisées

- **Langage Backend** : PHP (Architecture MVC)  
- **Base de données** : MySQL  
- **Frontend** : HTML, CSS, JavaScript, TailwindCSS  
- **Emailing** : PHPMailer & Mailtrap  

---

## 🚀 Installation

### 1️⃣ Cloner le projet

```bash```
git clone https://github.com/amanigharbi/projet_qcm.git
cd projet_qcm

### 2️⃣ Installer les dépendances

composer install

### 3️⃣ Configurer la base de données

** mysql -u votre_utilisateur -p votre_base_de_données < bdd/qcm_platform.sql

Mettez à jour votre fichier **.env** avec vos paramètres de connexion MySQL :

- **DB_HOST** =localhost
- **DB_NAME** =qcm_platform
- **DB_USER** =root
- **DB_PASS** =votre_mot_de_passe

### 4️⃣ Configurer l'envoi d'emails

L'application utilise **PHPMailer** et **Mailtrap** pour l'envoi d'emails.
Modifiez le fichier **.env** avec vos propres identifiants Mailtrap :

- **MAIL_HOST** =smtp.mailtrap.io
- **MAIL_USERNAME** =votre_identifiant
- **MAIL_PASSWORD** =votre_mot_de_passe
- **MAIL_PORT** =2525
- **MAIL_FROM** =noreply@votre_domaine.com

Si vous souhaitez tester l'envoi d'emails, assurez-vous d'avoir un compte **Mailtrap** et d'insérer vos propres configurations.

### 5️⃣ Démarrer le serveur

php -S localhost:8000

Puis, ouvrez votre navigateur et accédez à : [http://localhost:8000](http://localhost:8000)





