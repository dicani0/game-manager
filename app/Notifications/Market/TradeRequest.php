<?php

namespace App\Notifications\Market;

use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TradeRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public TradeOffer $offerRequest, public MarketOffer|User $target)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Trade Request')
            ->line("You have received a new trade request from {$this->offerRequest->creator->name }")
            ->action('Check your offers here', url('/market/my'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'You have received a new trade request from '.$this->offerRequest->creator->name,
            'link' => '/market/requests',
        ];
    }
}
