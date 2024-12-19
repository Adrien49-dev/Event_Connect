<h1>Gestion des utilisateurs</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($utilisateurs as $utilisateur): ?>
        <tr>
            <td><?php echo $utilisateur->id_user; ?></td>
            <td><?php echo $utilisateur->nom; ?></td>
            <td><?php echo $utilisateur->prenom; ?></td>
            <td><?php echo $utilisateur->mail; ?></td>
            <td><?php echo $utilisateur->statut; ?></td>
            <td>
                <a href="index.php?controller=Admin&action=modifierUtilisateur&id=<?php echo $utilisateur->id_user; ?>">Modifier</a> |
                <a href="index.php?controller=Admin&action=supprimerUtilisateur&id=<?php echo $utilisateur->id_user; ?>">Supprimer</a>
                
            </td>
        </tr>
    <?php endforeach; ?>
</table>