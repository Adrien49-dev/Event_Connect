<a href="index.php?controller=Admin&action=addEvenement"><i class="fa-solid fa-plus fa-2x"></i>Ajouter un événement</a>
<div class="listEvenements">

    <?php foreach ($evenements as $evenement): ?>
        <div class="evenement">
            <h2><?= htmlspecialchars($evenement->nom) ?></h2>
            <p><strong>Catégorie :</strong> <?= htmlspecialchars($evenement->category_name) ?></p>
            <p><strong>Description :</strong> <?= htmlspecialchars($evenement->description) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($evenement->date) ?></p>
            <p><strong>Heure :</strong> <?= htmlspecialchars($evenement->heure) ?></p>
            <p><strong>Places disponibles :</strong> <?= htmlspecialchars($evenement->place) ?></p>
            <div class="imageEvent">
                <img src="<?= htmlspecialchars($evenement->photo) ?>" alt="Image de l'événement">
            </div>
            <div class="actions">
                <!-- Lien pour supprimer l'événement -->
                <a href="index.php?controller=Admin&action=deleteEvenement&id_evenement=<?= htmlspecialchars($evenement->id_evenement) ?>"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                    Supprimer
                </a>
                <!-- Lien pour modifier l'événement -->
                <a href="index.php?controller=Admin&action=updateEvenementForm&id_evenement=<?= htmlspecialchars($evenement->id_evenement) ?>">
                    Modifier
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>