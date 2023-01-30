<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{

    use InteractsWithQueue, Queueable, SerializesModels;

    public function fire($e, $payload) {
        $this->onQueue('processing');
        echo "FIRE\n";
        $email = \Config\Services::email();
        $config = [
            'protocol' => getenv('EMAIL_PROTOCOL'),
            'SMTPUser' => getenv('EMAIL_SMTP_USER'),
            'SMTPPass' => getenv('EMAIL_SMTP_PASS'),
            'SMTPHost' => getenv('EMAIL_SMTP_HOST'),
            'SMTPPort' => getenv('EMAIL_SMTP_PORT'),
            'SMTPCrypto' => 'ssl',
            'mailType' => 'html',
        ];
        $email->initialize($config);
        $email->setFrom('email@example.com', 'John Doe');
        $email->setTo($payload['to']);
        $email->setSubject('Hello');
        $email->setMessage('Hello email');
        $email->send();
        
        $e->delete();
    }

}