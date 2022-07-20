<?php

namespace Snowfire\Beautymail\Tests\Feature;

use Illuminate\Log\Events\MessageLogged;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Event;
use Snowfire\Beautymail\Tests\TestCase;
use Snowfire\Beautymail\Beautymail;

class CssInlinerTest extends TestCase
{
    public function testCssInliner(): void
    {
        Event::fake();

        app(Beautymail::class)->send(
            'beautymail::test',
            [
                'logo' => ['width' => '', 'path' => ''],
            ],
            function (Message $message) {
                $message
                    ->from('a@example.com', 'Test Sender')
                    ->to('b@example.com', 'Test Recipient')
                    ->subject('Test email');
            });

        Event::assertDispatched(MessageLogged::class, function (MessageLogged $event) {
            $this->assertStringContainsString('Content-Type: text/html', $event->message);
            $this->assertStringContainsString('Test styled content', $event->message);
            return true;
        });
    }
}
