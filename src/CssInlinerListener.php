<?php

namespace Snowfire\Beautymail;

use Illuminate\Mail\Events\MessageSending;
use Pelago\Emogrifier\CssInliner;
use Symfony\Component\CssSelector\Exception\ParseException;
use Symfony\Component\Mime\Part\TextPart;

class CssInlinerListener
{
    /**
     * Inline the CSS before an email is sent.
     *
     * @throws ParseException
     */
    public function handle(MessageSending $event): void
    {
        $message = $event->message;

        // TODO check for these mime types? and apply inliner to all parts of a multi-part message?
        /*$properTypes = [
            'text/html',
            'multipart/alternative',
            'multipart/mixed',
        ];*/

        if ($message->getHtmlBody()) {
            $text = CssInliner::fromHtml($message->getHtmlBody())->inlineCss()->render();
            $message->setBody(new TextPart($text, subtype: 'html'));
        }
    }
}
