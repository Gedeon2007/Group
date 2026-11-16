# Déploiement TOTAL GROUP 360

## Ce qui fonctionne partout

Le frontend est un site statique en un seul `index.html`. Il peut être déployé directement sur Firebase Hosting, Netlify, Vercel ou comme service Render. Les fichiers `firebase.json`, `netlify.toml` et `vercel.json` gèrent les routes SPA. Pour Render, `render.yaml`, `Dockerfile` et `router.php` servent le frontend et l’API PHP ensemble.

## Configuration à remplir

Dans `index.html`, complète `CONFIG_SITE.siteUrl` avec le vrai domaine public, les liens TikTok/Facebook/YouTube, l’adresse et l’événement. Remplace aussi `firebaseConfig` par les valeurs du projet Firebase. Si Firebase est activé, le formulaire de contact continue d’utiliser Firestore.

## API PHP optionnelle

`api/contact.php` ne remplace pas Firebase Auth : la connexion staff reste gérée par Firebase Auth et la collection protégée `staff_roles`. L’API PHP sert pour les doléances si tu veux utiliser un serveur PHP/Render. Elle vérifie la méthode HTTP, la taille JSON, le champ anti-robot, les longueurs, le numéro WhatsApp, l’origine autorisée et limite les envois par IP. Elle peut envoyer par `mail()` ou écrire temporairement en log avec `CONTACT_TRANSPORT=log`.

Sur Render, configure les variables `ALLOWED_ORIGIN`, `CONTACT_EMAIL` et `CONTACT_TRANSPORT=mail`. Puis mets `phpEndpoint: "/api/contact.php"` dans `CONFIG_SITE`. Ne mets jamais un mot de passe, une clé SMTP ou une clé Firebase privée dans le navigateur. Netlify et Vercel ne lancent pas directement PHP : laisse `phpEndpoint` vide et utilise Firebase/Firestore pour les doléances, ou déploie l’API PHP sur un service Render séparé.

PHP ne crée pas à lui seul une connexion HTTPS : Render, Netlify et Vercel fournissent le TLS devant l’application. Pour une vraie gestion de comptes, conserve Firebase Auth ou utilise un fournisseur d’identité professionnel ; ne stocke jamais les mots de passe en clair dans PHP.

## SEO

Le site contient des titres et descriptions par route, Open Graph, Twitter Cards, données structurées Organization, manifeste PWA, `robots.txt` et `sitemap.xml`. Avant publication, remplace `https://VOTRE-DOMAINE.example` dans `robots.txt` et `sitemap.xml`, puis renseigne `CONFIG_SITE.siteUrl`.
