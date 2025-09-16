<x-mail::message>
# Order Confirmation

Hi {{ $user->name }},

Thank you for your order! We're excited to process your purchase and get it delivered to you as soon as possible.

## Order Details

**Order Number:** #{{ $order->id }}  
**Order Date:** {{ $order->created_at->format('F j, Y \a\t g:i A') }}  
**Payment Method:** {{ ucfirst($order->payment_method) }}  

## Items Ordered

<x-mail::table>
| Product | Quantity | Unit Price | Total |
|---------|:--------:|:----------:|------:|
@foreach($items as $item)
| {{ $item->name }} | {{ $item->qty }} | MVR {{ number_format($item->unit_price, 2) }} | MVR {{ number_format($item->line_total, 2) }} |
@endforeach
</x-mail::table>

## Order Summary

**Subtotal:** MVR {{ number_format($order->subtotal, 2) }}  
@if($order->discount_total > 0)
**Discount:** -MVR {{ number_format($order->discount_total, 2) }}  
@endif
**Shipping:** MVR {{ number_format($order->shipping_total, 2) }}  
**Tax:** MVR {{ number_format($order->tax_total, 2) }}  

**Grand Total:** MVR {{ number_format($order->grand_total, 2) }}

## Delivery Information

@if($order->delivery_address)
**Delivery Address:**  
{{ $order->delivery_address }}

**Delivery Phone:** {{ $order->delivery_phone }}
@endif

## What happens next?

1. **Order Processing:** We'll start preparing your order within 24 hours
2. **Order Dispatch:** You'll receive a tracking notification once your order is shipped
3. **Delivery:** Your order will be delivered to your specified address
4. **Payment:** @if($order->payment_method === 'cod') You can pay cash on delivery @else Your payment will be processed shortly @endif

## Need Help?

If you have any questions about your order, please don't hesitate to contact us:

- **Email:** support@baazaar.mv
- **Phone:** +960 XXX-XXXX
- **Hours:** Sunday to Thursday, 9:00 AM - 6:00 PM

<x-mail::button :url="route('dashboard')" color="primary">
View Order Details
</x-mail::button>

Thank you for choosing Baazaar!

Best regards,  
The Baazaar Team

---
**Baazaar Maldives**  
Your trusted online shopping destination  
{{ config('app.url') }}
</x-mail::message>