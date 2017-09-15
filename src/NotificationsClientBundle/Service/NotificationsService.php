<?php

namespace NotificationsClientBundle\Service;

use GuzzleHttp;
use NotificationsClientBundle\Model\NotificationMessages;


class NotificationsService
{
    private $server;
    private $user;
    private $apiKey;

    public function __construct(string $server, string $user, string $apiKey)
    {
        $this->server = $server;
        $this->user = $user;
        $this->apiKey = $apiKey;
    }

    public function notify(string $clientUser, string $messageKey, string $message, string $type = NotificationMessages::TYPE_MESSAGE)
    {
        $client = new GuzzleHttp\Client();
        $base = '/notify';
        $url = $this->server . $base . "/" . $clientUser . "/" . $type;

        $body = [
            'user_name'=>$this->user,
            'api_key'=>$this->apiKey,
            'message_key'=>$messageKey,
            'message'=>$message
            ];

        try {
            $client->post($url, [
                'Content-Type'=>'application/json',
                'form_params' => $body
            ]);
        }
        catch(\Exception $e)
        {
            throw new \Exception($e);
        }

    }

    public function getMessages(string $clientUser, int $status = NotificationMessages::STATUS_NEW, string $type = NotificationMessages::TYPE_MESSAGE)
    {
        $client = new GuzzleHttp\Client();
        $base = "/retrieve";
        $url = $this->server . $base . "/" . $clientUser . "/" . $status . "/" . $type;

        $res = $client->get($url, [
            'query'=>[
                'user_name'=>$this->user,
                'api_key'=>$this->apiKey
            ]
        ]);

        $returnVal =  json_decode($res->getBody()->getContents());
        return $returnVal->data;
    }

    public function getMessageCount(string $clientUser, $status = NotificationMessages::STATUS_NEW, string $type = NotificationMessages::TYPE_MESSAGE)
    {
        $client = new GuzzleHttp\Client();
        $base = "/message_count";
        $url = $this->server . $base . "/" . $clientUser . "/" . $status . "/" . $type;

        $res = $client->get($url, [
            'query'=>[
                'user_name'=>$this->user,
                'api_key'=>$this->apiKey
            ]
        ]);

        $returnVal =  json_decode($res->getBody()->getContents());
        return $returnVal->data;
    }

    public function clearMessageById(int $messageId)
    {
        $client = new GuzzleHttp\Client();

        $body = [
            'user_name'=>$this->user,
            'api_key'=>$this->apiKey
        ];

        try {
            $client->post($this->server."/clear/" . $messageId, [
                'Content-Type'=>'application/json',
                'form_params' => $body
            ]);
        }
        catch(\Exception $e)
        {
            throw new \Exception($e);
        }
    }

}
