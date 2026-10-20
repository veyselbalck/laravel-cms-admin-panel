@extends('panel.layouts.default')

@section('content')
    <div class="flex-fill">

        <!-- Error title -->
        <div class="text-center mb-4">
            <h1 class="display-2 font-weight-semibold line-height-1 mb-2">403</h1>
            <h6 class="w-md-25 mx-md-auto">
                Bu sayfaya erişim izniniz bulunmuyor.<br>Lütfen sistem yöneticinize başvurunuz. Eğer yönetici iseniz kullanıcı gruplarından yönetici izinlerini ayarlayınız.
            </h6>
        </div>
        <!-- /error title -->


        <!-- Error content -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-primary"><i class="bx bx-home me-2"></i> Gösterge Paneli</a>
        </div>
        <!-- /error wrapper -->

    </div>
@endsection
