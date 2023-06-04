<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Payment') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <h1>Pay Membership Fee</h1>
      <h2>Amount: 50 EUR</h2>
      <h2>Description: {{ $paymentDescription }}</h2>
      <form action="{{ route('profile.payment.checkout') }}" method="POST">
          @csrf
          
          <button type="submit">Pay</button>
        </form>
    </div>
</x-app-layout>

