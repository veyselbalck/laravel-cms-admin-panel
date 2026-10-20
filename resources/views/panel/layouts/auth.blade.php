<!DOCTYPE html>
<html
    lang="tr"
    class="light-style layout-navbar-fixed layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="/panel/assets/"
    data-template="vertical-menu-template-starter">

    @include("panel.common.head")

    <link rel="stylesheet" href="/panel/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/panel/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="/panel/assets/vendor/css/pages/page-auth.css" />

<body>
<div class="container-xxl flex-grow-1 container-p-y">
    @yield('content')
</div>

<script src="/panel/assets/vendor/libs/popper/popper.js"></script>
<script src="/panel/assets/vendor/js/bootstrap.js"></script>
<script src="/panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="/panel/assets/vendor/libs/hammer/hammer.js"></script>
<script src="/panel/assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="/panel/assets/vendor/js/menu.js"></script>

<!-- Vendors JS -->
<script src="/panel/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
<script src="/panel/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
<script src="/panel/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

<!-- Main JS -->
<script src="/panel/assets/js/main.js"></script>

<!-- Page JS -->
<script src="/panel/assets/js/pages-auth.js"></script>

</body>

</html>
