<form action="index.php?controller=Admin&action=addEvenement" method="post" enctype="multipart/form-data">
    <div>
        <label for="id_categorie">Catégorie :</label>
        <select id="id_categorie" name="id_categorie" required>
            <?php foreach ($categories as $categorie): ?>
                <option value="<?= htmlspecialchars($categorie->id_categorie) ?>">
                    <?= htmlspecialchars($categorie->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="nom">Nom de l'événement :</label>
        <input type="text" id="nom" name="nom" required>
    </div>

    <div>
        <label for="date">Date :</label>
        <input type="date" id="date" name="date" required>
    </div>

    <div>
        <label for="heure">Heure :</label>
        <input type="time" id="heure" name="heure" required>
    </div>

    <div>
        <label for="description">Description :</label>
        <textarea id="description" name="description" rows="5" required></textarea>
    </div>

    <div>
        <label for="place">Nombre de places :</label>
        <input type="number" id="place" name="place" min="1" required>
    </div>

    <div>
        <label for="photo">Photo de l'événement :</label>
        <input type="file" id="photo" name="photo" required>
    </div>

    <div>
        <button type="submit">Ajouter l'événement</button>
    </div>
</form>