<?php
require 'vendor/autoload.php';

require 'config/config.php';

use src\Helper\DB;

$DB = DB::getInstance();

$DB->query("TRUNCATE TABLE cupom;");

for($x=1; $x<=2; $x++){
    for($y=1; $y<=9999; $y++){
        $cupom = [];
        $cupom['serie'] = $x;
        $cupom['numero'] = str_pad($y, 5, "0", STR_PAD_LEFT);;
        $DB->insert('cupom', $cupom);
    }
}