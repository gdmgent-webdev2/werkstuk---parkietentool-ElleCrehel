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
      <h1>Maak kennis met onze nieuwe besteltool</h1>
    </main>

    <footer></footer>
  </div>
  </div>
</body>
</html>