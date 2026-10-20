@extends('panel.layouts.default')

@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">{{ auth()->user()->name }}, <span class="text-muted fw-light">Hoşgeldiniz.</span></h4>
    <div class="row">

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">İçerikler</h3>
                    <span class="d-block mb-4 text-nowrap">Siteye ait içerik sayfaları.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 text-warning mb-2 pt-4 pb-1">{{dashboardCounter("contents")}} adet</h1>
                            <a href="{{ route("contents.index") }}" class="btn btn-sm btn-warning">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/icons//unicons/desktop.png" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">Postlar/Bloglar</h3>
                    <span class="d-block mb-4 text-nowrap">Siteye ait post/blog veya haberler.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 text-success mb-2 pt-4 pb-1">{{dashboardCounter("contents", 'post')}} adet</h1>
                            <a href="{{ route("posts.index") }}" class="btn btn-sm btn-success">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/icons//unicons/cube.png" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">Ürünler</h3>
                    <span class="d-block mb-4 text-nowrap">Siteye ait ürünler.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 text-success mb-2 pt-4 pb-1">{{dashboardCounter("contents", 'product')}} adet</h1>
                            <a href="{{ route("products.index") }}" class="btn btn-sm btn-success">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/icons//unicons/cube.png" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">Modüller</h3>
                    <span class="d-block mb-4 text-nowrap">Sayfa, post ve diğer alan modülleri.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 text-info mb-2 pt-4 pb-1">{{dashboardCounter("module")}} adet</h1>
                            <a href="{{ route("modules.index") }}" class="btn btn-sm btn-info">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/icons//unicons/chart.png" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">Diller</h3>
                    <span class="d-block mb-4 text-nowrap">Site dilleri ve dil ayarları.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 text-dark mb-2 pt-4 pb-1">{{dashboardCounter("languages")}} adet</h1>
                            <a href="{{ route("languages.index") }}" class="btn btn-sm btn-dark">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/icons//unicons/language.png" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">SEO Yönlendirme</h3>
                    <span class="d-block mb-4 text-nowrap">Site url yönlendirmeleri.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 text-primary mb-2 pt-4 pb-1">{{dashboardCounter("seo_redirect")}} adet</h1>
                            <a href="{{ route("seo_redirect.index") }}" class="btn btn-sm btn-primary">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/icons//unicons/rocket-square.png" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">Kullanıcılar</h3>
                    <span class="d-block mb-4 text-nowrap">Admin panel kullanıcıları.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 text-danger mb-2 pt-4 pb-1">{{dashboardCounter("users")}} adet</h1>
                            <a href="{{ route("users.index") }}" class="btn btn-sm btn-danger">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/icons//unicons/community-red.png" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-2">Ayarlar</h3>
                    <span class="d-block mb-4 text-nowrap">Site genel ayarları.</span>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <h1 class="display-6 mb-2 pt-4 pb-1" style="color:#3b5998;">{{dashboardCounter("settings")}} adet</h1>
                            <a href="{{ route("settings.index") }}" class="btn btn-sm btn-facebook">Tümünü Görüntüle</a>
                        </div>
                        <div class="col-6 text-end">
                            <img src="/panel/assets/img/illustrations/girl-manage-task-dark.png" width="96" class="rounded-start">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push("styles") @endpush

@push("scripts") @endpush
