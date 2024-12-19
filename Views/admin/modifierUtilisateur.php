<h1>Modifier l'utilisateur <?php echo $utilisateur->prenom . " " . $utilisateur->nom; ?></h1>

<form method="POST" action="index.php?controller=Admin&action=saveModificationUtilisateur&id=<?php echo $utilisateur->id_user; ?>">
    <label for="nom">Nom: </label><input type="text" name="nom" value="<?php echo $utilisateur->nom; ?>" disabled><br>
    <label for="prenom">Prénom: </label><input type="text" name="prenom" value="<?php echo $utilisateur->prenom; ?>" disabled><br>
    <label for="statut">Statut: </label><input type="text" name="statut" value="<?php echo $utilisateur->statut; ?>" required><br>
    <input type="submit" value="Modifier">
</form>