<form action={{ route('money.earn') }} method="POST">
    @csrf
    <input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
    <input type="hidden" id="user_name" name="user_name" value="{{ $user_name }}">
    <input type="hidden" id="lidnumber" name="lidnumber" value="{{ $user_lidnumber }}">

    <label for="price">prijs:</label>
    <input name="price" type="number">

    <button type="submit">
        Verstuur
    </button>
</form>
