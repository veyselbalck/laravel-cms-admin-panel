<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ env("PANEL_NAME") }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/panel/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Fonts -->
    <link rel="stylesheet" href="/panel/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/panel/assets/vendor/css/rtl/core.css" class="template-customizer-core-css"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="{{ asset('plugins/alertify/alertify.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/alertify/css/alertify.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/alertify/css/themes/default.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/alertify/css/themes/semantic.min.css') }}"/>

    <!-- Plugins -->
    <link rel="stylesheet" href="/panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/rateyo/rateyo.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/flatpickr/flatpickr.css" />

    @stack('styles')

{{--    <style>--}}
{{--        .select2-container {--}}
{{--            width: auto !important;--}}
{{--        }--}}
{{--    </style>--}}

    <script src="/panel/assets/vendor/libs/jquery/jquery.js"></script>

    <script src="/panel/assets/vendor/js/helpers.js"></script>
{{--    <script src="/panel/assets/vendor/js/template-customizer.js"></script>--}}
    <script src="/panel/assets/js/config.js"></script>

    <script src="{{ asset("plugins/ui/moment/moment.min.js") }}"></script>
    <script src="{{ asset("plugins/ui/moment/moment_locales.min.js") }}"></script>

    <script src="{{ asset('plugins/bootbox/bootbox.all.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui.js') }}"></script>


    <script src="{{ asset("plugins/loaders/blockui.min.js") }}"></script>
    <script src="{{ asset('plugins/trees/fancytree_all.min.js') }}"></script>
    <script src="{{ asset("plugins/notifications/noty.min.js") }}"></script>

    <script src="{{ asset("plugins/dragula.min.js") }}"></script>

    @vite(['resources/js/panel/app.js'])

    @include("panel.common.module-modal")

</head>
