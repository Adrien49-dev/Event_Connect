<form action="index.php?controller=Login&action=inscription" method="POST">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
    </div>

    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required>
    </div>

    <div>
        <label for="mail">Email :</label>
        <input type="email" name="mail" id="mail" required>
    </div>

    <div>
        <label for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" required>
    </div>

    <div>

        <input type="hidden" name="statut" id="statut" value="visiteur" readonly>
    </div>

    <button type="submit" name="submit">Créer un compte</button>
</form>

<p>Vous avez déjà un compte ? <a href="index.php?controller=Login&action=connexion">Se connecter</a></p>