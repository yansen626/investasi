
<!-- Footer -->
<footer style="background: white; padding:0 !important;border-top: 5px solid #ff7a00;">
    <div class="container subscribe-footer">
        <div class="col-md-12" style="padding-top: 3%;padding-bottom: 3%;">
            <img src="{{ URL::asset('frontend_images/logo.png') }}" style="width:250px">
        </div>
        <div class="col-md-12 col-sm-12 text-left" style="border-bottom: 2px solid #ff7a00;margin-bottom:1%;padding-bottom: 2%;">
            <div class="col-md-6 homepage-footer-contact-us hidden-xs hidden-sm">
                <button class="btn btn-big btn-solid" data-toggle="modal" data-target="#contactUsPopup">Hubungi Kami</button>
            </div>
            <div class="col-sm-12 hidden-md hidden-lg" style="text-align: center;margin-bottom: 5%;">
                <button class="btn btn-big btn-solid" data-toggle="modal" data-target="#contactUsPopup">Hubungi Kami</button>
            </div>
            <div class="col-md-6 col-sm-12" style="text-align: left;">
                PT BURSA AKSELERASI INDONESIA
                <br>
                Satrio Tower Lantai 14 unit 5
                <br>
                Jalan Prof. DR. Satrio Kav. 1-4 Blok C4
                <br>
                Kel. Kuningan Timur, Kec. Setiabudi, Jakarta Selatan 12950, Indonesia
                <br>
                Telepon (021)-25981342
            </div>
        </div>
        <div class="col-md-12 col-sm-12 text-left">
            <p style="font-size: 15px;text-align:justify;">Disclaimer:
                <br>
                Indofund.id adalah website dan merk dagang dari PT Bursa Akselerasi Indonesia. Bagi semua pengguna website ini perlu memberikan perhatian terhadap beberapa hal:
                <br>
                1. Layanan peer to peer landing (pinjam meminjam uang berbasis teknologi) pada Indofund.id adalah persetujuan dan kesepakatan antara pemberi dan penerima pinjaman, segala risiko akan ditanggung oleh masing-masing pihak.
                <br>
                2. Pihak pemberi pinjaman (lender) yang tidak memiliki pemahaman terhadap risiko dan keuntungan dalam meminjamkan dana, disarankan membaca semua keterangan dan proposal penawaran serta perjanjian dengan seksama.
                <br>
                3. Risiko kredit atau gagal bayar menjadi tanggung jawab sepenuhnya dari pemberi pinjaman. Indofund.id berupaya untuk menampilkan semua data dan informasi yang aktual namun tidak bisa menjadi sebuah rekomendasi ataupun saran yang secara mutlak membebaskan setiap pihak dari risiko.
                <br>
                4. Penerima pinjaman (borrower) wajib mempertimbangkan suku bunga dan biaya atas kemampuan melakukan pelunasan. Kegagalan bayar pada peer to peer landing juga akan didaftarkan pada SLIK (Sistem Layanan Informasi Keuangan) di OJK (Otoritas Jasa Keuangan) dan akan mengurangi reputasi borrower di dunia keuangan di Indonesia.
                <br>
                5. Indofund.id selalu berupaya menjadi portal untuk memberikan kenyamanan bagi pihak borrower dan lender dengan melakukan literasi dan sosialisasi secara berkala, pastikan setiap anggota yang terdaftar bisa ikut berpartisipasi dan terlibat pada semua program yang diadakan oleh perusahaan
                <br>
        </div>
    </div>
    <div class="footer-bar" style="background: white; color: #ff7a00;margin-top: 0;font-size: 16px !important;">
        <a href="https://www.facebook.com/Indofundid-430973140666740/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        &nbsp;&nbsp;&nbsp;
        <a href="https://twitter.com/indofund_id" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
        &nbsp;&nbsp;&nbsp;
        <a href="https://www.instagram.com/indofund.id/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        &nbsp;&nbsp;&nbsp;
        <a href="https://www.youtube.com/channel/UCLV2VznCGF7XFSzjuKARzrQ" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
        <br><br>
        <div class="container">
            <h5>2018 © All Rights Reserved | Privacy Policy</h5>
        </div>
    </div>

    <div class="modal fade" id="modal-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="padding-top: 10%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{--<h4 class="modal-title" id="myModalLabel">Success</h4>--}}
                </div>
                <div class="modal-body text-center">
                    <img class="subscribe_popup_image" src="{{ URL::asset('frontend_images/homepage/submit-subscribe.png') }}">
                    <br><br>
                    Kami telah mendaftarkan email Anda pada sistem kami.
                    <br><br>
                    Cek email Anda sekarang dan lakukan konfirmasi alamat email Anda.
                    <br><br>
                    Apabila Anda tidak menemukan email tersebut silahkan cek pada spam folder Anda.
                    <br><br>
                    Bila Anda mendapatkan email apapun dari kami silahkan hubungi contact@indofund.id
                    <br><br>
                    Terima kasih

                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
</footer>
@include('frontend.partials._modal-contact-us')

<script>
    var urlLink = '{{route('subscribeEmail')}}';
</script>