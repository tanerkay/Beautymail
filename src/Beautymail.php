<?php

namespace Snowfire\Beautymail;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\PendingMail;

class Beautymail implements Mailer
{
    /**
     * Contains settings for emails processed by Beautymail.
     */
    private array $settings;

    private Mailer $mailer;

    /**
     * Initialise the settings and mailer.
     */
    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
        $this->mailer = app(Mailer::class);
        $this->setLogoPath();
    }

    public function to($users): PendingMail
    {
        return (new PendingMail($this))->to($users);
    }

    public function bcc($users): PendingMail
    {
        return (new PendingMail($this))->bcc($users);
    }

    public function cc($users): PendingMail
    {
        return (new PendingMail($this))->cc($users);
    }

    /**
     * Retrieve the settings.
     */
    public function getData(): array
    {
        return $this->settings;
    }

    public function getMailer(): Mailer
    {
        return $this->mailer;
    }

    /**
     * Send a new message using a view.
     *
     * @param Mailable|string|array $view
     * @param array $data
     * @param \Closure|string $callback
     *
     * @return void
     */
    public function send($view, array $data = [], $callback = null): void
    {
        $data = array_merge($this->settings, $data);

        $this->mailer->send($view, $data, $callback);
    }

    /**
     * Send a new message using the a view via queue.
     *
     * @param Mailable|string|array $view
     * @param array $data
     * @param \Closure|string $callback
     *
     * @return void
     */
    public function queue($view, array $data, $callback)
    {
        $data = array_merge($this->settings, $data);

        $this->mailer->queue($view, $data, $callback);
    }

    /**
     * @param $view
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public function view($view, array $data = [])
    {
        $data = array_merge($this->settings, $data);

        return view($view, $data);
    }

    /**
     * Send a new message when only a raw text part.
     *
     * @param string $text
     * @param mixed  $callback
     *
     * @return void
     */
    public function raw($text, $callback)
    {
        return $this->mailer->send(['raw' => $text], [], $callback);
    }

    /**
     * Get the array of failed recipients.
     *
     * @return array
     */
    public function failures()
    {
        return $this->mailer->failures();
    }

    /**
     * @return mixed
     */
    private function setLogoPath()
    {
        $this->settings['logo']['path'] = str_replace(
            '%PUBLIC%',
            \Request::getSchemeAndHttpHost(),
            $this->settings['logo']['path']
        );
    }
}
