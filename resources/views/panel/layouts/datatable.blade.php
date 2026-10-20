<!DOCTYPE html>
<html
    lang="tr"
    class="light-style layout-navbar-fixed layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="/panel/assets/"
    data-template="vertical-menu-template-starter">

    @include("panel.common.head")

<body>

@if(session()->has('success'))
    <script>alertify.success('{{session('success')}}')</script>
@elseif(session()->has('warning'))
    <script>alertify.warning('{{session('warning')}}')</script>
@elseif(session()->has('error'))
    <script>alertify.error('{{session('error')}}')</script>
@endif

@foreach($errors->all() as $error)
    <script>alertify.error('{{$error}}')</script>
@endforeach

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include("panel.common.main_navbar")

        <div class="layout-page">
            @include("panel.common.header")

            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>

                @include("panel.common.footer")

                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
</div>

@include("panel.common.scripts")

</body>

</html>
