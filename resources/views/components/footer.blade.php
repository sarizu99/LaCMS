@php
    $site = \App\SiteSetting::first();
@endphp

<footer class="site-footer container-fluid bg-dark">
    <div class="row">
        <div class="col-md-8 p-5 d-flex justify-content-center align-items-center">
            <div class="post-mascot">
                <img src="{{ asset('img/kaptenlela.png') }}" width="150">
            </div>
            <div class="site-description d-inline-block ml-4">
                {{ $site->description }}
            </div>
        </div>
        <div class="col-md-4 bg-black p-5">
            <h4>Hubungi kami</h4>
            Untuk urusan bisnis dan kerja sama, harap hubungi kontak whatsapp berikut.
            <div class="media mt-4">
                <img src="{{ asset('img/pp.jpg') }}" class="mr-3" width="50">
                <div class="media-body">
                    <h6 class="mt-0 mb-1"><strong>Bayu Laksono Wahyu Arminsyah</strong></h6>
                    <i class="fab fa-whatsapp"></i> 0858-1202-2950
                </div>
            </div>
        </div>
        <div class="col-12 text-center" style="background: #1c2024;">
            <small>
                Made with <i class="fa fa-heart text-danger" aria-hidden="true"></i> in Karawang
            </small>
        </div>
    </div>
</footer>