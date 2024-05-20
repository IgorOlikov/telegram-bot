<?php

namespace App\Http\Controllers;

use App\Database\Database;


class BaseController
{

    public function __construct
    (
        public Database $database
    )
    {


    }

}