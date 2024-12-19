<form action="index.php?controller=Login&action=connexion" method="post">
    <div>
        <label for="mail" placeholder="saucisse@gmail.com">Mail :</label>
        <input type="mail" id="mail" name="mail" required>
    </div>
    <div>
        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required>
    </div>
    <div>
        <button type="submit">Se connecter</button>
    </div>
    <div>
        <a href="index.php?controller=Login&action=inscription">Je n'ai pas de compte</a>
    </div>
</form>