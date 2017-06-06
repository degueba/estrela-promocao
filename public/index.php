<?php
require '../config/config.php';

use src\Helper\Original;


$klein = new Klein\Klein();

use src\Controller\Home;
$klein->respond('/', function ($request, $response, $service) {
    $pag = new Home();
    $pag->index($request, $response, $service);
});

$klein->respond('/[:name]', function ($request) {
    return 'Hello ' . $request->name;
});

$klein->dispatch();
