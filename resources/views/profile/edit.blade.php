<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="py-12">
            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('alert'))
        <script>
            alert("{{ Session::get('alert.message') }}");
        </script>
    @endif
            <h1>Profile information:</h1>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                    <label for="name">Gebruikersnaam: </label>
                    <input type="text" id="name" name="name" value="{{ $user_name }}" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ $user_email }}" required>
                </div>
               
                <button type="submit">Update Profile</button>
                <h2>Lidnummer: {{$user_lidnumber}}</h2>
            </form>
        </div>

        @if ($user_membership_paid === 'yes')
            <button onclick="alert('Lidgeld voor dit jaar is al betaald')">Pay Membership Fee</button>
            <h2>Amount: 50 EUR</h2>
        @else
            <form action="{{ route('profile.payment.checkout') }}" method="POST">
                @csrf
                <button type="submit">Pay Membership Fee</button>
                <h2>Amount: 50 EUR</h2>
            </form>
        @endif
    </div>
</x-app-layout>
