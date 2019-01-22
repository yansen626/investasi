<table>
    <thead>
    <tr>
        <th>id_penyelenggara</th>
        <th>id_lender</th>
        <th>nama_lender</th>
        <th>no_ktp</th>
        <th>no_npwp</th>
        <th>tempat_lahir</th>
        <th>tgl_lahir</th>
        <th>id_jenis_kelamin</th>
        <th>alamat</th>
        <th>id_kota</th>
        <th>id_provinsi</th>
        <th>kode_pos</th>
        <th>id_status_perkawinan</th>
        <th>id_pendidikan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subscribeListDB as $lender)
        <tr>
            <td>810049</td>
            <td>{{ $lender->id }}</td>
            <td>{{ $lender->first_name }} {{ $lender->last_name }}</td>
            <td>"{{ $lender->identity_number }}"</td>
            <td>{{ $lender->npwp }}</td>
            <td>{{ $lender->place_of_birth }}</td>
            <td>
                @if($lender->dob != null)
                    {{ \Carbon\Carbon::parse($lender->dob)->format('j M Y') }}
                    @else
                    ""
                @endif
            </td>
            <td>{{ $lender->gender }}</td>
            <td>{{ $lender->address_ktp }}</td>
            <td>{{ $lender->city_ktp }}</td>
            <td>{{ $lender->province_ktp }}</td>
            <td>{{ $lender->postal_code_ktp }}</td>
            <td>{{ $lender->marital_status }}</td>
            <td>{{ $lender->education }}</td>
        </tr>
    @endforeach
    </tbody>
</table>