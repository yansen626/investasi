<table>
    <thead>
    <tr>
        <th>id_penyelenggara</th>
        <th>id_pinjaman</th>
        <th>id_borrower</th>
        <th>id_lender</th>
        <th>id_transaksi</th>

        <th>id_pembayaran</th>
        <th>tgl_pembayaran</th>
        <th>tgl_pembayaran_borrower</th>
        <th>tgl_pembayaran_penyelenggara</th>
        <th>sisa_pinjaman_berjalan</th>

        <th>id_status_pinjaman</th>
        <th>tgl_pelunasan_borrower</th>
        <th>tgl_pelunasan_penyelenggara</th>
        <th>denda</th>
        <th>nilai_pembayaran</th>

        <th>id_jenis_pembayaran</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subscribeListDB as $productInstallment)
        <tr>
            <td>810049</td>
            <td>{{ $productInstallment->id }}</td>
            <td>{{ $productInstallment->Product->vendor_id }}</td>
            <td>{{ $productInstallment->Product->user_id }}</td>
            <td></td>

            <td>{{ $productInstallment->name }}</td>
            <td>{{ \Carbon\Carbon::parse($productInstallment->due_date)->format('j M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($productInstallment->due_date)->format('j M Y') }}</td>
            <td></td>
            <td></td>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{--<table>--}}
    {{--<thead>--}}
    {{--<tr>--}}
        {{--<th>id_penyelenggara</th>--}}
        {{--<th>id_pinjaman</th>--}}
        {{--<th>id_borrower</th>--}}
        {{--<th>id_syariah</th>--}}
        {{--<th>id_status_pengajuan_pinjaman</th>--}}

        {{--<th>nama_pinjaman</th>--}}
        {{--<th>tgl_pengajuan_pinjaman</th>--}}
        {{--<th>nilai_permohonan_pinjaman</th>--}}
        {{--<th>jangka_waktu_pinjaman</th>--}}
        {{--<th>satuan_jangka_waktu_pinjaman</th>--}}
        {{--<th>penggunaan_pinjaman</th>--}}

        {{--<th>jenis_agunan</th>--}}
        {{--<th>rasio_pinjaman_nilai_agunan</th>--}}
        {{--<th>permintaan_jaminan</th>--}}
        {{--<th>rasio_pinjaman_aset</th>--}}
        {{--<th>cicilan_bulan</th>--}}

        {{--<th>rating_pengajuan_pinjaman</th>--}}
        {{--<th>nilai_plafond</th>--}}
        {{--<th>nilai_pengajuan_pinjaman</th>--}}
        {{--<th>suku_bunga_pinjaman</th>--}}
        {{--<th>satuan_suku_bunga_pinjaman</th>--}}

        {{--<th>jenis_bunga</th>--}}
        {{--<th>tgl_mulai_publikasi_pinjaman</th>--}}
        {{--<th>rencana_jangka_waktu_publikasi</th>--}}
        {{--<th>realisasi_jangka_waktu_publikasi</th>--}}
        {{--<th>tgl_mulai_pendanaan</th>--}}

        {{--<th>frekuensi_pinjaman</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--@foreach($subscribeListDB as $product)--}}
        {{--<tr>--}}
            {{--<td>810049</td>--}}
            {{--<td>{{ $product->id }}</td>--}}
            {{--<td>{{ $product->vendor_id }}</td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}

            {{--<td>{{ $product->name }}</td>--}}
            {{--<td>{{ \Carbon\Carbon::parse($product->created_on)->format('j M Y') }}</td>--}}
            {{--<td>{{ $product->raising }}</td>--}}
            {{--<td>{{ $product->tenor_loan }}</td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}

            {{--<td></td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}

            {{--<td></td>--}}
            {{--<td></td>--}}
            {{--<td>{{ $product->raising }}</td>--}}
            {{--<td>{{ $product->interest_rate }}</td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}

            {{--<td></td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}
            {{--<td></td>--}}

            {{--<td></td>--}}
        {{--</tr>--}}
    {{--@endforeach--}}
    {{--</tbody>--}}
{{--</table>--}}