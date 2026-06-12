<?php

require_once __DIR__ . "/../Models/Movie.php";
require_once __DIR__ . "/../Models/Review.php";

class MovieController {

    public static function index(){

        $busca = $_GET['busca'] ?? null;
        $filmes = Movie::listar($busca);

        require __DIR__ . "/../Views/movies/index.php";
    }

    public static function show(){

        $id = $_GET['id'] ?? null;

        if(is_null($id)){
            echo "Filme nao encontrado";
            return;
        }

        $filme = Movie::buscarPorId($id);

        if(is_null($filme)){
            echo "Filme nao encontrado";
            return;
        }

        $avaliacoes = Review::listarPorFilme($id);
        $media = Review::mediaPorFilme($id);

        require __DIR__ . "/../Views/movies/show.php";
    }

    public static function salvar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $titulo = $_POST['title'] ?? null;
            $descricao = $_POST['description'] ?? null;
            $genero = $_POST['genre'] ?? null;
            $duracao = $_POST['duration_min'] ?? null;
            $poster = $_POST['poster_url'] ?? null;

            if(!is_null($titulo) && !empty($titulo)){
                Movie::salvar($titulo, $descricao, $genero, $duracao, $poster);
            }
        }

        header("Location: ?p=movies");
    }

    public static function editar(){

        $id = $_GET['id'] ?? null;

        if(is_null($id)){
            header("Location: ?p=movies");
            return;
        }

        $filme = Movie::buscarPorId($id);
        $filmes = Movie::listar();

        require __DIR__ . "/../Views/movies/index.php";
    }

    public static function atualizar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $id = $_POST['id'] ?? null;
            $titulo = $_POST['title'] ?? null;
            $descricao = $_POST['description'] ?? null;
            $genero = $_POST['genre'] ?? null;
            $duracao = $_POST['duration_min'] ?? null;
            $poster = $_POST['poster_url'] ?? null;

            if(!is_null($id) && !is_null($titulo) && !empty($titulo)){
                Movie::atualizar($id, $titulo, $descricao, $genero, $duracao, $poster);
            }
        }

        header("Location: ?p=movies");
    }

    public static function apagar(){

        $id = $_GET['id'] ?? null;

        if(!is_null($id)){
            Movie::apagar($id);
        }

        header("Location: ?p=movies");
    }

}

?>
