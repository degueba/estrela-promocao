<?php

namespace src\Controller;

use src\Model\Usuario;

class Home extends BaseController {

    public function index($request, $response, $service)
    {
        if($request->method() == 'POST'){
            echo 'OK';
        }
        $this->render('home');
    }

}