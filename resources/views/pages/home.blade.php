<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>parkieten-ring-tool</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @vite(['resources/css/app.css'])
</head>
<body>
  <div class="page">
    <div class="layer">
      <nav class="header_nav">
        <ul class="header_nav-list">
            @foreach ($menuItems as $menuItem)
            <li class="header_nav-list_item">
                <a 
                    class="nav-item {{ $menuItem['active'] ? 'current' : '' }} }}" 
                    href="{{ $menuItem['url'] }}" 
                    data-page="{{ $menuItem['title'] }}">
                    {{ $menuItem['title']}}
                </a>
            </li>    
            @endforeach
          
            
        </ul>
    </nav>
    <main>
      <h1>Log in om onze nieuwe besteltool te gebruiken</h1>
      <h2>Bestel je perfecte ring eenvoudig en snel met onze nieuwe besteltool. Kies je ringmaat, het gewenste type ring en meer, allemaal in een handomdraai. Ontdek het gemak en bestel vandaag nog jouw ideale ring. </h2>
      <h1>Ringen in onze collectie:</h1>
      <div class="ringlegende">
        @foreach ($rings as $ring)
            <ul class="rings">
                <li>{{ $ring->name }} </li>
                <p>{{ $ring->color }}</p>
                <p>€{{ $ring->price }}</p>
                <img src="{{ $ring->image_url }}" alt="">
    
            </ul>
        @endforeach
    </div>
    </main>

    <footer></footer>
  </div>
  </div>
</body>
</html>