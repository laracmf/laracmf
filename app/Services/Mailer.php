<?php

namespace App\Services;

/**
 * Class Mailer
 * @package App\Services
 */
class Mailer extends \Illuminate\Mail\Mailer
{
    /**
     * Create message action.
     *
     * @return \Illuminate\Mail\Message
     */
    protected function createMessage()
    {
        $message = parent::createMessage();

        $headers = json_decode(config('mail.headers', '[]'), true);

        foreach ($headers as $name => $value) {
            $message->getSwiftMessage()->getHeaders()->addTextHeader($name, $value);
        }

        return $message;
    }
}
