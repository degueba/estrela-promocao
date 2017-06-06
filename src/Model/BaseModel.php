<?php

namespace src\Model;

use src\Helper\DB;

class BaseModel {

    public $DB = NULL;

    function __construct() {
        $this->DB = DB::getInstance();
    }
}