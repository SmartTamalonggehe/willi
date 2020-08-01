@php
  use Illuminate\Support\Carbon;
  $saldo=$saldo_awal;
  $pemasukan=0;
  $pengeluaran=0;
@endphp

<table class="table table-hover nowrap" id="example1">
    <thead>
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
      {{-- Menetapkan Saldo dikurang perpuluahan --}}
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
    </tbody>
</table>


<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('toolsAdmin/plugins/custom/datatables/datatables.bundle.js?v=7.0.5') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('toolsAdmin/js/pages/crud/datatables/data-sources/html.js?v=7.0.5') }}"></script>
<!--end::Page Scripts-->
