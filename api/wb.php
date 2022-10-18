<?php

class Wb {

    public $token;
    public $base_url = 'https://suppliers-api.wildberries.ru/api/v2/';

    public function __construct($token){
        $this->token = $token;
    }

    public function getInfo(){
        $url = 'https://suppliers-api.wildberries.ru/public/api/v1/info';
        $params = [
            'http' => [
                'method' => 'GET',
                'header' => 'Authorization: '.$this->token,
            ]
        ];
        $query = [];

        $context = stream_context_create($params);
        $response = file_get_contents(
            $url.'?'.http_build_query($query), 
            false, 
            $context);
        var_dump(json_decode($response));
        return json_decode($response);
    }

    public function getStocks(){
        $path = 'stocks';
        $params = [
            'http' => [
                'method' => 'GET',
                'header' => 'Authorization: '.$this->token,
            ]
        ];

        $query = [
            'skip' => 0,
            'take' => 100
        ];
        
        $context = stream_context_create($params);
        //ON_DELIVERY / ACTIVE
        $response = file_get_contents(
            $this->base_url.$path.'?'.http_build_query($query), 
            false, 
            $context);
        var_dump(json_decode($response));
        return json_decode($response);
    }

    

    public function getSupplies(){
        $path = 'supplies';
        $params = [
            'http' => [
                'method' => 'GET',
                'header' => 'Authorization: '.$this->token,
            ]
        ];
        
        $context = stream_context_create($params);
        //ON_DELIVERY / ACTIVE
        $response = file_get_contents(
            $this->base_url.$path.'?'.http_build_query(['status' => 'ON_DELIVERY']), 
            false, 
            $context);

        return json_decode($response)->supplies;
    }

    public function getSuppliesOrders(){
        $supplies = $this->getSupplies();
        if(is_array($supplies) && count($supplies) > 0){
            foreach($supplies as $supplier){
                
                $path = 'orders';
                $params = [
                    'http' => [
                        'method' => 'GET',
                        'header' => 'Authorization: '.$this->token,
                    ]
                ];
                
                $context = stream_context_create($params);

                $response = file_get_contents(
                    $this->base_url."supplies/{$supplier->supplyId}/".$path, 
                    false, 
                    $context);

                $response = json_decode($response);
                if(isset($response->orders) && count($response->orders) > 0){
                    foreach($response->orders as $order){
                        var_dump($order);
                        $this->getStickers($order->orderId);
                    }
                }

                // var_dump($response);

            }
        }
    }

    public function getStickers($id){
        $url = 'https://suppliers-api.wildberries.ru/api/v2/orders/stickers/pdf';
        $orderIds = [
            'orderIds' => [(int)$id]
        ];
        $params = [
            'http' => [
                'method' => 'POST',
                'header' => 'Authorization: '.$this->token. PHP_EOL .
                            'Content-Type: application/json',
                'content' => json_encode($orderIds),
            ]
        ];
        
        $context = stream_context_create($params);

        $response = file_get_contents(
            $url, 
            false, 
            $context);

        $response = json_decode($response);
        if(!$response->error){
            file_put_contents('./files/stickers/wb/'.$id.'.pdf', base64_decode($response->data->file));
        }

        var_dump($response);
    }
}
