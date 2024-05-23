<?php

namespace App\Http\Controllers;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MainController extends BaseController
{


    public function index(Request $request, Response $response): Response
    {

        $database = $this->database;

        $pdo = $database->getPdo();


        //dd($_SERVER);

        $name = (int)133;

        $age = 22;


        $sql = 'insert into test (name, age) values (:name, :age)';

        $stm = $pdo->prepare($sql);


        $stm->bindValue(':name', $name, PDO::PARAM_STR);
        $stm->bindValue(':age', $age, PDO::PARAM_INT);

        //$stm->bindParam()



        $stm->execute();



        $pid = $pdo->pgsqlGetPid();

        $response->getBody()->write('hello' . $pid);

        return $response;

    }


}