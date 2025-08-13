@php
    // Helper to pull tracking notes into a single column
    function tracking_notes_inline($tracking)
    {
        $order = ['WO Diterima', 'Timbang', 'Selesai Timbang', 'Potong Stock', 'Released', 'Kirim BB', 'Kirim CPB/WO'];
        $chunks = [];
        foreach ($order as $name) {
            $t = $tracking->firstWhere('status_name', $name);
            if ($t && $t->notes) {
                $chunks[] = $name . ': ' . $t->notes;
            }
        }
        return implode(', ', $chunks);
    }
@endphp

<table>
    <tr>
        <td>Rekapitulasi WO</td>
    </tr>
    <tr>
        <td>Bulan: {{ ucfirst($titleMonth) }}</td>
    </tr>
    <tr></tr>
    <tr>
        <th>WO Diterima</th>
        <th>Due Date</th>
        <th>No Work Order</th>
        <th>Nama Produk</th>
        <th>Group</th>
        <th>Status</th>
        <th>Mulai Timbang</th>
        <th>Selesai Timbang</th>
        <th>Potong Stock</th>
        <th>Released</th>
        <th>Kirim BB</th>
        <th>Kirim CPB/WO</th>
        <th>Released - Selesai Timbang (hari)</th>
        <th>Kirim BB - Due Date (hari)</th>
        <th>Kirim CPB/WO - Kirim BB (hari)</th>
        <th>Keterangan</th>
    </tr>
    @foreach ($rows as $wo)
        @php
            $getDate = function ($name) use ($wo) {
                $v = optional($wo->tracking->firstWhere('status_name', $name))->completed_at;
                return $v ? $v->format('d-m-Y') : '';
            };
        @endphp
        <tr>
            <td>{{ $getDate('WO Diterima') }}</td>
            <td>{{ optional($wo->due_date)->format('d-m-Y') }}</td>
            <td>{{ $wo->wo_number }}</td>
            <td>{{ $wo->output }}</td>
            <td>{{ optional($wo->masterProduct)->group }}</td>
            <td>{{ $wo->status }}</td>
            <td>{{ $getDate('Mulai Timbang') }}</td>
            <td>{{ $getDate('Selesai Timbang') }}</td>
            <td>{{ $getDate('Potong Stock') }}</td>
            <td>{{ $getDate('Released') }}</td>
            <td>{{ $getDate('Kirim BB') }}</td>
            <td>{{ $getDate('Kirim CPB/WO') }}</td>
            @php
                $raw = function ($name) use ($wo) {
                    $v = optional($wo->tracking->firstWhere('status_name', $name))->completed_at;
                    return $v ? \Carbon\Carbon::parse($v) : null;
                };
                $released = $raw('Released');
                $selesai = $raw('Selesai Timbang');
                $kirimBb = $raw('Kirim BB');
                $kirimCpb = $raw('Kirim CPB/WO');
                $due = $wo->due_date ? \Carbon\Carbon::parse($wo->due_date) : null;
                $diff1 = $released && $selesai ? $selesai->diffInDays($released, false) : '';
                $diff2 = $kirimBb && $due ? $due->diffInDays($kirimBb, false) : '';
                $diff3 = $kirimCpb && $kirimBb ? $kirimBb->diffInDays($kirimCpb, false) : '';
            @endphp
            <td>{{ $diff1 }}</td>
            <td>{{ $diff2 }}</td>
            <td>{{ $diff3 }}</td>
            <td>{{ tracking_notes_inline($wo->tracking) }}</td>
        </tr>
    @endforeach

    <tr></tr>
    <tr>
        <td><strong>Total WO bulan ini:</strong></td>
        <td><strong>{{ $total }}</strong></td>
    </tr>
</table>
