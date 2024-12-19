<?php if ($evenement): ?>
    <div id="containerEvenement">
        <div class="showEvenement">
            <h1><?= htmlspecialchars($evenement->nom) ?></h1>
            <p><strong>Description :</strong> <?= htmlspecialchars($evenement->description) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($evenement->date) ?></p>
            <p><strong>Heure :</strong> <?= htmlspecialchars($evenement->heure) ?></p>
            <p><strong>Places disponibles :</strong> <?= htmlspecialchars($evenement->place) ?></p>
            <img src="<?= htmlspecialchars($evenement->photo) ?>" alt="Image de l'événement">

            <a href="index.php?controller=Reservation&action=addReservation&id_evenement=<?= htmlspecialchars($evenement->id_evenement) ?>">Je veux ma place!</a>
        </div>

        <!-- Section Commentaires -->

        <section id="commentaires">
            <h2>Commentaires</h2>

            <?php if (!empty($commentaires)): ?>
                <?php foreach ($commentaires as $commentaire): ?>
                    <div class="commentaire">
                        <div class="commentaire-header">
                            <p class="commentaire-nom">
                                <strong><?= htmlspecialchars($commentaire->getPrenom() . ' ' . $commentaire->getNom()) ?></strong>
                            </p>
                            <p class="commentaire-date">
                                <?= htmlspecialchars($commentaire->getDate_commentaire()) ?>
                            </p>
                        </div>

                        <p class="commentaire-message"><?= nl2br(htmlspecialchars($commentaire->getMessage())) ?></p>

                        <!-- Vérifie si le commentaire appartient à l'utilisateur connecté (et s'il y'a une session active) -->
                        <!-- L'admin peut modifier et supprimer tous les commentaires -->
                        <?php if (isset($_SESSION['id_user']) && ((($_SESSION['id_user'] == $commentaire->getId_user()) || $_SESSION['statut'] == "admin"))): ?>
                            <div class="commentaire-actions">
                                <a href="index.php?controller=Commentaire&action=displayUpdate&id_commentaire=<?= htmlspecialchars($commentaire->getId_commentaire()) ?>&id_evenement=<?= htmlspecialchars($evenement->id_evenement)  ?>" class="modifier-commentaire">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>




                                </a>
                                <a href="index.php?controller=Commentaire&action=deleteCommentaire&id_commentaire=<?= htmlspecialchars($commentaire->getId_commentaire()) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')" class="supprimer-commentaire">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-comment">Aucun commentaire pour cet événement.</p>
            <?php endif; ?>

            <!-- Formulaire d'ajout de commentaire -->
            <form action="index.php?controller=Commentaire&action=addCommentaire" method="POST" id="form-ajout-commentaire">
                <textarea name="message" placeholder="Laissez votre commentaire..." required></textarea>
                <input type="hidden" name="id_evenement" value="<?= htmlspecialchars($evenement->id_evenement) ?>">
                <button type="submit">Envoyer</button>
            </form>
        </section>

    <?php else: ?>
        <p>Événement non trouvé.</p>
    <?php endif; ?>
    </div>