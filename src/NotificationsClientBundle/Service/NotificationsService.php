<?php

namespace NotificationsClientBundle\Service;

use GuzzleHttp;


class NotificationsService
{
    private $server_address;
    private $user_name;
    private $api_key;

    public function __construct($server_address, $user_name, $api_key)
    {
        $this->server_address = $server_address;
        $this->user_name = $user_name;
        $this->api_key = $api_key;
    }

    public function notify(string $client_user_id, string $message_key, string $message, string $notification_type)
    {
        $client = new GuzzleHttp\Client();

        $body = [
            'user_name'=>$this->user_name,
            'api_key'=>$this->api_key,
            'client_user_id'=>$client_user_id,
            'message_key'=>$message_key,
            'message'=>$message,
            'notification_type'=>$notification_type
            ];

        try {
            $client->post($this->server_address . "/notifications/notify", [
                'Content-Type'=>'application/json',
                'form_params' => $body
            ]);
        }
        catch(\Exception $e)
        {
            dump($e->getMessage());
        }

    }

    public function getMessages(string $status, string $client_user_id)
    {
        $client = new GuzzleHttp\Client();

        $res = $client->get($this->server_address."/notifications/retrieve", [
            'query'=>['user_name'=>$this->user_name, 'api_key'=>$this->api_key, 'status_id'=>$status, 'client_user_id'=>$client_user_id]
        ]);

        $returnVal =  json_decode($res->getBody()->getContents());
        return $returnVal->data;
    }

    public function getMessageCount(string $status, string $client_user_id)
    {
        $client = new GuzzleHttp\Client();

        $res = $client->get($this->server_address."/notifications/message_count", [
            'query'=>['user_name'=>$this->user_name, 'api_key'=>$this->api_key, 'status_id'=>$status, 'client_user_id'=>$client_user_id]
        ]);

        $returnVal =  json_decode($res->getBody()->getContents());
        return $returnVal->data;
    }

    public function getMessageById(int $id)
    {
        $client = new GuzzleHttp\Client();

        $res = $client->get($this->server_address."/notifications/get_message", [
            'query'=>['user_name'=>$this->user_name, 'api_key'=>$this->api_key, 'message_id'=>$id]
        ]);

        $returnVal =  json_decode($res->getBody()->getContents());
        return $returnVal->data;
    }

    public function clearMessage(string $client_user_id, string $message_key)
    {
        $client = new GuzzleHttp\Client();

        $body = [
            'user_name'=>$this->user_name,
            'api_key'=>$this->api_key,
            'client_user_id'=>$client_user_id,
            'message_key'=>$message_key
        ];

        try {
            $client->post($this->server_address."/notifications/clear", [
                'Content-Type'=>'application/json',
                'form_params' => $body
            ]);
        }
        catch(\Exception $e)
        {
            dump($e->getMessage());
        }
    }

    public function clearMessageById(int $message_id)
    {
        $client = new GuzzleHttp\Client();

        $body = [
            'user_name'=>$this->user_name,
            'api_key'=>$this->api_key,
            'message_id'=>$message_id
        ];

        try {
            $client->post($this->server_address."/notifications/clear_by_id", [
                'Content-Type'=>'application/json',
                'form_params' => $body
            ]);
        }
        catch(\Exception $e)
        {
            dump($e->getMessage());
        }
    }

}