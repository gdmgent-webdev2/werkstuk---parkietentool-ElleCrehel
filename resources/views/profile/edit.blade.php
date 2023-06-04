<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
       <h1>Profile information:</h1>
      <h2>Gebruikersnaam: {{$user_name}}</h2>
      <h2>Lidnummer: {{$user_lidnumber}}</h2>
      <h2>Email: {{$user_email}}</h2>
    
    </div>
</x-app-layout>
