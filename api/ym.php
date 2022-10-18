<?php

class Ym {
    public $clientId;
    public $campaignId;
    public $token;

    public $base_url = 'https://api.partner.market.yandex.ru/';
    
    public function __construct($clientId, $token, $campaignId ){
        $this->campaignId = $campaignId;
        $this->token = $token;
        $this->clientId = $clientId;
        
    }

    public function getOrders(){
        $path = 'v2/campaigns/'.$this->campaignId.'/orders.json';

        $params = [
            'http' => [
                'method' => 'GET',
                'header' => 'Authorization: OAuth oauth_token="'.$this->token.'", oauth_client_id="'.$this->clientId .'"'. PHP_EOL .
                            'Content-Type: application/json',
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