<?php

require_once __DIR__ . "/../Models/Review.php";

class ReviewController {

    public static function salvar(){

        session_start();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $idUsuario = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 1;
            $idFilme = $_POST['movie_id'] ?? null;
            $nota = $_POST['rating'] ?? null;
            $comentario = $_POST['comment'] ?? null;

            if(!is_null($idFilme) && !is_null($nota)){
                Review::salvar($idUsuario, $idFilme, $nota, $comentario);
                header("Location: ?p=movie-show&id=$idFilme");
                return;
            }
        }

        header("Location: ?p=movies");
    }

    public static function form(){

        session_start();

        $id = $_GET['id'] ?? null;
        $idUsuario = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 1;

        if(is_null($id)){
            header("Location: ?p=movies");
            return;
        }

        $avaliacao = Review::buscarPorId($id);

        if(is_null($avaliacao) || $avaliacao->user_id != $idUsuario){
            echo "Avaliacao nao encontrada";
            return;
        }

        require __DIR__ . "/../Views/reviews/form.php";
    }

    public static function atualizar(){

        session_start();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $idUsuario = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 1;
            $id = $_POST['id'] ?? null;
            $nota = $_POST['rating'] ?? null;
            $comentario = $_POST['comment'] ?? null;

            $avaliacao = Review::buscarPorId($id);

            if(!is_null($avaliacao) && $avaliacao->user_id == $idUsuario){
                Review::atualizar($id, $nota, $comentario);
                header("Location: ?p=movie-show&id=$avaliacao->movie_id");
                return;
            }
        }

        header("Location: ?p=movies");
    }

    public static function apagar(){

        session_start();

        $id = $_GET['id'] ?? null;
        $idUsuario = $_SESSION['id'] ?? $_SESSION['user_id'] ?? 1;

        $avaliacao = Review::buscarPorId($id);

        if(!is_null($avaliacao) && $avaliacao->user_id == $idUsuario){
            Review::apagar($id);
            header("Location: ?p=movie-show&id=$avaliacao->movie_id");
            return;
        }

        header("Location: ?p=movies");
    }

}

?>
