<h1>Mes Réservations</h1>

<div class="reservations">
    <?php if (!empty($reservations)) : ?>
        <?php foreach ($reservations as $reservation) : ?>
            <div class="reservation">
                <h3><?= htmlspecialchars($reservation['nom']) ?></h3>
                <p><strong>Date de l'événement :</strong> <?= htmlspecialchars($reservation['date']) ?></p>
                <p><strong>Réservé le :</strong> <?= htmlspecialchars($reservation['date_reservation']) ?></p>

                <a href="index.php?controller=Reservation&action=deleteReservation&id_reservation=<?= htmlspecialchars($reservation['id_reservation']) ?>">
                    Annuler la réservation
                </a>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="no-reservation">Aucune réservation trouvée.</p>
    <?php endif; ?>
</div>