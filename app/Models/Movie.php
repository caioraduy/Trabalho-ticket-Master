<?php

class Movie {

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

    public static function listar($busca = null){

        $banco = self::conectar();

        if(!is_null($busca) && !empty($busca)){
            $busca = $banco->real_escape_string($busca);
            $resp = $banco->query("SELECT * FROM movies
                                    WHERE title LIKE '%$busca%'
                                       OR genre LIKE '%$busca%'
                                    ORDER BY id DESC");
        }else{
            $resp = $banco->query("SELECT * FROM movies ORDER BY id DESC");
        }

        $filmes = [];

        while($obj = $resp->fetch_object()){
            $filmes[] = $obj;
        }

        return $filmes;
    }

    public static function buscarPorId($id){

        $banco = self::conectar();
        $id = (int) $id;

        $resp = $banco->query("SELECT * FROM movies WHERE id='$id'");

        if($resp->num_rows <= 0){
            return null;
        }

        return $resp->fetch_object();
    }

    public static function salvar($titulo, $descricao, $genero, $duracao, $poster){

        $banco = self::conectar();

        $titulo = $banco->real_escape_string($titulo);
        $descricao = $banco->real_escape_string($descricao);
        $genero = $banco->real_escape_string($genero);
        $duracao = (int) $duracao;
        $poster = $banco->real_escape_string($poster);

        $banco->query("INSERT INTO movies (id, title, description, genre, duration_min, poster_url)
                        VALUES (NULL, '$titulo', '$descricao', '$genero', '$duracao', '$poster')");
    }

    public static function atualizar($id, $titulo, $descricao, $genero, $duracao, $poster){

        $banco = self::conectar();

        $id = (int) $id;
        $titulo = $banco->real_escape_string($titulo);
        $descricao = $banco->real_escape_string($descricao);
        $genero = $banco->real_escape_string($genero);
        $duracao = (int) $duracao;
        $poster = $banco->real_escape_string($poster);

        $banco->query("UPDATE movies SET
                            title='$titulo',
                            description='$descricao',
                            genre='$genero',
                            duration_min='$duracao',
                            poster_url='$poster'
                        WHERE id='$id'");
    }

    public static function apagar($id){

        $banco = self::conectar();
        $id = (int) $id;

        $banco->query("DELETE FROM movies WHERE id='$id'");
    }

}

?>
