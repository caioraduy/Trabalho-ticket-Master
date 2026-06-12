<h2>Editar avaliacao</h2>

<form action="?p=review-atualizar" method="post">
    <input type="hidden" name="id" value="<?= $avaliacao->id ?>">

    Nota:
    <select name="rating">
        <option value="5" <?= $avaliacao->rating == 5 ? "selected" : "" ?>>5</option>
        <option value="4" <?= $avaliacao->rating == 4 ? "selected" : "" ?>>4</option>
        <option value="3" <?= $avaliacao->rating == 3 ? "selected" : "" ?>>3</option>
        <option value="2" <?= $avaliacao->rating == 2 ? "selected" : "" ?>>2</option>
        <option value="1" <?= $avaliacao->rating == 1 ? "selected" : "" ?>>1</option>
    </select>

    <br><br>

    Comentario:<br>
    <textarea name="comment" cols="50" rows="5"><?= $avaliacao->comment ?></textarea>

    <br><br>

    <input type="submit" value="Salvar">
</form>

<br>

<a href="?p=movie-show&id=<?= $avaliacao->movie_id ?>">Voltar</a>
