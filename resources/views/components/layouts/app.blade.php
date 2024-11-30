<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>{{ env('APP_NAME', 'Rekam Medis') }}</title>

  <link rel="stylesheet" href="{{ env('ASSETS_URL') }}/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="{{ env('ASSETS_URL') }}/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="{{ env('ASSETS_URL') }}/css/font.css">
  <link rel="stylesheet" href="{{ env('ASSETS_URL') }}/css/style.css" type="text/css">

  @stack('styles')
  @livewireStyles
</head>

<body>
  @if (Auth::user())
  <div class="wrapper">
    @if (Auth::user())
    @livewire('components.sidebar')
    @endif

    <div class="main">
      @if (Auth::user())
      @livewire('components.navbar')
      @endif

      <main class="content p-3">
        <div class="container-fluid">
          {{ $slot }}
        </div>
      </main>

      {{-- <footer class="footer">
        <div class="container-fluid">
          <div class="row text-body-secondary">
            <div class="col-6 text-start ">
              <a class="text-body-secondary" href=" #">
                <strong>CodzSwod</strong>
              </a>
            </div>
            <div class="col-6 text-end text-body-secondary d-none d-md-block">
              <ul class="list-inline mb-0">
                <li class="list-inline-item">
                  <a class="text-body-secondary" href="#">Contact</a>
                </li>
                <li class="list-inline-item">
                  <a class="text-body-secondary" href="#">About Us</a>
                </li>
                <li class="list-inline-item">
                  <a class="text-body-secondary" href="#">Terms & Conditions</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer> --}}
    </div>
  </div>
  @else
  {{ $slot }}
  @endif

  <script src="{{ env('ASSETS_URL') }}/js/jquery.min.js"></script>
  <script src="{{ env('ASSETS_URL') }}/js/popper.min.js"></script>
  <script src="{{ env('ASSETS_URL') }}/js/bootstrap.bundle.min.js"></script>
  <script src="{{ env('ASSETS_URL') }}/js/sweetalert2@11.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.5.1/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    const hamBurger = document.querySelector(".toggle-btn");
    const sidebar = document.querySelector("#sidebar");

    $(document).ready(function() {
      const keyExpandToggle = 'expand_toggle';

      if (sessionStorage.getItem(keyExpandToggle) === null) {
        if(sidebar) sidebar.classList.add('expand');
        sessionStorage.setItem(keyExpandToggle, 'true');
      } else if (sessionStorage.getItem(keyExpandToggle) === 'true') {
        if(sidebar) sidebar.classList.add('expand');
      } else {
        if(sidebar) sidebar.classList.remove('expand');
      }

      if(hamBurger){
        hamBurger.addEventListener("click", function() {
          if(sidebar) sidebar.classList.toggle("expand");
  
          if(sidebar) {
            if (sidebar.classList.contains("expand")) {
              sessionStorage.setItem(keyExpandToggle, 'true');
            } else {
              sessionStorage.setItem(keyExpandToggle, 'false');
            }
          }
        });
      }
    });
  </script>

  @livewireScripts
  @stack('scripts')
</body>

</html>