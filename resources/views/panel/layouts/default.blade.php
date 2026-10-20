<!DOCTYPE html>
<html
    lang="tr"
    class="light-style layout-navbar-fixed layout-menu-fixed overflow-x-hidden"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="/panel/assets/"
    data-template="vertical-menu-template-starter">

    @include("panel.common.head")

<body>
 <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NBPH24W7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->   

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
                    @include("panel.common.breads")
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

<script>
    function editModule(element) {
        var key = "";
        var update = "";
        var liElement = element.closest('li');
        if (liElement) {
            var selectElement = liElement.querySelector('select');
            if (selectElement) {
                var selectedOption = selectElement.options[selectElement.selectedIndex];

                if (selectedOption) {
                    key = selectedOption.value;
                    update = selectedOption.getAttribute("data-update");
                }
            }
        }

        if (key && parseInt(update) === 0) {
            var ex = key.split(".");
            window.open('{{route("modules.index")}}/' + ex[1] + '/edit?code='+ ex[0], '_blank');
        } else if(parseInt(update) === 1) {
            alertify.warning('Bu modül güncellenebilir bir modül değildir.');
        }else {
            alert('Henüz bir modül seçilmediğinden güncelleme yapamazsınız.');
        }
    }

    // Event listener for edit icon
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('module-select')) {
            editModule(event.target);
        }
    });
</script>

</body>

</html>
