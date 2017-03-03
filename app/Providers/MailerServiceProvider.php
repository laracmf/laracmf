<?php

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider as ServiceProvider;
use App\Services\Mailer;

/**
 * Class MailServiceProvider
 *
 * @package App\Providers
 */
class MailerServiceProvider extends ServiceProvider
{
    /**
     * This is just a copy of method from parent class with a tiny modification of mailer instance.
     *
     * @{@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('mailer', function ($app) {
            $this->registerSwiftMailer();

            $mailer = new Mailer(
                $app['view'],
                $app['swift.mailer'],
                $app['events']
            );

            $this->setMailerDependencies($mailer, $app);

            $from = $app['config']['mail.from'];
            if (is_array($from) && isset($from['address'])) {
                $mailer->alwaysFrom($from['address'], $from['name']);
            }

            return $mailer;
        });
    }
}