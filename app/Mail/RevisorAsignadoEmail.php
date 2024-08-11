<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RevisorAsignadoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $titulo;
    public $revista;
    public $modalidad;

    /**
     * Create a new message instance.
     */
    public function __construct($titulo, $revista, $modalidad)
    {
        $this->titulo = $titulo;
        $this->revista = $revista;
        $this->modalidad = $modalidad;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('sistemaingeco@gmail.com', 'AppIngeco'),
            subject: 'Asignación de Artículo para Revisión',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'envio_email.revisor_asignado',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
