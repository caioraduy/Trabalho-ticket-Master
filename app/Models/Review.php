<?php

class Review {

    private static function conectar(){

        $config = require __DIR__ . "/../../config/database.php";

        $banco = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['dbname']
        );

        if($banco->connect_error){
            die("Erro na conexao: " . $banco->connect_error);
        }

        $banco->set_charset($config['charset']);

        return $banco;
    }

    public static function listarPorFilme($idFilme){

        $banco = self::conectar();
        $idFilme = (int) $idFilme;

        $resp = $banco->query("SELECT reviews.*, users.name AS nome_usuario
                                FROM reviews
                                INNER JOIN users ON users.id = reviews.user_id
                                WHERE reviews.movie_id='$idFilme'
                                ORDER BY reviews.id DESC");

        $avaliacoes = [];

        while($obj = $resp->fetch_object()){
            $avaliacoes[] = $obj;
        }

        return $avaliacoes;
    }

    public static function buscarPorId($id){

        $banco = self::conectar();
        $id = (int) $id;

        $resp = $banco->query("SELECT * FROM reviews WHERE id='$id'");

        if($resp->num_rows <= 0){
            return null;
        }

        return $resp->fetch_object();
    }

    public static function salvar($idUsuario, $idFilme, $nota, $comentario){

        $banco = self::conectar();

        $idUsuario = (int) $idUsuario;
        $idFilme = (int) $idFilme;
        $nota = (int) $nota;
        $comentario = $banco->real_escape_string($comentario);

        if($nota < 1){
            $nota = 1;
        }

        if($nota > 5){
            $nota = 5;
        }

        $banco->query("INSERT INTO reviews (id, user_id, movie_id, rating, comment)
                        VALUES (NULL, '$idUsuario', '$idFilme', '$nota', '$comentario')");
    }

    public static function atualizar($id, $nota, $comentario){

        $banco = self::conectar();

        $id = (int) $id;
        $nota = (int) $nota;
        $comentario = $banco->real_escape_string($comentario);

        if($nota < 1){
            $nota = 1;
        }

        if($nota > 5){
            $nota = 5;
        }

        $banco->query("UPDATE reviews SET
                            rating='$nota',
                            comment='$comentario'
                        WHERE id='$id'");
    }

    public static function apagar($id){

        $banco = self::conectar();
        $id = (int) $id;

        $banco->query("DELETE FROM reviews WHERE id='$id'");
    }

    public static function mediaPorFilme($idFilme){

        $banco = self::conectar();
        $idFilme = (int) $idFilme;

        $resp = $banco->query("SELECT AVG(rating) AS media FROM reviews WHERE movie_id='$idFilme'");
        $obj = $resp->fetch_object();

        return $obj->media;
    }

}

?>
