<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nuevo mensaje de contacto desde The Cake')
                    ->view('emails.contact-form')
                    ->with([
                        'name' => $this->contactData['name'],
                        'email' => $this->contactData['email'],
                        'phone' => $this->contactData['phone'],
                        'rating' => $this->getRatingText($this->contactData['rating']),
                        'messageText' => $this->contactData['message'],
                    ]);
    }

    private function getRatingText($rating)
    {
        switch ($rating) {
            case '1': return 'Calificación';
            case '2': return 'Malo';
            case '3': return 'Regular';
            case '4': return 'Excelente';
            default: return 'No especificado';
        }
    }
}