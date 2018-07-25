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
            <td>{{ $walletStatement->user->first_name }} {{ $walletStatement->user->last_name }}</td>
            <td>{{ $walletStatement->bank_acc_number }}</td>
            <td>{{ $walletStatement->bank_name }}</td>
            <td>{{ (int) str_replace('.', '',$walletStatement->transfer_amount) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>