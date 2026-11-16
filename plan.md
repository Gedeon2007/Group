# Plan — TOTAL GROUP 360

## Approche

Construire une SPA mobile-first sans framework, livrée dans `index.html`, afin de rester directement compatible avec Firebase Hosting et de respecter la demande d’un fichier unique. Le HTML porte la structure, le CSS porte le système visuel et le JavaScript gère la navigation, les interactions, le mode démo et l’intégration Firebase modulaire v10.

Le site démarre en mode démo lorsque `firebaseConfig` contient encore des valeurs à remplir : les pages restent navigables, les cartes et profils de démonstration sont visibles et les formulaires expliquent clairement comment activer Firebase. Dès qu’une configuration Firebase valide est fournie, les mêmes fonctions utilisent Auth, Firestore et les transactions de compteurs.

## Architecture

- `index.html` : structure SPA, styles CSS, importmap Firebase et script applicatif.
- `manus-routes.json` : déclaration des routes de page attendues par l’environnement Preview.
- `app.config.ts` : métadonnée de logo de projet.
- `TODO.md` : résultats attendus et critères conservés du cahier des charges.

## Design

### Mouvement

**Arcade urbaine congolaise** : une interface sombre et énergique qui mélange badge de membre, signalétique de tournoi et carte de communauté.

### Principes

1. Hiérarchie très lisible sur petit écran, avec des CTA de 48 px minimum.
2. Une identité par branche, tout en conservant une coque commune noire/orange.
3. Des cartes de contenu qui donnent une sensation de collection et de progression.
4. Des états explicites : démo, en attente, validé, introuvable, succès ou erreur.

### Philosophie couleur

Le noir donne de la profondeur et fait ressortir l’orange signature du groupe. Les accents rose-violet signalent la curiosité POP, tandis que le blanc-vert de BIB crée un îlot de calme et de confiance. Les gradients sont réservés aux surfaces d’identité, pas au texte long.

### Paradigme de mise en page

Une coque fixe avec navigation compacte, un hero en diagonale légère, puis des rails de cartes et des sections en deux colonnes qui se replient en flux vertical. Les blocs sont alignés sur une grille souple mais gardent des décalages et des “plaques” visuelles pour éviter l’effet tableau administratif.

### Signatures

- Motif de plaque : petites lignes techniques, code monospace et micro-étiquettes.
- Bordures lumineuses et pastilles de branche utilisées comme repères de navigation.
- Boutons orange “pressables” avec ombre courte et translation au survol.

### Interaction et animation

Les pages apparaissent avec une montée douce de 220 ms. Les cartes se soulèvent légèrement au survol et les boutons ont un retour tactile immédiat. Le menu mobile glisse depuis la droite avec un voile sombre. Aucun mouvement essentiel ne dépend de l’animation.

### Typographie

Poppins pour la marque, les titres et les contrôles ; Inter en secours pour le texte courant. Les titres sont compacts et légèrement serrés ; les métadonnées utilisent une casse courte et une forte couleur secondaire.

### Essence et voix

**Une famille de passionnés qui transforme chaque centre d’intérêt en terrain de jeu local.** Personnalité : énergique, accueillante, fiable.

La voix est directe et chaleureuse : « Choisis ton univers. Fais ta place. » et « Ta plaque prouve que tu fais partie de la famille. »

### Wordmark et couleur signature

Le mot-symbole associe `TOTAL` en graisse forte à un cartouche `360` orange, avec une ligne de statut `LUBUMBASHI · RDC`. La couleur propriétaire est l’orange braise `#FF6B00`, utilisé comme signal d’action et de reconnaissance.

## Données et sécurité

Le code conserve la configuration Firebase dans un bloc clairement identifiable. En mode configuré, les inscriptions utilisent une transaction sur `compteurs/{BRANCHE}_{ANNEE}`, les photos sont réduites par Canvas puis stockées en Base64, les membres commencent avec `Nouveau` et `en_attente`, et les actions d’administration sont conditionnées par Firebase Auth. Les règles Firestore recommandées sont incluses en commentaire à la fin du fichier.

## Déroulé de build

1. Créer la SPA, son design et les contenus des 9 espaces.
2. Ajouter l’état local de démonstration et les adaptateurs Firestore/Auth.
3. Ajouter les téléchargements de carte, QR codes, compressions d’images et validations de formulaires.
4. Ajouter le manifeste de routes, la métadonnée de logo et le serveur statique de Preview.
5. Vérifier syntaxe, manifest, serveur et rendu mobile/desktop, puis enregistrer un checkpoint Git.
