<div class="contact-container">
    <h2>Contactez-nous</h2>
    <p>Pour toute question, suggestion ou demande d'information, n'hésitez pas à nous contacter via ce formulaire.</p>

    <form id="contactForm" action="index.php?controller=Contact&action=sendMessage" method="POST">
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name"
                <?php
                if (isset($_SESSION['id_user'])) {
                ?>

                value="<?= $_SESSION['nom'] ?>" required>
        <?php
                }
        ?>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom"
                <?php
                if (isset($_SESSION['id_user'])) {
                ?>

                value="<?= $_SESSION['prenom'] ?>" required>
        <?php
                }
        ?>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="votre mail" required>
        </div>

        <div class="form-group">
            <label for="subject">Sujet :</label>
            <input type="text" id="subject" name="subject" placeholder="Sujet de votre message" required>
        </div>

        <div class="form-group">
            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="5" placeholder="Votre message" required></textarea>
        </div>

        <button type="submit" class="btn">Envoyer</button>
    </form>
</div>