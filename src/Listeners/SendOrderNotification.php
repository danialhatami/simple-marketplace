<?php

namespace Danial\SimpleMarketplace\Listeners;

use Danial\SimpleMarketplace\Events\OrderCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Danial\SimpleMarketplace\Notifications\OrderPlacedNotification;

class SendOrderNotification implements ShouldQueue
{
    public string $queue = 'default';

    public function handle(OrderCreated $event): void
    {
        if (config('marketplace.send_real_email_notification')) {
            Notification::route('mail', config('marketplace.admin_email'))
                ->notify(new OrderPlacedNotification($event->order));
        } else {
            \Log::info('Email Sent');
        }
    }
}
