# TODO — TOTAL GROUP 360

## 1. Coque, navigation et identité

- [ ] Livrer une SPA sans rechargement avec `showPage('accueil')` et les espaces accueil, inscription, profil/plaque, annonces, champions, confiance, administrateurs, contact et espace staff.
- [ ] Afficher l’en-tête fixe avec logo TOTAL GROUP 360, Lubumbashi · RDC, bouton Ma plaque, navigation PC et menu hamburger coulissant sur mobile.
- [ ] Afficher le pied de page avec TOTAL GROUP 360 - Lubumbashi, RDC, lien Espace staff et WhatsApp 0855545072.
- [ ] Appliquer le fond #0A0A0A, accent #FF6B00, texte blanc, Poppins/Inter, cartes arrondies, ombres douces et boutons larges.
- [ ] Afficher le bandeau « VERSION TEST - 10 à 15 testeurs » sans bloquer la navigation.

## 2. Branches et accueil

- [ ] Afficher le message « Bienvenue dans la famille TOTAL GROUP 360 » et trois cartes GAME, POP et BIB cliquables avec leurs couleurs, descriptions et bouton Rejoindre.
- [ ] Permettre les CTA « Je m’inscris » et « Voir les annonces ».
- [ ] Afficher la section Prochain événement avec un objet modifiable en haut du JavaScript.
- [ ] Conserver la règle métier : un membre choisit une seule branche principale ; championnat, classement et plaque restent liés à cette branche.

## 3. Inscription et plaque

- [ ] Formulaire avec nom complet obligatoire, pseudo obligatoire, WhatsApp, quartier, choix GAME/POP/BIB et photo.
- [ ] Convertir la photo en Base64 compressée, redimensionnée à 300×300 et limitée à environ 500 ko.
- [ ] Générer `TG360-BRANCHE-ANNÉE-NUMÉRO` via une transaction Firestore sur `compteurs/{BRANCHE}_{ANNÉE}` lorsque Firebase est configuré.
- [ ] Créer une inscription avec rang `Nouveau` et statut `en_attente`, puis ouvrir Mon Profil.

## 4. Carte, vérification et annonces

- [ ] Afficher la carte avec photo ronde, pseudo, nom, rang, plaque monospace, QR Code contenant uniquement la plaque et bouton PNG via html2canvas.
- [ ] Afficher le badge « ⏳ En attente de validation » pour une nouvelle inscription.
- [ ] Vérifier une plaque et retourner « ✅ Membre vrai - Pseudo, Branche, Rang » ou « ❌ Plaque introuvable ».
- [ ] Lister les annonces de la plus récente à la plus ancienne avec image facultative, titre, texte et date, puis afficher « Aucune annonce pour le moment. » si nécessaire.

## 5. Champions, confiance et administrateurs

- [ ] Afficher trois sections Champions GAME, POP et BIB ; ne montrer que les rangs Champion / Ancien ou supérieurs.
- [ ] Afficher la page Confiance avec le règlement demandé, une grille d’équipe et une grille de preuves de récompenses.
- [ ] Afficher les membres Staff/Admin avec photo, pseudo, rôle et branche, ainsi qu’un bouton WhatsApp vers 0855545072.

## 6. Contact

- [ ] Afficher des boutons larges WhatsApp, TikTok, Facebook et YouTube alimentés par `LIENS_SOCIAUX`/`CONFIG_SITE`.
- [ ] Enregistrer les doléances dans `doleances` avec pseudo/nom obligatoire, WhatsApp facultatif, message obligatoire et date.
- [ ] Afficher l’adresse physique à remplir plus tard.

## 7. Espace staff

- [ ] Proposer la connexion Firebase Auth Email/Mot de passe et gérer le cas non connecté.
- [ ] Dans le dashboard connecté, gérer membres : validation, changement de rang et retrait avec confirmation.
- [ ] Dans le dashboard connecté, lister/supprimer les doléances.
- [ ] Dans le dashboard connecté, publier/supprimer les annonces avec titre, texte et image URL.
- [ ] Interdire au visiteur de s’attribuer un rang supérieur ; seuls les comptes staff authentifiés modifient le rang.

## 8. Firebase et livraison

- [ ] Fournir `firebaseConfig` clairement commenté avec valeurs à remplir, imports Firebase v10 modulaires via CDN, collections `membres`, `annonces`, `doleances`, `compteurs` et règles Firestore en commentaire.
- [ ] Fournir `manus-routes.json`, servir la page sur le port 3000 et conserver une livraison statique compatible Firebase Hosting.
- [ ] Vérifier la syntaxe, le démarrage du serveur et les parcours visibles sans configuration Firebase.
