<?php
/**
 * Created by PhpStorm.
 * User: lloyd
 * Date: 8/23/17
 * Time: 12:57 PM
 */

namespace NotificationsClientBundle\Model;


class NotificationMessages
{
    const STATUS_NEW = 0;
    const STATUS_SEEN = 1;
    const STATUS_CLEAR = 2;

    private $clientUserId;
    private $messageKey;
    private $message;
    private $notificationType;

    public function __construct(string $clientUserId, string $messageKey, string $message, string $notificationType)
    {
        $this->clientUserId = $clientUserId;
        $this->notificationType = $notificationType;
        $this->message = $message;
        $this->messageKey = $messageKey;
    }

    public function getClientUserId()
    {
        return $this->clientUserId;
    }

    public function getNotificationType()
    {
        return $this->notificationType;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getMessageKey()
    {
        return $this->messageKey;
    }
}