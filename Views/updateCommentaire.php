<form action="index.php?controller=Commentaire&action=updateCommentaire" method="POST">
    <textarea name="message" placeholder="Modifiez votre commentaire..." required><?= htmlspecialchars($commentaire->getMessage()) ?></textarea>
    <input type="hidden" name="id_commentaire" value="<?= htmlspecialchars($_GET['id_commentaire']) ?>">
    <input type="hidden" name="id_evenement" value="<?= htmlspecialchars($evenement->id_evenement) ?>">
    <button type="submit">Mettre à jour</button>
</form>