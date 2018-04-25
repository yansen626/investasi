<table>
    <thead>
    <tr>
        <th>Nama</th>
        <th>No Rek</th>
        <th>Bank</th>
        <th>Nominal Transfer</th>
    </tr>
    </thead>
    <tbody>
    @foreach($walletStatementDB as $walletStatement)
        <tr>
            <td>{{ $walletStatement->name }}</td>
            <td>{{ $walletStatement->bank_acc_number }}</td>
            <td>{{ $walletStatement->bank_name }}</td>
            <td>{{ $walletStatement->transfer_amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>