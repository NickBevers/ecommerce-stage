<x-mail::message>
    Dear customer,<br>
    <br>
    We would like to thank you for your order. We are pleased to inform you that your order has been shipped.<br>
    Your order number is: {{ $order->id }}<br>
    <br>
    You can track your order by clicking on the following link: <a href="{{ route('orders.show', $order) }}">{{ route('orders.show', $order) }}</a><br>
    <br>
    below you can find an overview of your order:<br>
    <br>
    <span>---------------------------------------------</span>
    @foreach($order->skus as $sku)
        <div>
            <p>{{ $sku->pivot->product_name }}</p>
            <p>€{{ $sku->pivot->price }}</p>
            <p>Quantity: {{ $sku->pivot->amount }}</p>
            <span>---------------------------------------------</span>
        </div>
    @endforeach
    <br>
    <br>
    Thanks,<br>
    Artcore Ecommerce
</x-mail::message>
