@extends('layouts.frontend')

@section('body-content')
    <!-- Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="parallax-mask"></div>
            <div class="section-name">
                <h2>Frequently Asked Questions</h2>
                <div class="short-text">
                    <h5><a href="{{route('index')}}">Beranda</a>
                        <i class="fa fa-angle-double-right"></i><a href="#">Frequently Asked Questions (FAQs)</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>


    <!-- Blog-Wrapper -->
    <div class="blog-page-wrapper">
        <div class="container">
            <div class="col-md-4">
                <ul class="list-group help-group">
                    <div class="faq-list list-group nav nav-tabs">
                        <a href="#tab1" class="list-group-item active" role="tab" data-toggle="tab">Frequently Asked Questions</a>
                        <a href="#tab2" class="list-group-item" role="tab" data-toggle="tab"><i class="mdi mdi-account"></i> Pertanyaan terkait dengan borrower</a>
                        <a href="#tab3" class="list-group-item" role="tab" data-toggle="tab"><i class="mdi mdi-account-settings"></i> Pertanyaan terkait dengan Lender</a>
                        <a href="#tab4" class="list-group-item" role="tab" data-toggle="tab"><i class="mdi mdi-star"></i> Keuntungan Menjadi Lender & Borrower</a>
                    </div>
                </ul>
            </div>
            <div class="col-md-8">
                <div class="tab-content panels-faq">
                    <div class="tab-pane active" id="tab1">
                        <div class="panel-group" id="help-accordion-1">
                            <div class="panel panel-default panel-help">
                                <a href="#opret-produkt" data-toggle="collapse" data-parent="#help-accordion-1">
                                    <div class="panel-heading">
                                        <h2>1.	Apa itu Indofund.id ?</h2>
                                    </div>
                                </a>
                                <div id="opret-produkt" class="collapse in">
                                    <div class="panel-body">
                                        <p>Indofund.id adalah sebuah portal pinjam-meminjam Uang berbasis teknologi (P2P Lending) dengan menggunakan website bernama Indofund.id</p>
                                        <p>Untuk mengetahui secara lengkap mengenai Indofund.id silahkan kunjungi halaman <a href="https://indofund.id/about-us" target="_blank">About Us</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="panel-group" id="help-accordion-2">
                            <div class="panel panel-default panel-help">
                                <a href="#help-three1" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Bagaimana cara meminjam dana?</h2>
                                    </div>
                                </a>
                                <div id="help-three1" class="collapse in">
                                    <div class="panel-body">
                                        <p>Cara meminjam dana di Indofund.id adalah dengan meng-klik ajukan pinjaman dana
                                            lalu mengisi formulir pengajuan borrower atau dengan menghubungi partner pihak ke 3
                                            dari Indofund.id dengan mengunjungi halaman <a href="https://indofund.id/pengajuan" target="_blank">jadilah partner kami</a> atau dengan
                                            menghubungi <a href="http://wassmee.us/w/send.aspx?phone=6289643448118&text=Halo%20Indofund.id!%20Saya%20mau%20bertanya%20:" target="_blank">contact kami</a> untuk mendapatkan informasi partner pihak ke 3 kami yang sesuai
                                            dengan sektor dan industri Anda
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three2" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Berapakah dana minimum dan maksimum yang bisa dipinjamkan?</h2>
                                    </div>
                                </a>
                                <div id="help-three2" class="collapse">
                                    <div class="panel-body">
                                        <p>Sesuai dengan aturan dari Otoritas Jasa Keuangan (OJK), besaran dana maksimum adalah senilai Rp 2.000.000.000 (Dua miliar rupiah) dan untuk minimum peminjaman pada Indofund.id adalah sebesar Rp 5.000.000 (Lima juta rupiah)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three3" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Berapa lama jangka waktu peminjaman?</h2>
                                    </div>
                                </a>
                                <div id="help-three3" class="collapse">
                                    <div class="panel-body">
                                        <p>Durasi pinjaman berkisar sama atau kurang dari 12 bulan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three4" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Pinjaman seperti apa yang dapat di proses?</h2>
                                    </div>
                                </a>
                                <div id="help-three4" class="collapse">
                                    <div class="panel-body">
                                        <p>Indofund.id fokus pada pinjaman berbasis modal kerja dan pinjaman produktif yang diperuntukkan hubungannya dengan membesarkan kegiatan yang Anda sedang jalankan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three5" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Apakah perusahaan yang baru berdiri (Start up / Scratch / Concept) bisa mendapatkan pendanaan?</h2>
                                    </div>
                                </a>
                                <div id="help-three5" class="collapse">
                                    <div class="panel-body">
                                        <p>Untuk perusahaan yang belum berdiri maupun sudah berdiri namun belum memiliki produk (pekerjaan) hasil akhir yang dapat dijadikan rekam jejak historis mengenai business process secara keseluruhan, maka usaha Anda tidak dapat secara langsung meminjam dana di Indofund.id. Silahkan menghubungi
                                            <a href="http://wassmee.us/w/send.aspx?phone=6289643448118&text=Halo%20Indofund.id!%20Saya%20mau%20bertanya%20:" target="_blank">contact kami</a> untuk mendapatkan informasi partner pihak ke 3 kami yang bisa menjembatani usaha dan bisnis Anda, agar bisa meminjam dana di Indofund.id</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three6" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Berapakah suku bunga ketika sebuah proyek didanai di Indofund.id?</h2>
                                    </div>
                                </a>
                                <div id="help-three6" class="collapse">
                                    <div class="panel-body">
                                        <p>Suku bunga yang dikenakan dalam kegiatan pinjam meminjam di Indofund.id berbeda-beda antara 1 peminjam dengan peminjam yang lainnya, besaran suku bunga akan diperhitungkan dari tim Analisa kredit maupun Credit Scoring System Indofund.id. Suku bunga yang dikenakan mulai dari 12% per tahun hingga 40% per tahun berlaku suku bunga efektif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three7" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Apakah sebagai peminjam (Borrower) saya dapat nego dengan suku bunga?</h2>
                                    </div>
                                </a>
                                <div id="help-three7" class="collapse">
                                    <div class="panel-body">
                                        <p>Hasil dari Analisa secara manual maupun otomatis akan menghasilkan sebuah rating kredit yang nilainya diinformasikan terlebih dahulu untuk disetujui oleh Anda, sehingga bila besaran suku bunga juga bisa dinegosiasikan bilamana memiliki pandangan yang berbeda</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three8" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Apakah pinjaman akan dibayarkan setiap bulan? Apakah itu pokok dan bunganya saja, atau ada yang lainnya ?</h2>
                                    </div>
                                </a>
                                <div id="help-three8" class="collapse">
                                    <div class="panel-body">
                                        <p>Skema pembayaran pada umumnya adalah berbentuk bulanan yang secara besaran hingga lunas, dibayarkan pokok cicilan dan bunganya. Namun analis kredit juga berhak mengubah sistem pembayaran baik cicilan bunganya saja hingga periode tertentu, maupun dengan kombinasi lainnya yang sesuai dengan usaha dan industri yang Anda miliki dengan motivasi utama yakni tidak memberatkan usaha yang Anda jalani.</p>
                                        <p>Sehingga Indofund.id dapat sampaikan bahwasanya skema pembayaran bisa saja berbeda-beda dalam setiap pengajuan pinjaman</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three9" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Adakah biaya yang dikenakan dalam setiap kegiatan pinjam-meminjam ini terhadap si peminjam (borrower) ?</h2>
                                    </div>
                                </a>
                                <div id="help-three9" class="collapse">
                                    <div class="panel-body">
                                        <p>Ya, terdapat biaya yang dikenakan yaitu biaya manajemen portal Indofund.id dengan besaran mulai dari 2% hingga 5% dari total pinjaman yang diteruskan dari pihak yang meminjamkan (lender)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three10" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Bagaimana tahapan pengajuan pinjaman hingga pinjaman disetujui beserta durasinya?</h2>
                                    </div>
                                </a>
                                <div id="help-three10" class="collapse">
                                    <div class="panel-body">
                                        <p>Step 1 	: Pengajuan Pinjaman 		: Anda mengajukan pinjaman melalui form aplikasi pinjaman maupun menghubungi pihak ke 3 partner Indofund.id</p>
                                        <p>Step 2 	: Proses Approval 		: Form pinjaman diterima oleh Indofund.id dan akan diproses antara 1-2 hari kerja. Bila ada kekurangan data, maka akan segera dihubungi oleh pihak Indofund.id</p>
                                        <p>Step 3 : Proses Listing			: Setelah borrower menyetujui besaran cicilan per bulan dan durasi pinjaman, maka proyek borrower akan ditampilkan di website Indofund.id dengan durasi listing adalah 2 hari – 30 hari</p>
                                        <p>Step 4 : Pendanaan Terkumpul	: Setelah dana terkumpul maka dana akan masuk pada saldo di user login borrower dan pihak borrower bisa mengirimkan dana tersebut ke rekening tujuan yang telah didaftarkan pada sistem sebelumnya</p>
                                        <img src="{{asset('frontend_images/homepage/tahap-peminjaman.jpg')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three11" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Bagaimana mekanisme pembayaran cicilan ?</h2>
                                    </div>
                                </a>
                                <div id="help-three11" class="collapse">
                                    <div class="panel-body">
                                        <p>Perjanjian pinjam-meminjam akan dibuatkan sesuai dengan hari pertama dana sudah tersedia pada saldo di login username Anda. Dan masa pembayaran cicilan untuk bulan 1 adalah dari hari tersebut hingga 30 hari kedepan (Untuk lebih jelas bisa dilihat pada bagan)</p>
                                        <p>Pembayaran cicilan dilakukan melalui virtual akun yang telah diterbitkan dan akan terkonfirmasi otomatis pada sistem selama besaran nominal yang dibayarkan sesuai dengan besaran yang ada di detail pinjaman.</p>
                                        <p>Untuk lebih jelasnya, silahkan membaca ilustrasi berikut :</p>
                                        <p>1 Februari 2018 – Tuan A mengajukan pinjaman di Indofund.id sebesar Rp 12.000.000</p>
                                        <p>3 Februari 2018 – Tuan A mendapatkan konfirmasi bahwa pinjaman disetujui sebesar Rp 12.000.000 dengan durasi 12 bulan dengan besar cicilan adalah Rp 1.020.000 setiap bulan, dan Tuan A menyetujuinya</p>
                                        <p>4 Februari 2018 – Proyek Tuan A muncul di website Indofund.id dengan masa pengumpulan dana hingga 14 Februari 2018</p>
                                        <p>10 Februari 2018 – Dana telah terkumpul 100% dan dana telah siap di saldo login Tuan A pada Indofund.id</p>
                                        <p>Kontrak pinjam meminjam dikeluarkan oleh Indofund.id untuk Tuan A yaitu 10 Februari 2018 – 10 Februari 2019</p>
                                        <p>Masa pembayaran cicilan adalah sebagai berikut :</p>
                                        <p>10 Feb 18 – 9 Mar 18 : Rp 1.020.000</p>
                                        <p>10 Mar 18 – 9 Apr 18 : Rp 1.020.000</p>
                                        <p>10 Apr 18 – 10 Mei 18 : Rp 1.020.000</p>
                                        <p>dst</p>
                                        <p>Dalam kurun waktu 10 Feb 18 – 9 Mar 18, Tuan A dapat membayarkan cicilan pertamanya sebesar 1.020.000 melalui rekening virtual akun yang tersedia </p>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three12" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Apakah ada biaya keterlambatan bila borrower terlambat dalam melakukan pembayaran?</h2>
                                    </div>
                                </a>
                                <div id="help-three12" class="collapse">
                                    <div class="panel-body">
                                        <p>Ada. Besaran denda atas keterlambatan pembayaran akan dikenakan dengan perhitungan per hari dengan besaran tercantum pada kontrak perjanjian pinjaman</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three13" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Apakah ada mekanisme pembayaran pelunasan dipercepat?</h2>
                                    </div>
                                </a>
                                <div id="help-three13" class="collapse">
                                    <div class="panel-body">
                                        <p>Ada. Pelunasan dipercepat dapat di cek pada perjanjian untuk pelunasan dipercepat atau bisa ditanyakan melalui contact apabila Anda mau melakukan pelunasan dipercepat </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#help-three14" data-toggle="collapse" data-parent="#help-accordion-2">
                                    <div class="panel-heading">
                                        <h2>Apakah meminjam di Indofund.id membutuhkan jaminan?</h2>
                                    </div>
                                </a>
                                <div id="help-three14" class="collapse">
                                    <div class="panel-body">
                                        <p>Setiap pinjaman pastinya akan melekat kewajiban dalam melakukan pembayaran pinjaman hingga lunas. Jaminan adalah salah satu kepastian bagi pihak yang meminjamkan dana (lender) apabila terjadi gagal bayar ataupun ketidaksanggupan dalam melunasi pinjaman.</p>
                                        <p>Indofund.id bukan perbankan yang membutuhkan jaminan berbentuk aset dalam meminjamkan. Jaminan akan kepastian pembayaran adalah wajib dikemukakan oleh borrower namun jaminan berbentuk aset tidak wajib dalam meminjam dana di Indofund.id</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <div class="panel-group" id="help-accordion-3">
                            <div class="panel panel-default panel-help">
                                <a href="#lender1" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Bagaimana menjadi lender di Indofund.id ?</h2>
                                    </div>
                                </a>
                                <div id="lender1" class="collapse in">
                                    <div class="panel-body">
                                        <p>Sangat mudah. Anda cukup melakukan registrasi pada portal Indofund.id silahkan <a href="https://indofund.id/register" target="_blank">klik disini</a> lalu
                                            silahkan Anda kunjungi project list yang saat ini tersedia untuk didanai dengan <a href="https://indofund.id/project-list/debt" target="_blank">klik disini</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender2" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Berapa dana minimum untuk bisa mendanai di Indofund.id ?</h2>
                                    </div>
                                </a>
                                <div id="lender2" class="collapse">
                                    <div class="panel-body">
                                        <p>Rp 50.000 (Lima Puluh Ribu Rupiah)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender3" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Berapa bunga yang akan saya terima ?</h2>
                                    </div>
                                </a>
                                <div id="lender3" class="collapse">
                                    <div class="panel-body">
                                        <p>Berbeda-beda sesuai dengan proyek yang Anda danai. Silahkan Anda cek proyek mengenai ilustrasi pendanaan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender4" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Bagaimana menghitung besaran bunga dan cicilan yang akan dibayarkan kepada saya?</h2>
                                    </div>
                                </a>
                                <div id="lender4" class="collapse">
                                    <div class="panel-body">
                                        <p>Contoh :<br>
                                            Proyek A :<br>
                                            Total Pinjaman Rp 6.000.000<br>
                                            Lama Pinjaman 12 bulan<br>
                                            Besar cicilan per bulan Rp 550.000<br>
                                            Bila Anda mendanai proyek ini sebesar Rp 50.000 maka :<br>
                                            Besar cicilan diterima per bulan = (Rp 50.000)/(Rp 6.000.000) x Rp 550.000 = Rp 4.583
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender5" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Apakah cicilan setiap bulan akan di transfer ke rekening saya?</h2>
                                    </div>
                                </a>
                                <div id="lender5" class="collapse">
                                    <div class="panel-body">
                                        <p>Setiap pembayaran cicilan akan dikirimkan ke saldo pada user akun Anda di Indofund.id dan dapat Anda Tarik (withdraw) kapanpun dengan lama penarikan dana adalah 1x24 jam</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender6" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Berapa penarikan dana minimum dari saldo?</h2>
                                    </div>
                                </a>
                                <div id="lender6" class="collapse">
                                    <div class="panel-body">
                                        <p>Besaran penarikan dana minimum adalah Rp 50.000 </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender7" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Apakah ada biaya penarikan?</h2>
                                    </div>
                                </a>
                                <div id="lender7" class="collapse">
                                    <div class="panel-body">
                                        <p>Ada. besaran dana penarikan adalah Rp 10.000 yang dikenakan setiap kali penarikan dan dipotong dari saldo Anda pada Indofund.id</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender8" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Apa yang terjadi bila borrower terlambat membayar pinjaman?</h2>
                                    </div>
                                </a>
                                <div id="lender8" class="collapse">
                                    <div class="panel-body">
                                        <p>Akan terdapat denda harian atas keterlambatan yang dapat Anda cek di perjanjian pinjam-meminjam, silahkan cek perjanjian tersebut di email Anda pertama kali proses pendanaan berhasil.</p>
                                        <p>Silahkan cek juga poin selanjutnya mengenai gagal bayar.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default panel-help">
                                <a href="#lender9" data-toggle="collapse" data-parent="#help-accordion-3">
                                    <div class="panel-heading">
                                        <h2>Apakah ada potensi gagal bayar dari borrower? Dan bagaimana tanggung jawab Indofund.id ?</h2>
                                    </div>
                                </a>
                                <div id="lender9" class="collapse">
                                    <div class="panel-body">
                                        <p>Dalam melakukan proses Analisa diawal dengan prinsip kehati-hatian, tim Indofund.id berupaya untuk mengurangi segala risiko hingga terjadinya default atau gagal bayar.</p>
                                        <p>Namun Indofund.id juga memiliki standarisasi perusahaan yang akan disetujui untuk meminjam guna mengantisipasi keterlambatatan & gagal bayar, yakni :</p>
                                        <p>1.	Semua proyek di Indofund.id akan memiliki jaminan pembayaran (kemampuan bayar) dari pihak borrower</p>
                                        <p>2.	Proyek di Indofund.id juga menambahkan jaminan aset bila memungkinkan</p>
                                        <p>3.	Indofund.id juga melakukan penagihan melalui pihak ke 3 perusahaan yang memiliki kuasa atas produk / jasa / keuangan dari pihak borrower untuk menyelesaikan pinjaman yang bermasalah</p>
                                        <p>4.	Indofund.id akan melakukan upaya penagihan hingga restrukturisasi pembayaran bila memungkinkan</p>
                                        <p>5.	Indofund.id juga menambahkan program asuransi (opsional) pada pinjaman</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <div class="panel-group" id="help-accordion-4">
                            <div class="panel panel-default panel-help">
                                <a href="#data1" data-toggle="collapse" data-parent="#help-accordion-4">
                                    <div class="panel-heading">
                                        <h2>Keuntungan Lender & Borrower hanya di Indofund.id</h2>
                                    </div>
                                </a>
                                <div id="data1" class="collapse in">
                                    <div class="panel-body">
                                        <p>Setiap member terdaftar di Indofund.id bisa mendapatkan akses program akselerasi yang bermanfaat bagi setiap pribadi, maupun bisnis dan usahanya.</p>
                                        <p>Program akselerasi ini diberikan GRATIS dari Indofund.id melibatkan banyak partner professional agar bisa mengembangkan perekonomian di Indonesia.</p>
                                        <p>Setiap member terdaftar dapat mengakses semua program akselerasi tersebut melalui login area.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @parent
    <style>body {
            margin-top: 30px;
            background-color: #eee;
        }

        .list-group.help-group {
            margin-bottom: 20px;
            padding-left: 0;
            margin: 0;
        }
        .list-group.help-group .faq-list {
            display: block;
            top: auto;
            margin: 0 0 32px;
            border-radius: 2px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 5px rgba(85, 85, 85, 0.15);
        }
        .list-group.help-group .faq-list .list-group-item {
            position: relative;
            display: block;
            margin: 0;
            padding: 13px 16px;
            background-color: #fff;
            border: 0;
            border-bottom: 1px solid #ddd;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
            color: #616161;
            transition: background-color .2s;
        }
        .list-group.help-group .faq-list .list-group-item i.mdi {
            margin-right: 5px;
            font-size: 18px;
            position: relative;
            top: 2px;
        }
        .list-group.help-group .faq-list .list-group-item:hover {
            background-color: #f6f6f6;
        }
        .list-group.help-group .faq-list .list-group-item.active {
            background-color: #f6f6f6;
            font-weight: 700;
            color: rgba(0, 0, 0, 0.87);
        }
        .list-group.help-group .faq-list .list-group-item:last-of-type {
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            border-bottom: 0;
        }

        .tab-content.panels-faq {
            padding: 0;
            border: 0;
        }

        .panel.panel-help {
            box-shadow: 0 1px 5px rgba(85, 85, 85, 0.15);
            padding-bottom: 0;
            border-radius: 2px;
            overflow: hidden;
            background-color: #fff;
            margin: 0 0 16px;
        }
        .panel.panel-help a[href^="#"],
        .panel.panel-help a[href^="#"]:hover,
        .panel.panel-help a[href^="#"]:focus {
            outline: none;
            cursor: pointer;
            text-decoration: none;
        }
        .panel.panel-help .panel-heading {
            background-color: #f6f6f6;
            padding: 0 16px;
            line-height: 48px;
            border-top-right-radius: 2px;
            border-top-left-radius: 2px;
            color: rgba(0, 0, 0, 0.87);
        }
        .panel.panel-help .panel-heading h2 {
            margin: 0;
            padding: 14px 0 14px;
            font-size: 18px;
            font-weight: 400;
            line-height: 20px;
            letter-spacing: 0;
            text-transform: none;
        }
        .panel.panel-help .panel-body {
            background-color: #fff;
            border-top: 1px solid #ddd;
            border-radius: 2px;
            border-top-right-radius: 0;
            border-top-left-radius: 0;
            margin-top: 0;
        }
        .panel.panel-help .panel-body p {
            margin: 0 0 16px;
        }
        .panel.panel-help .panel-body p:last-of-type {
            margin: 0;
        }

    </style>
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            // Since there's no list-group/tab integration in Bootstrap
            $(".list-group-item").on("click", function(e) {
                var previous = $(this)
                    .closest(".list-group")
                    .children(".active");
                previous.removeClass("active"); // previous list-item
                $(e.target).addClass("active"); // activated list-item
            });
        });

    </script>
@endsection