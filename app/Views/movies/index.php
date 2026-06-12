<h2>Filmes</h2>

<form action="" method="get">
    <input type="hidden" name="p" value="movies">
    Buscar: <input type="text" name="busca" value="<?= $busca ?? '' ?>">
    <input type="submit" value="Pesquisar">
</form>

<hr>

<h3><?= isset($filme) ? "Editar filme" : "Novo filme" ?></h3>

<form action="<?= isset($filme) ? '?p=movie-atualizar' : '?p=movie-salvar' ?>" method="post">
    <?php if(isset($filme)){ ?>
        <input type="hidden" name="id" value="<?= $filme->id ?>">
    <?php } ?>

    Titulo: <input type="text" name="title" value="<?= $filme->title ?? '' ?>"><br><br>
    Genero: <input type="text" name="genre" value="<?= $filme->genre ?? '' ?>"><br><br>
    Duracao: <input type="number" name="duration_min" value="<?= $filme->duration_min ?? '' ?>"><br><br>
    Poster: <input type="text" name="poster_url" value="<?= $filme->poster_url ?? '' ?>"><br><br>
    Descricao:<br>
    <textarea name="description" cols="50" rows="5"><?= $filme->description ?? '' ?></textarea><br><br>

    <input type="submit" value="Salvar">
</form>

<hr>

<?php

if(empty($filmes)){
    echo "Nenhum filme cadastrado";
}else{

    foreach($filmes as $obj){
        echo "<h3>$obj->title</h3>";
        echo "<p>Genero: $obj->genre</p>";
        echo "<p>Duracao: $obj->duration_min minutos</p>";

        if(!empty($obj->poster_url)){
            echo "<img src='$obj->poster_url' width='120'>";
        }

        echo "<br>";
        echo "[ <a href='?p=movie-show&id=$obj->id'>VER</a> ] ";
        echo "[ <a href='?p=movie-editar&id=$obj->id'>EDITAR</a> ] ";
        echo "[ <a href='?p=movie-apagar&id=$obj->id'>REMOVER</a> ]";
        echo "<hr>";
    }

}

?>
