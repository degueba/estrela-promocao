<?php

namespace src\Controller;


class BaseController{

    public function render($arquivo, $container = null){
        require PATH_TEMPLATES.$arquivo.'.php';
        exit();
    }

    public function json($container){
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($container);
        exit();
    }

    public function redirect($router){
        header("Location: ".$router);
        exit();
    }
}