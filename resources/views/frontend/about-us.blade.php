@extends('layouts.frontend')

@section('body-content')

    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Tentang Kami</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i>Tentang Kami</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- about wrapper -->
    <div class="about-page-wrapper">
        <div class="description description-padding">
            <div class="row ">
                <div class="col-md-12 ">
                    <div class="about-right-text" style="padding-top:0;text-align: justify;">
                        <div class="widget-title">
                            <h4>Indofund.id adalah perusahaan P2P (<i>peer to peer</i>) lending yang terdaftar dan diawasi oleh Otoritas Jasa Keuangan (OJK).</h4>
                        </div>
                        <h3>Sebenarnya apa itu P2P?</h3>
                        <p class="first">
                            Apakah Anda pernah <strong>meminjam uang</strong> kepada seorang rekan Anda?
                            <br>
                            Atau mungkin pernah juga <strong>meminjamkan uang</strong> kepada rekan Anda?
                            <br>
                            <br>
                            Bisa jadi Anda juga pernah mengajukan pinjaman ke bank namun <strong>terkendala oleh serangkaian</strong> ketentuan dari bank?
                            <br>
                            <br>
                            <strong>Indofund.id</strong> adalah sebuah <strong>tempat yang mempertemukan orang</strong> yang ingin meminjam uang (kemudian disebut dengan <i>borrower</i>) dengan orang yang ingin meminjamkan uang (disebut dengan <i>lender</i>).
                            <br>
                            <br>
                            Apakah Anda <strong>pernah membeli maupun menjual barang</strong> di <i>marketplace</i>?
                            <br>
                            <br>
                            <strong>Ada ribuan barang bisa Anda pilih</strong> sesuai dengan keperluan Anda, dimana ada juga ribuan pembeli dan penjual bertemu di <i>marketplace online</i> setiap harinya.
                            <br>
                            <br>
                            Demikian juga dengan Indofund.id kami <strong>mempertemukan pihak</strong> yang membutuhkan bantuan atas pendanaan proyek dan bisnis yang mereka miliki dengan orang-orang yang ingin memberikan pendanaan.
                            <br>
                        </p>
                        <img class="img-responsive" src="{{ URL::asset('frontend_images/aboutus/P2P_MarketPlace.png') }}" alt="">
                        <p class="first">
                            <i>Borrower</i> atau pihak yang membutuhkan bantuan dana <strong>merasa terbantu dengan semua <i>lender</i> yang bersedia membantu</strong> mereka agar usaha dan bisnisnya bisa terus berkembang dan tidak terhambat akibat dana.
                            <br>
                            <i>Lender</i> atau pihak yang meminjamkan dana juga merasa terbantu karena dapat mendanai proyek dan bisnis serta berpotensi mendapatkan keuntungan (imbal hasil) dari pinjam meminjam dana yang dilakukan.
                        </p>

                        <h3>Setujukah Anda bahwa Indonesia memiliki banyak potensi usaha yang dapat berkembang dengan besar dan menguntungkan?</h3>

                        <div class="col-md-offset-2 col-md-10 col-sm-12">
                            <img class="img-responsive" src="{{ URL::asset('frontend_images/aboutus/usaha-1.jpg') }}" alt="" style="width:80%">
                            <br>
                            <img class="img-responsive" src="{{ URL::asset('frontend_images/aboutus/usaha-2.jpg') }}" alt="" style="width:80%">
                        </div>
                        <p class="first">
                            Dengan kekayaan alam dan kesuburan tanah membuat setiap bisnis dan industri yang dijalankan di Indonesia dapat dipastikan akan lebih besar peluang keberhasilannya.
                            <br>
                            Selain itu Indonesia juga memiliki bonus demografi :
                        </p>

                        <div class="col-md-offset-2 col-md-10 col-sm-12">
                            <img class="img-responsive" src="{{ URL::asset('frontend_images/aboutus/demografi.jpg') }}" alt="" style="width:80%">
                        </div>
                        <p class="first">
                            Namun yang menjadi menarik pada sebuah survei yang dilakukan pada tahun 2013, akses masyarakat Indonesia yang menggunakan bantuan perusahaan keuangan (industri keuangan) adalah sebagai berikut:

                            <img class="img-responsive" src="{{ URL::asset('frontend_images/aboutus/ojk.jpg') }}" alt="">
                            <br>
                            <strong>Setidaknya baru 60% masyarakat</strong> Indonesia yang menggunakan bank.
                        </p>
                        <h3>Mengapa Indofund.id ada?</h3>
                        <p class="first">
                            Tidak sedikit bisnis dan usaha yang terkendala untuk membesarkan usahanya saat ini karena mungkin skala risiko usaha dan ketentuan pendanaan melalui bank tidak dapat mereka penuhi.
                            <br>
                            Indofund.id berupaya membuat klasifikasi segala jenis usaha dan bisnis potensial untuk tetap bisa mendapatkan akses permodalan dengan metode <i>peer to peer</i>.

                        </p>
                        <div class="first text-center">
                            <br>
                            <h3><i>“Banyak proyek dan bisnis visible tapi tidak bankable”</i></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- team -->
        <div class="team-wrapper" style="padding: 10px 0;text-align: justify;">
            <div class="description description-padding">

                <h2>Apa yang membedakan Indofund.id dengan P2P lending lainnya?</h2>
                <h3>Expert & Solid Team</h3>
                <br>
                <p>Tim utama Indofund.id terdiri dari individu-individu yang telah berpengalaman dalam industri keuangan</p>

                <div class="team-members row">
                    <img class="img-responsive" src="{{ URL::asset('frontend_images/aboutus/BOD.png') }}" alt="">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="single-member">
                            <div class="best-volunteer">
                                <h4><strong>Ryan Filbert</strong></h4>
                                <h4><i>CEO & Founder – Indofund.id</i></h4>
                                <p>
                                    Terkenal sebagai salah seorang praktisi dan inspirator investasi di Indonesia, Ryan Filbert berpengalaman lebih dari 10 tahun dalam bidang investasi, khususnya saham dan derivative.
                                </p>
                                <p>
                                    Selain sebagai praktisi dan inspirator, Ryan juga dikenal sebagai seorang mentor dan penulis buku-buku tentang investasi dan analis saham, baik teknikal maupun secara fundamental.  Kemampuan analisanya merupakan asset yang berharga bagi perusahaan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="single-member">
                            <div class="best-volunteer">
                                <h4><strong>David Alusinsing</strong></h4>
                                <h4><i>CFO – Indofund.id</i></h4>
                                <p>
                                    Berpengalaman lebih dari 10 tahun di pasar modal sebagai <i>Corporate Finance</i> dan Investment Banker.
                                </p>
                                <p>
                                    Mengawali karir sebagai <i>Investment Bank</i>, David Alusinsing memiliki pengalaman sebagai <i>financial advisor</i> untuk beberapa sektor seperti pertambangan, keuangan, <i>consumer</i> dan beberapa industri.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 hidden-sm">
                        <div class="single-member">
                            <div class="best-volunteer">
                                <h4><strong>Hevy Yafanny (Fanny)</strong></h4>
                                <h4><i>Founder – Indofund.id</i></h4>
                                <p>
                                    Memulai karir sebagai auditor di Deloitte, Fanny memiliki kemampuan & pengalaman yang tinggi dalam bidang keuangan, akuntansi & <i>fraud detection</i>.
                                </p>
                                <p>
                                    Fanny juga berpengalaman selama hampir 20 tahun dalam berbagai industri, baik pertambangan, properti, keuangan dan investasi.
                                </p>
                                <p id="p2p">
                                    Kemampuan dan pengalaman beliau dalam melihat potensi dan kelayakan usaha akan sangat berharga dalam menjalankan <i>investment & crowdfunding</i>.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 hidden-sm">
                        <div class="single-member">
                            <div class="best-volunteer">
                                <h4><strong>Steffen Fang</strong></h4>
                                <h4><i>Founder  – Indofund.id</i></h4>
                                <p>
                                    Berpengalaman lebih dari 17 tahun di bidang investasi & keuangan, baik sebagai <i>advisor</i>, <i>banker</i>, maupun pelaku usaha.
                                </p>
                                <p>
                                    Mengawali karir sebagai seorang <i>Investment Banker</i>, Steffen memiliki kemampuan dan kualifikasi yang kuat dalam analisa kelayakan usaha, <i>due diligence</i> dan pendanaan, yang krusial dibutuhkan dalam bisnis <i>crowdfunding</i>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <h3>Bukan sekedar P2P lending</h3>
                <br>
                <div class="team-members row" style="padding: 0 20% 0 20%; text-align: center;">
                    <p>Proses seperti apa untuk bisa menjadi <i>borrower</i> dan <i>lender</i>? <br>Ini adalah diagram kerjanya:</p>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="col-xs-12">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <p>
                                        <strong>Menjadi Borrower</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-1.png') }}" alt="">
                                    <p>
                                        Calon <i>borrower</i> mengajukan pinjaman melalui website Indofund.id dengan melengkapi form dan data
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 hidden-sm">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-2.png') }}" alt="">
                                    <p>
                                        Pinjaman disetujui oleh Indofund.id dan pinjaman ditawarkan kepada <i>lender</i> di website Indofund.id
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 hidden-sm">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-3.png') }}" alt="">
                                    <p>
                                        Borrower melunasi pinjaman terhadap <i>lender</i> sesuai dengan tenggat waktu yang diberikan beserta dengan bunga pinjaman
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="col-xs-12">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <p>
                                        <strong>Menjadi Lender</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-1.png') }}" alt="">
                                    <p>
                                        Lender mencari pinjaman yang sesuai dengan profil risiko dan minat dalam mendanai di Indofund.id
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-2.png') }}" alt="">
                                    <p>
                                        Lender memutuskan pilihan pendanaan melalui list pinjaman dari <i>borrower</i> yang tersedia di Indofund.id
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 hidden-sm">
                            <div class="single-member">
                                <div class="best-volunteer">
                                    <img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-3.png') }}" alt="">
                                    <p>
                                        Lender menerima laporan dan pembayaran pelunasan di website Indofund.id serta mendapatkan laporan perkembangannya
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<p>--}}
                                    {{--<strong>Menjadi Borrower</strong>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<p>--}}
                                    {{--<strong>Menjadi Lender</strong>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-1.png') }}" alt="">--}}
                                {{--<p>--}}
                                    {{--Calon <i>borrower</i> mengajukan pinjaman melalui website Indofund.id dengan melengkapi form dan data--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-1.png') }}" alt="">--}}
                                {{--<p>--}}
                                    {{--Lender mencari pinjaman yang sesuai dengan profil risiko dan minat dalam mendanai di Indofund.id--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12 hidden-sm">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-2.png') }}" alt="">--}}
                                {{--<p>--}}
                                    {{--Pinjaman disetujui oleh Indofund.id dan pinjaman ditawarkan kepada <i>lender</i> di website Indofund.id--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12 hidden-sm">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-2.png') }}" alt="">--}}
                                {{--<p>--}}
                                    {{--Lender memutuskan pilihan pendanaan melalui list pinjaman dari <i>borrower</i> yang tersedia di Indofund.id--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12 hidden-sm">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<img src="{{ URL::asset('frontend_images/aboutus/kerja-borrower-3.png') }}" alt="">--}}
                                {{--<p>--}}
                                    {{--Borrower melunasi pinjaman terhadap <i>lender</i> sesuai dengan tenggat waktu yang diberikan beserta dengan bunga pinjaman--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12 hidden-sm">--}}
                        {{--<div class="single-member">--}}
                            {{--<div class="best-volunteer">--}}
                                {{--<img src="{{ URL::asset('frontend_images/aboutus/kerja-lender-3.png') }}" alt="">--}}
                                {{--<p>--}}
                                    {{--Lender menerima laporan dan pembayaran pelunasan di website Indofund.id serta mendapatkan laporan perkembangannya--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>

                <br>
                <h3>Akselerasi Bisnis dan Usaha</h3>
                <br>
                <p>Selain itu Indofund.id juga memberikan aneka <i>training</i> dan <i>mentoring</i> kepada <i>borrower</i> dan <i>lender</i> sehingga <i>borrower</i> bisa menjadi pelaku usaha yang semakin berkembang dan maju dan <i>lender</i>  juga bisa menjadi pemodal yang memiliki profil risiko yang semakin matang serta aset yang mengalami pertumbuhan dengan maksimal. </p>
                <br>
                <p>Dalam hal ini Indofund.id bekerja sama dengan mitra-mitra strategis untuk bisa meningkatkan <i>hard skill</i> dan <i>soft skill</i> setiap member dari Indofund.id </p>

            </div>

            <div class="description" style="padding: 0 18%;">
                <h3>Mitra – mitra Indofund.id </h3>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <a href="http://idxincubator.com/"><img src="{{ URL::asset('frontend_images/aboutus/mitra-1.png') }}" class="img-responsive center-block"></a>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a><img src="{{ URL::asset('frontend_images/aboutus/mitra-2.png') }}"  class="img-responsive center-block"></a>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a href="http://www.megasekuritas.id/"><img src="{{ URL::asset('frontend_images/aboutus/mitra-3.png') }}" class="img-responsive center-block"></a>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a href="https://kayadgnsehat.com/"><img src="{{ URL::asset('frontend_images/aboutus/mitra-4.png') }}"  class="img-responsive center-block"></a>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a><img src="{{ URL::asset('frontend_images/aboutus/mitra-7.png') }}"  class="img-responsive center-block"></a>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a href="http://elexmedia.id"><img src="{{ URL::asset('frontend_images/aboutus/mitra-5.png') }}"  class="img-responsive center-block"></a>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <a href="https://rumahinvestasi.org/"><img src="{{ URL::asset('frontend_images/aboutus/mitra-6.png') }}"  class="img-responsive center-block"></a>
                    </div>
                </div>
                <br>
                <p>PT Bursa Akselerasi Indonesia dengan merk dagang Indofund.id memiliki visi dan misi untuk bisa mengembangkan setiap bisnis dan usaha dari aneka industri di Indonesia dengan keterlibatan dari masyarakat Indonesia dan untuk masyarakat Indonesia.</p>
                <br>
                <p>Selain itu, Indofund.id juga berkomitmen untuk bisa membawa para <i>borrower</i> dari industri Usaha Kecil dan Menengah (UKM) untuk bisa mendapatkan akses level permodalan yang lebih baik hingga tingkat Indonesia dan Dunia.</p>
                <br>
                <p>Dari sisi pemodal atau <i>lender</i>, Indofund.id ingin mengajak setiap pemodal menjadi investor yang cerdas dan berkembang.</p>
            </div>

        </div>
    </div>
@endsection