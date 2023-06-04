@vite(['resources/css/previousOrder.css'])
<a href="/dashboard">BVP</a>
<h2>Jouw eigendomsbewijzen</h2>

<button id="exportPdf">Exporteer naar PDF</button>

@foreach ($orders as $order)
<ul class="rings">
  <li>{{ $order->ring_name}} MAAT: {{ $order->ring_size}} RINGNUMMER: {{ $order->id}}</li>
</ul>
@endforeach

<script>
  document.getElementById('exportPdf').addEventListener('click', function() {
    // Generate and download the PDF
    exportToPdf();
  });

  function exportToPdf() {
    // Send a request to the server to generate the PDF
    fetch('/generate-pdf', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include the CSRF token if using Laravel's CSRF protection
      },
      body: JSON.stringify({ html: document.documentElement.innerHTML }),
    })
    .then(response => response.blob())
    .then(blob => {
      // Create a temporary URL for the generated PDF
      const url = URL.createObjectURL(blob);
      
      // Trigger the download by creating an anchor element and clicking it
      const a = document.createElement('a');
      a.href = url;
      a.download = 'eigendomsbewijzen.pdf';
      a.click();

      // Clean up the temporary URL
      URL.revokeObjectURL(url);
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
</script>
