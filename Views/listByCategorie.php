<div class="listEvenementsByCategorie">
    <?php foreach ($evenements as $evenement): ?>
        <div class="evenementByCategorie">
            <img src="<?= htmlspecialchars($evenement->photo) ?>" alt="Image de l'événement">
            <h3><?= htmlspecialchars($evenement->nom) ?></h3>
            <p><strong>Date :</strong> <?= htmlspecialchars($evenement->date) ?></p>
            <p><strong>Heure :</strong> <?= htmlspecialchars($evenement->heure) ?></p>
            <p><strong>Places restantes :</strong> <?= htmlspecialchars($evenement->place) ?></p>
            <a href="index.php?controller=Evenement&action=displayEvenement&id_evenement=<?= htmlspecialchars($evenement->id_evenement) ?>">En savoir plus</a>
            <a href="index.php?controller=Reservation&action=addReservation&id_evenement=<?= htmlspecialchars($evenement->id_evenement) ?>">Je veux ma place!</a>
        </div>
    <?php endforeach; ?>
</div>