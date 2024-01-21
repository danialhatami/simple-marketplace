<?php

namespace Danial\SimpleMarketplace\Listeners;

use Danial\SimpleMarketplace\Events\OrderCreated;
use Illuminate\Support\Facades\Notification;
use Danial\SimpleMarketplace\Notifications\OrderPlacedNotification;

class SendOrderNotification
{
    public function handle(OrderCreated $event): void
    {
        Notification::route('mail', 'admin@example.com')
        ->notify(new OrderPlacedNotification($event->order));
    }
}
