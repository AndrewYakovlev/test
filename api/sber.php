<?php

Class Sber {

    public $base_url = 'https://partner.goodsteam.tech/api/market/v1/orderService/';
    public $token;
    public $sberId;

    public function __construct($token, $sberId){
        $this->token = $token;
        $this->sberId = $sberId;
    }

    public function getOrders(){
        var_dump($this->token);
        $path = 'order/search';

        $request = new stdClass;
        $request->data = new stdClass;
        $request->data->token = $this->token;
        $request->meta = new stdClass;


        $params  = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($request),
            ]
        ];

        $context = stream_context_create($params);

        $response = file_get_contents($this->base_url.$path, false, $context);

       // $response = json_decode($response);

        var_dump($response);
    }

    public function getOrder($id){

    }
}