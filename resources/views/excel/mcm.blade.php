<table>
    <thead>
    <tr>
        <th>key1</th>
        <th>key2</th>
        <th>key3</th>
        <th>currency</th>
        <th>nama</th>
        <th>Bill info 2</th>
        <th>Bill info 3</th>
        @for($i=5; $i<=9; $i++)
            <th>bill_info_0{{$i}}</th>
        @endfor
        @for($i=10; $i<=26; $i++)
            <th>bill_info_{{$i}}</th>
        @endfor
        <th>periode_open</th>
        <th>periode_close</th>
        @for($i=1; $i<=9; $i++)
            <th>subbill_0{{$i}}</th>
        @endfor
        @for($i=10; $i<26; $i++)
            <th>subbill_{{$i}}</th>
        @endfor
        <th>end_record</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customerListDB as $customerList)
        <tr>
            <td>{{ $customerList->va_acc }}</td>
            <td></td>
            <td></td>
            <td>IDR</td>
            <td>{{ strtoupper($customerList->first_name) }} {{ strtoupper($customerList->last_name) }}</td>
            @for($i=2; $i<26; $i++)
                <th></th>
            @endfor
            <td>20180505</td>
            <td>20220831</td>
            <td>01\TOTAL\TOTAL\10</td>
            @for($i=2; $i<26; $i++)
                <th>\\\</th>
            @endfor
            <td>~</td>
        </tr>
    @endforeach
    </tbody>
</table>