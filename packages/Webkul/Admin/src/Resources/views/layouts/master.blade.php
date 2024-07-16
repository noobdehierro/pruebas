<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <title>@yield('page_title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="57x57"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('vendor/webkul/admin/assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('vendor/webkul/admin/assets/images/favicon/manifest.json') }}">

    <link rel="stylesheet" href="{{ asset('vendor/webkul/ui/assets/css/ui.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/webkul/admin/assets/css/admin.css') }}">

    <script src="{{ asset('js/Method.js') }}"></script>
    <script src="{{ asset('js/CORE_APIEvents.js') }}"></script>
    <script src="{{ asset('js/cw-galatea-integration-api-js-bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/prueba.js') }}"></script> --}}



    @yield('head')

    @yield('css')
    @stack('css')
    <style>
        .boton-flotante {
            position: fixed;
            bottom: 20px;
            /* Ajusta la distancia desde la parte inferior */
            right: 20px;
            /* Ajusta la distancia desde la derecha */
            background-color: #007bff;
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000;
            /* Asegura que esté por encima de otros elementos */
        }

        .boton-flotante:hover {
            background-color: #0056b3;
        }

        /* Modal */
        .modal {
            display: none;
            /* Oculto por defecto */
            position: fixed;
            z-index: 1001;
            /* Debe estar encima del botón flotante */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fondo negro semi-transparente */
        }

        /* Contenido del Modal */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% desde la parte superior y centrado horizontalmente */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Ajusta el ancho según sea necesario */
            max-width: 500px;
            /* Máximo ancho */
        }

        /* Botón de cerrar (X) */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    {!! view_render_event('admin.layout.head') !!}

</head>

<body style="scroll-behavior: smooth;" @if (in_array(app()->getLocale(), ['fa', 'ar'])) class="rtl" @endif>
    {!! view_render_event('admin.layout.body.before') !!}

    <div id="app">
        <spinner-meter :full-page="true" v-if="! pageLoaded"></spinner-meter>

        <flash-wrapper ref='flashes'></flash-wrapper>

        {!! view_render_event('admin.layout.nav-top.before') !!}

        @include ('admin::layouts.nav-top')

        {!! view_render_event('admin.layout.nav-top.after') !!}

        <div class="layout-container">
            {!! view_render_event('admin.layout.nav-left.before') !!}

            @include ('admin::layouts.nav-left')

            {!! view_render_event('admin.layout.nav-left.after') !!}


            <div class="content-container" :style="{ paddingLeft: isMenuOpen ? '250px' : '' }">

                {!! view_render_event('admin.layout.content.before') !!}

                @yield('content-wrapper')

                {!! view_render_event('admin.layout.content.after') !!}

            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.flashMessages = [];

        @foreach (['success', 'warning', 'error', 'info'] as $key)
            @if ($value = session($key))
                window.flashMessages.push({
                    'type': '{{ $key }}',
                    'message': "{{ $value }}"
                });
            @endif
        @endforeach

        window.serverErrors = [];

        @if (isset($errors) && count($errors))
            window.serverErrors = @json($errors->getMessages());
        @endif

        window._translations = {};
        window._translations['ui'] = @json(app('Webkul\Core\Helpers\Helper')->jsonTranslations('UI'));
        window.baseURL = '{{ url()->to('/') }}';
        window.params = @json(request()->route()->parameters());
    </script>

    <script type="text/javascript" src="{{ asset('vendor/webkul/admin/assets/js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>

    @stack('scripts')

    {!! view_render_event('admin.layout.body.after') !!}

    <div class="modal-overlay"></div>
    <button class="boton-flotante" id="openModalBtn">Debug</button>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <form>
                <div class="form-group">
                    <input type="reset" id="resetTextArea" value="Clear" />
                    <label for="textDebug">Debug</label>
                    <textarea class="form-control" id="textDebug" rows="25" style="width: 100%"></textarea>
                </div>
            </form>
        </div>
    </div>

</body>
<script type="text/Javascript">connectToServer()</script>
<script type="text/javascript">
    // Obtén el modal
    var modal = document.getElementById("myModal");

    // Obtén el botón que abre el modal
    var btn = document.getElementById("openModalBtn");

    // Obtén el <span> que cierra el modal

    // Cuando el usuario hace clic en el botón, abre el modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Cuando el usuario hace clic en cualquier lugar fuera del modal, lo cierra
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>


</html>
