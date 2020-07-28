@extends('admin.layouts.default')

@section('judul','Dashboard')

@section('Dashboard',' menu-item-active')

@section('css')
	<!--begin::Page Vendors Styles(used by this page)-->
	<link href="{{ asset('toolsAdmin/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles-->
@endsection

@section('content')

{{-- Pemasuakn --}}
<div class="row">
	<div class="col-sm-6">
		<div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
			<span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"/>
						<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
						<path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
					</g>
				</svg>
				<!--end::Svg Icon-->
				<span class="ml-2 text-primary font-weight-bold font-size-h6">Pemasukan Bulan ini</span>
			</span>
			<span class="ml-2 text-primary font-weight-bold font-size-h6">@currency($kasBulanIni->sum('pemasukan'))</span>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
			<span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"/>
						<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
						<path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
					</g>
				</svg>
				<!--end::Svg Icon-->
				<span class="ml-2 text-primary font-weight-bold font-size-h6">Pemasukan Tahun ini</span>
			</span>
			<span class="ml-2 text-primary font-weight-bold font-size-h6">@currency($kasTahunIni->sum('pemasukan'))</span>
		</div>
	</div>
</div>

{{-- Pengeluaran --}}
<div class="row">
	<div class="col-sm-6">
		<div class="col bg-light-danger px-6 py-8 rounded-xl mb-7">
			<span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"/>
						<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
						<rect fill="#000000" x="6" y="11" width="12" height="2" rx="1"/>
					</g>
				</svg>
				<!--end::Svg Icon-->
				<span class="ml-2 text-danger font-weight-bold font-size-h6">Pengeluaran Bulan ini</span>
			</span>
			<span class="ml-2 text-danger font-weight-bold font-size-h6">@currency($kasBulanIni->sum('pengeluaran'))</span>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="col bg-light-danger px-6 py-8 rounded-xl mb-7">
			<span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"/>
						<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
						<rect fill="#000000" x="6" y="11" width="12" height="2" rx="1"/>
					</g>
				</svg>
				<!--end::Svg Icon-->
				<span class="ml-2 text-danger font-weight-bold font-size-h6">Pengeluaran Tahun ini</span>
			</span>
			<span class="ml-2 text-danger font-weight-bold font-size-h6">@currency($kasTahunIni->sum('pengeluaran'))</span>
		</div>
	</div>
</div>

@endsection

@section('js')
	<!--begin::Page Vendors(used by this page)-->
	<script src="{{ asset('toolsAdmin/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.5') }}"></script>
	<!--end::Page Vendors-->
	<!--begin::Page Scripts(used by this page)-->
	<script src="{{ asset('toolsAdmin/js/pages/widgets.js?v=7.0.5') }}"></script>
	<!--end::Page Scripts-->
@endsection
