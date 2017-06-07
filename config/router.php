<?php

use src\Controller\HomeController;
use src\Controller\CupomController;

$rotas = new Klein\Klein();

$rotas->respond('/', function ($request, $response, $service) {
    $pag = new HomeController();
    $pag->index($request, $response, $service);
});

$rotas->respond('POST', '/cadastro', function ($request, $response, $service) {
    $pag = new HomeController();
    $pag->cadastro($request, $response, $service);
});

$rotas->respond('/cupom', function ($request, $response, $service) {
    $pag = new CupomController();
    $pag->index($request, $response, $service);
});

$rotas->respond('/[:name]', function ($request) {
    return 'Hello ' . $request->name;
});

$rotas->dispatch();