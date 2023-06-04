<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Payment Confirmation') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <h1>Payment Confirmation</h1>
      <h2>Thank you, {{ $user_name }}, for paying the membership fee!</h2>
      <!-- Show additional information or a success message -->
      <script>
        setTimeout(function() {
            window.location.href = '/dashboard';
        }, 2000); // Redirect back to the order form after 3 seconds
    </script>
  
    </div>
</x-app-layout>
