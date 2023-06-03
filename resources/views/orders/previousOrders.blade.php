
@vite(['resources/css/previousOrder.css'])
<h1>Historiek bestellingen:</h1>

@foreach ($orders as $order)
<ul class="rings">
  <li>Bestelnummer: {{ $order->id}}</li>
    <p>Ring: {{ $order->ring_name}}</p>
    <p>Maat: {{ $order->ring_size}}</p>
    <p>Datum bestelling: {{ $order->created_at}}</p>
   
   

</ul>
@endforeach