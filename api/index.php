<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-type: application/json; charset=utf-8');

require_once('../db/Medoo.php');
require_once('../api/wb.php');
require_once('../api/ozon.php');
require_once('../api/ym.php');
require_once('../api/sber.php');

use Medoo\Medoo;

class API {

    public $db;

    public function __construct(){
        $this->db = new Medoo([
            'type' => 'mysql',
            'host' => 'localhost',
            'database' => 'marketplaces',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'port' => 8889,
        ]);
    }

    public function createPlace($type = '', $data){
        $place = [];
        if($type == 'wb'){

        }
        if($type == 'ym'){

        }

        if($type == 'sber'){

        }

        if($type == 'ozon'){

        }
    }

    public function createAccount($data){
        $this->db->insert('accounts', [
            'name' => $data->name,
            'active' => $data->active,
            'token' => $data->token,
            'partner_id' => $data->partner_id
        ]);

        echo json_encode(
            [
                'status' => 'ok',
                'id' => $this->db->id()
            ]
            
        );
    }

    public function getAccounts(){
        $accounts = $this->db->select('accounts', '*');
        echo json_encode($accounts);
    }

    public function wb()
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6ImY3ZTY5ZWQwLWNmNWEtNDdhYy1hMWIwLTQwMDg2ZDE5MjhiNiJ9.baZpSj-jI0RsSrLowSfrv_kpxTygtLIrqFj6fj2tauE';
        $wb = new Wb($token);
        $wb->getSuppliesOrders();
        //$wb->getStocks();
        //$wb->getInfo();
    }

    public function ozon()
    {
        $token = 'fed92aec-9e91-44a5-a89f-7746aa5db04c';
        $clientId = '85472';
        $ozon = new Ozon($token, $clientId);
        $ozon->getOrders();

    }

    public function ym()
    {
        $token = '38000001A483957B';
        $clientId = '45813d304d4442f2b1f754aea38a56c1';
        $clientSecret = '83f3b56d69c3493ab31d80bbec007951';
        $campaignId = '21643033';
        $ym = new Ym($clientId, $token, $campaignId);
        $ym->getOrders();
    }

    public function sber()
    {
        $token = '56655010-BAA7-4C30-9C82-15C20251D8AE';
        $id = '6079';

        $sber = new Sber($token, $id);
        $sber->getOrders();
    }
}

$api = new API();
//$api->sber();

if($_GET['method'] == 'create' && $_GET['type'] == 'wb'){
    $api->createPlace('wb', $_POST);
}

if($_GET['method'] == 'create' && $_GET['type'] == 'ym'){
    $api->createPlace('ym', $_POST);
}

if($_GET['method'] == 'create' && $_GET['type'] == 'ozon'){
    $api->createPlace('ozon', $_POST);
}

if($_GET['method'] == 'create' && $_GET['type'] == 'sber'){
    $api->createPlace('sber', $_POST);
}

if($_GET['method'] == 'create' && $_GET['type'] == 'dg'){
    $input = json_decode(file_get_contents("php://input"));
    $api->createAccount($input);
}

if($_GET['method'] == 'get' && $_GET['type'] == 'accounts'){
    $api->getAccounts();
}
