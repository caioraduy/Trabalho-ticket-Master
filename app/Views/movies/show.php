<p>
    <a href="?p=movies">Voltar para filmes</a>
</p>

<h2><?= $filme->title ?></h2>

<?php if(!empty($filme->poster_url)){ ?>
    <img src="<?= $filme->poster_url ?>" width="180">
<?php } ?>

<p>Genero: <?= $filme->genre ?></p>
<p>Duracao: <?= $filme->duration_min ?> minutos</p>
<p><?= nl2br($filme->description) ?></p>

<p>
    Media das avaliacoes:
    <?= is_null($media) ? "Sem avaliacoes" : number_format($media, 1, ",", ".") ?>
</p>

<hr>

<h3>Fazer avaliacao</h3>

<form action="?p=review-salvar" method="post">
    <input type="hidden" name="movie_id" value="<?= $filme->id ?>">

    Nota:
    <select name="rating">
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
    </select>

    <br><br>

    Comentario:<br>
    <textarea name="comment" cols="50" rows="5"></textarea>

    <br><br>

    <input type="submit" value="Salvar avaliacao">
</form>

<hr>

<h3>Avaliacoes</h3>

<?php

if(empty($avaliacoes)){
    echo "Nenhuma avaliacao cadastrada";
}else{

    foreach($avaliacoes as $obj){
        echo "<p><strong>$obj->nome_usuario</strong> - Nota: $obj->rating</p>";
        echo "<p>$obj->comment</p>";
        echo "[ <a href='?p=review-form&id=$obj->id'>EDITAR</a> ] ";
        echo "[ <a href='?p=review-apagar&id=$obj->id'>REMOVER</a> ]";
        echo "<hr>";
    }

}

?>
