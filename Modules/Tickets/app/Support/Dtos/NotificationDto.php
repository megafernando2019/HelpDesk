<?php
namespace Modules\Tickets\Support\Dtos;

class NotificationDto
{
    public function __construct(
        public int $id,
        public int $ticketId,
        public int $ticket_action_id,
        public string $title,
        public string $ticketUrl,
        public string $matched,
        public string $description,
        public string $createdAt,
        public ?string $readAt,
        public string $icon,
        public string $bgColor,
        public string $badgeClass
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticketId,
            'ticket_action_id' => $this->ticket_action_id,
            'title' => $this->title,
            'ticketUrl' => $this->ticketUrl,
            'matched' => $this->matched,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'read_at' => $this->readAt,
            'icon' => $this->icon,
            'bg_color' => $this->bgColor,
            'badge_class' => $this->badgeClass,
        ];
    }
}