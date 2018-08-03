<?php

namespace App\Listeners;

use App\Events\Register;
use Illuminate\Support\Facades\Mail;

class SendMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Register $sendMail)
    {
        //
        $result = ['status' => true];
        $to = $sendMail->to;
        $title = '123';
        $view = 'index';
        $viewData = [];
        $bcc = false;

        $swiftMailer = Mail::getSwiftMailer();
        $transport = $swiftMailer->getTransport();
        $transport->setTimeout(config('mail.connect_timeout'));
        $result = Mail::send($view, $viewData, function ($m) use ($to, $title, $bcc) {
            $bcc && $m->bcc($bcc);
            $m->to($to)->subject($title);
        });
        if ($list = Mail::failures()) {
            $result['status'] = false;
            $result['list'] = $list;
        }
        return $result;
    }
}
