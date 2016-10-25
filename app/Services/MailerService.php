<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use Illuminate\Support\Facades\Mail;

class MailerService
{
    /**
     * Send message action.
     *
     * @param array $data
     * @return void
     */
    public static function sendMessage($data)
    {
        $headers = json_decode(config('mail.headers', '[]'), true);

        $model = array_get($data, 'data', '');

        try {
            Mail::send($data['template'], ['data' => $model], function ($message) use ($data, $headers) {
                $message->from(env('MAIL_FROM_ADDRESS'), 'Mail!');
                $message->to($data['email'])->subject($data['subject']);

                foreach ($headers as $name => $value) {
                    $message->getSwiftMessage()->getHeaders()->addTextHeader($name, $value);
                }
            });
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());die();
        }
    }
}
