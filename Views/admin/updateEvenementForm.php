<form action="index.php?controller=Admin&action=updateEvenement" method="post">
    <!-- Champ caché pour l'ID de l'événement -->
    <input type="hidden" name="id_evenement" value="<?= htmlspecialchars($evenement->id_evenement) ?>">

    <div>
        <label for="id_categorie">Catégorie :</label>
        <select id="id_categorie" name="id_categorie" required>
            <?php foreach ($categories as $categorie): ?>
                <option value="<?= htmlspecialchars($categorie->id_categorie) ?>"
                    <?= $categorie->id_categorie == $evenement->id_categorie ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categorie->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="nom">Nom de l'événement :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($evenement->nom) ?>" required>
    </div>

    <div>
        <label for="date">Date :</label>
        <input type="date" id="date" name="date" value="<?= htmlspecialchars($evenement->date) ?>" required>
    </div>

    <div>
        <label for="heure">Heure :</label>
        <input type="time" id="heure" name="heure" value="<?= htmlspecialchars($evenement->heure) ?>" required>
    </div>

    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($evenement->description) ?></textarea>
    </div>

    <div>
        <label for="place">Nombre de places :</label>
        <input type="number" id="place" name="place" min="1" value="<?= htmlspecialchars($evenement->place) ?>" required>
    </div>

    <div>
        <label for="photo">Photo actuelle :</label>
        <div>
            <img src="<?= htmlspecialchars($evenement->photo) ?>" alt="Image actuelle de l'événement" style="max-width: 200px; max-height: 200px;">
        </div>
        <label for="photo">Nouvelle photo :</label>
        <input type="file" id="photo" name="photo" accept="image/*">
    </div>

    <div>
        <button type="submit">Mettre à jour l'événement</button>
    </div>
</form>