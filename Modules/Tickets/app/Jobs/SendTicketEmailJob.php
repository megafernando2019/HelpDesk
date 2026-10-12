<?php

namespace Modules\Tickets\Jobs;

use App\Models\User;
use App\Traits\HelpDeskUtils;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Tickets\Models\Ticket;

class SendTicketEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HelpDeskUtils;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Ticket $ticket,
        public string $type, // 'assigned', 'observation', 'solved'
        public string $toEmail,
        public ?string $ccEmail = null,
        public ?string $recipientName = null,
        public ?string $userEmail = null,
        public ?string $token = null,
        public ?User $userCreatedTicket = null
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
            try {
                // Asignar asunto dinámico
                $subject = match ($this->type) {
                    'assigned'    => 'Asignación de Ticket - ' . ($this->ticket->uid ?? 'TKT#' . $this->ticket->id),
                    'observation' => 'Nueva observación en Ticket - ' . ($this->ticket->uid ?? 'TKT#' . $this->ticket->id),
                    'solved'      => 'Solución de Ticket - ' . ($this->ticket->uid ?? 'TKT#' . $this->ticket->id),
                    default       => 'Notificación de Ticket',
                };

                // Renderizar el HTML usando la vista Blade
                $htmlBody = view('mails.template', [
                    'ticket'        => $this->ticket,
                    'type'          => $this->type,
                    'recipientName' => $this->recipientName,
                    'userEmail'     => $this->userEmail,
                    'userCreatedTicket' => $this->userCreatedTicket
                ])->render();

                // Preparar payload
                $data = [
                    'to'      => $this->toEmail,
                    'subject' => $subject,
                    'body'    => $htmlBody,
                    'tags'    => ['helpdesk', $this->type],
                    'user'    => 'nexus@megatravel.com.mx', 
                    'cc'      => $this->ccEmail ?? ''
                ];

                // Consumir el microservicio
                $result = $this->send_mail($data, request(), $this->token);

                if (isset($result['success']) && !$result['success']) {
                    \Log::error('Error al enviar correo por Job: ' . json_encode($result));
                }
            } catch (\Throwable $th) {
                \Log::error('Excepción en SendTicketEmailJob: ' . $th->getMessage());
            }
    }
}
