<?php

namespace App\Observers;

use App\Mail\OrderStatusChangedMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if the status field has been changed
        if ($order->isDirty('status')) {
            $previousStatus = $order->getOriginal('status');
            $currentStatus = $order->status;
            
            // Only send email for meaningful status changes (not from null to initial status)
            if ($previousStatus && $previousStatus !== $currentStatus) {
                // Load the user relationship to ensure it's available in the email
                $order->load('user');
                
                Mail::to($order->user->email)->send(
                    new OrderStatusChangedMail($order, $previousStatus)
                );
            }
        }
    }
}
