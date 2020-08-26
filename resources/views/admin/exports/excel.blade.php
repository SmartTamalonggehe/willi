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
</head>
<body>

    @php
    foreach ($kas as $item) {
        $thnPilihan=Carbon::parse($item->tgl_kas)->format('Y');
        $bulanPilihan=Carbon::parse($item->tgl_kas)->format('m');
    }
    switch ($bulanPilihan) {
        case 1:
            $bulanPilihan='JANUARI';
            break;
        case 2:
        $bulanPilihan='FEBRUARI';
            break;
        case 3:
        $bulanPilihan='MARET';
            break;
        case 4:
        $bulanPilihan='APRIL';
            break;
        case 5:
        $bulanPilihan='MEI';
            break;
        case 6:
        $bulanPilihan='JUNI';
            break;
        case 7:
        $bulanPilihan='JULI';
            break;
        case 8:
        $bulanPilihan='AGUSTUS';
            break;
        case 9:
        $bulanPilihan='SEPTEMBER';
            break;
        case 10:
        $bulanPilihan='OKTOBER';
            break;
        case 11:
        $bulanPilihan='NOVEMBER';
            break;
        case 12:
        $bulanPilihan='DESEMBER';
            break;
    }
    @endphp

    <table class="table table-hover nowrap" id="example1">
        <thead>
        <tr>
            <th>BUKU KAS UMUM GEREJA</th>
        </tr>
        <tr>
            <th>JEMAAT SION YAMARA</th>
        </tr>
        <tr>
            <th>BULAN {{ $bulanPilihan }} TAHUN {{ $thnPilihan }}</th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>BUKU KAS UMUM</th>
        </tr>
        <tr>
            <th></th>
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
