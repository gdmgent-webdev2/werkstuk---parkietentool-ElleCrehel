@vite(['resources/css/order.css'])
<a href="/dashboard">BVP</a>
<h2>Dag {{ $user_name }}, bestel uw ring hier.</h2>

<form action="{{ route('orders.store') }}" method="POST">

    @csrf
    <label for="ring_name">Ring:</label>
    <select id="ring_name" name="ring_name">
        @foreach ($rings as $ring)
            <option value="{{ $ring->name }}">{{ $ring->name }}</option>
        @endforeach
    </select>
    @error('ring_name')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <br><br>
    <label for="ring_size">Maat:</label>
    <input type="text" id="ring_size" name="ring_size">
    @error('ring_size')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <p>(Diameters tussen 3.5mm en 16mm)</p>
   
   
    <label for="price">prijs</label>
<input type="hidden" name="price" id="price">


    <input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
    <input type="hidden" id="status" name="status" value="betaald">
    <input type="hidden" id="user_name" name="user_name" value="{{ $user_name }}">
    <input type="hidden" id="lidnumber" name="lidnumber" value="{{ $user_lidnumber }}">
    <button type="submit">
        Verstuur
    </button>
</form>


<h1>Ring Legende</h1>
<div class="ringlegende">
    @foreach ($rings as $ring)
        <ul>

            <li>{{ $ring->name }} </li>
            <p>{{ $ring->color }}</p>
            <p>€{{ $ring->price }}</p>
            <img src="{{ $ring->image_url }}" alt="">

        </ul>
    @endforeach
</div>
