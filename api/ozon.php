<?php

class Ozon {
    public $token;
    public $clienId;

    public $base_url = 'https://api-seller.ozon.ru';

    public function __construct($token, $clientId){
        $this->token = $token;
        $this->clientId = $clientId;
    }

    public function getProductList(){
        $path  = '/v2/product/list';
    }

    public function getOrders(){

        $path  = '/v3/posting/fbs/list';


        $request = new stdClass;
        $request->dir = 'DESC';
        $request->filter = new stdClass;
        $request->filter->since = "2022-10-01T00:00:00.000Z";
        $request->filter->to = "2022-11-01T23:59:59.000Z";
        $request->limit = 100;
        $request->offset = 0;
        // $request->with = new stdClass;
        // $request->with->analytics_data = true;
        // $request->with->barcodes = true;
        // $request->with->financial_data = true;

        $params = [
            'http' => [
                'method' => 'POST',
                'header' => 'Client-Id: '.$this->clientId. PHP_EOL .
                            'Api-Key: '.$this->token. PHP_EOL .
                            'Content-Type: application/json',
                'content' => json_encode($request),
            ]
        ];

        $context = stream_context_create($params);

        $response = file_get_contents(
            $this->base_url.$path, 
            false, 
            $context);
        $response = json_decode($response);
        var_dump($response);
    }
}