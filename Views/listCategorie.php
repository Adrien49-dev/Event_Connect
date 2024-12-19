<div class="listCategories">
    <?php foreach ($categories as $categorie): ?>
        <a href="index.php?controller=Evenement&action=displayAllEvenementByCategorie&id_categorie=<?= htmlspecialchars($categorie->id_categorie) ?>" class="categorie">
            <div class="imageCategorie">
                <img src="<?= htmlspecialchars($categorie->photo) ?>" alt="Image de la catégorie">
                <h2><?= htmlspecialchars($categorie->nom) ?></h2>
            </div>
        </a>
    <?php endforeach; ?>
</div>