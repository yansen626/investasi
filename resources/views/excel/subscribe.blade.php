<table>
    <thead>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Nomor HP</th>
        <th>Tanggal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subscribeListDB as $subscribe)
        <tr>
            <td>{{ $subscribe->name }}</td>
            <td>{{ $subscribe->email }}</td>
            <td>{{ $subscribe->phone }}</td>
            <td>{{ $subscribe->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>