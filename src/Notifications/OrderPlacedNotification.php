<?php

namespace Danial\SimpleMarketplace\Notifications;

use Danial\SimpleMarketplace\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Order $order)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->greeting('Hello Admin!')
            ->line('A new order has been created.')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total Price: ' . $this->order->total_price);
    }

}
