@php
    use Carbon\Carbon;
    $saldo=$saldo_awal;
    $pemasukan=0;
    $pengeluaran=0;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kas Umum</title>
    {{-- <style>
        table {
        border-collapse: collapse;
        }

        table, td, th {
        border: 1px solid black;
        }
    </style> --}}
</head>
<body>

    @php

    switch ($bulan) {
        case 1:
            $bulan='JANUARI';
            break;
        case 2:
        $bulan='FEBRUARI';
            break;
        case 3:
        $bulan='MARET';
            break;
        case 4:
        $bulan='APRIL';
            break;
        case 5:
        $bulan='MEI';
            break;
        case 6:
        $bulan='JUNI';
            break;
        case 7:
        $bulan='JULI';
            break;
        case 8:
        $bulan='AGUSTUS';
            break;
        case 9:
        $bulan='SEPTEMBER';
            break;
        case 10:
        $bulan='OKTOBER';
            break;
        case 11:
        $bulan='NOVEMBER';
            break;
        case 12:
        $bulan='DESEMBER';
            break;
    }
    // Bulan Akhir
    switch ($bulan_akhir) {
        case 1:
            $bulan_akhir='JANUARI';
            break;
        case 2:
        $bulan_akhir='FEBRUARI';
            break;
        case 3:
        $bulan_akhir='MARET';
            break;
        case 4:
        $bulan_akhir='APRIL';
            break;
        case 5:
        $bulan_akhir='MEI';
            break;
        case 6:
        $bulan_akhir='JUNI';
            break;
        case 7:
        $bulan_akhir='JULI';
            break;
        case 8:
        $bulan_akhir='AGUSTUS';
            break;
        case 9:
        $bulan_akhir='SEPTEMBER';
            break;
        case 10:
        $bulan_akhir='OKTOBER';
            break;
        case 11:
        $bulan_akhir='NOVEMBER';
            break;
        case 12:
        $bulan_akhir='DESEMBER';
            break;
    }
    @endphp

    <table class="table table-hover nowrap" id="example1">
        <thead>
        <tr>
            <th colspan="6">BUKU KAS UMUM GEREJA</th>
        </tr>
        <tr>
            <th colspan="6">JEMAAT SION YAMARA</th>
        </tr>
        <tr>
            <th colspan="6">BULAN {{ $bulan }} SAMPAI {{ $bulan_akhir }} TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th colspan="6">BUKU KAS UMUM</th>
        </tr>
        <tr>
            <th colspan="6"> <hr> </th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Tgl Kas</th>
            <th>Uraian</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
            <th>Saldo</th>
        </tr>
        </thead>
        <tbody>
            @if ($kas->count()!=0)
            <tr>
              <td colspan="5">Sisa Saldo</td>
              <td>@currency ($saldo)</td>
            </tr>
            @endif
            @forelse ($kas as $item)

            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ Carbon::parse($item->tgl_kas)->format('d-m-Y') }}</td>
              <td>
                {{ $item->transaksi->nm_transaksi }}
              </td>
              <td>
                @if ($item->pemasukan==0)
                    -
                @else
                  @php
                      $pemasukan+=$item->pemasukan
                  @endphp
                  @currency($item->pemasukan)
                @endif
              </td>
              <td>
                @if ($item->pengeluaran==0)
                    -
                @else
                  @php
                      $pengeluaran+=$item->pengeluaran
                  @endphp
                  @currency($item->pengeluaran)
                @endif
              </td>
              <td>
                @if ($item->pengeluaran==0)
                  @currency($saldo=$item->pemasukan+$saldo)
                @endif
                @if ($item->pemasukan==0)
                  @currency($saldo=$saldo-$item->pengeluaran)
                @endif
              </td>
            </tr>

            @empty
                <td colspan="6" class="text-center">Silahkan Memilih Tahun dan Bulan</td>
            @endforelse
            @if ($kas->count()!=0)

            @php
                $saldoAkhir=$saldo;
            @endphp
            <tr class="text-bold">
              <td>-</td>
              <td>-</td>
              <td>Total Derma dan Pengucapan Syukur @currency($presentaseSkrg)</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
            </tr>
            <tr class="text-bold">
              <td>-</td>
              <td>-</td>
              <td>SWJ 40% Sinode + Perpuluhan</td>
              <td>-</td>
              <td>@currency($Swj40PerPul=((40/100)*$presentaseSkrg)+$perpuluhan)</td>
              <td>@currency($saldo=$saldo-$Swj40PerPul)</td>
            </tr>
            <tr>
              <td>-</td>
              <td>-</td>
              <td>SWJ 20% Klasis</td>
              <td>-</td>
              <td>@currency($swj20=(20/100)*$presentaseSkrg)</td>
              <td>@currency($saldo=$saldo-$swj20)</td>
            </tr>
            <tr class="font-weight-bold">
              <td colspan="3" class="text-center">Total </td>
              <td>
                @currency($pemasukan)
              </td>
              <td>
                @currency($pengeluaran=$pengeluaran+$Swj40PerPul+$swj20)
              </td>
              <td>

              </td>
            </tr>
            <tr class="font-weight-bold">
              <td colspan="5" class="text-center">Sisa Saldo</td>
              <td>@currency($saldo)</td>
            </tr>
            @endif
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">Ketua Jemaat</td>
                <td></td>
                <td colspan="2">Bendahara</td>
            </tr>
            <tr>
                <td colspan="6" height=50px></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">Pdt.Rode Yuliana. Andoi S.Th</td>
                <td></td>
                <td colspan="2">Pnt.Barbalince. Andarek</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
