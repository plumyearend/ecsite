<?php

namespace App\Mail\SignUp;

use App\Models\TmpRegistrationUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TmpRegistrationUser $tmpRegistrationUser)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'メールアドレスのご確認'
        );
    }

    public function content(): Content
    {
        // TODO: トークン含めたURLを生成
        // $url = route()
        $url = url("/");
        return new Content(
            text: 'mail.signup.email-confirmation',
            with: [
                'url' => $url,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
