<x-mail::message>
@php
$statusMessages = [
    'processing' => [
        'title' => 'Order Being Processed',
        'message' => 'Great news! We\'ve received your order and our team is now preparing your items for shipment.',
        'icon' => '⏳',
        'next_step' => 'Your order will be shipped within 1-2 business days.',
    ],
    'shipped' => [
        'title' => 'Order Shipped',
        'message' => 'Excellent! Your order has been dispatched and is on its way to you.',
        'icon' => '🚛',
        'next_step' => 'You can expect delivery within 2-5 business days depending on your location.',
    ],
    'delivered' => [
        'title' => 'Order Delivered',
        'message' => 'Fantastic! Your order has been successfully delivered.',
        'icon' => '📦',
        'next_step' => 'We hope you enjoy your purchase! Don\'t forget to leave a review.',
    ],
    'cancelled' => [
        'title' => 'Order Cancelled',
        'message' => 'Your order has been cancelled as requested.',
        'icon' => '❌',
        'next_step' => 'If you paid online, your refund will be processed within 3-5 business days.',
    ],
];

$statusInfo = $statusMessages[$currentStatus] ?? [
    'title' => 'Order Status Updated',
    'message' => 'Your order status has been updated.',
    'icon' => '📋',
    'next_step' => 'Check your dashboard for more details.',
];
@endphp

# {{ $statusInfo['icon'] }} {{ $statusInfo['title'] }}

Hi {{ $user->name }},

{{ $statusInfo['message'] }}

## Order Details

**Order Number:** #{{ $order->id }}  
**Order Date:** {{ $order->created_at->format('F j, Y') }}  
**Status:** {{ ucfirst($currentStatus) }}  
**Total:** MVR {{ number_format($order->grand_total, 2) }}

@if($currentStatus === 'shipped')
## Tracking Information

Your package is on its way! Here's what you need to know:

- **Estimated Delivery:** {{ now()->addDays(3)->format('F j, Y') }}
- **Delivery Address:** {{ $order->delivery_address }}
- **Contact Number:** {{ $order->delivery_phone }}

**Please ensure someone is available to receive the package at the delivery address.**
@endif

@if($currentStatus === 'delivered')
## Thank You!

We hope you're happy with your purchase. Your feedback helps us improve our service.

**Need to return or exchange an item?**  
Visit our [Returns & Exchanges]({{ route('legal.refunds') }}) page for more information.
@endif

@if($currentStatus === 'cancelled')
## Refund Information

@if($order->payment_method === 'cod')
Since you chose Cash on Delivery, no payment was collected, so no refund is necessary.
@else
Your refund will be processed within 3-5 business days using the same payment method you used for your order.
@endif

**Questions about your cancellation?**  
Contact our support team - we're here to help!
@endif

## What's Next?

{{ $statusInfo['next_step'] }}

@if($currentStatus !== 'cancelled')
<x-mail::button :url="route('dashboard')" color="primary">
View Order Details
</x-mail::button>
@endif

## Need Help?

If you have any questions about your order, please contact us:

- **Email:** support@baazaar.mv
- **Phone:** +960 XXX-XXXX
- **Hours:** Sunday to Thursday, 9:00 AM - 6:00 PM

Thank you for choosing Baazaar!

Best regards,  
The Baazaar Team

---
**Baazaar Maldives**  
Your trusted online shopping destination  
{{ config('app.url') }}
</x-mail::message>