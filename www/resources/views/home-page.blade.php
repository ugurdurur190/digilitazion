@extends('layouts.menu')
    @section('content')
		@if(($unapprovedProjectCount != 0 || $unratedProjectCount != 0) && Auth::user()->privilege_id != 5)
			<script>
				$(window).on('load', function() {
							$('#bigModal').modal('show');
						});
			</script>
		@endif

        <div class="text-center" style="color: #660066; margin-left: -150px;">
        
				@if ($message = Session::get('success'))
					<div class="alert alert-success" style="margin-left: 10px;">
						<strong>{{ $message }}</strong>
					</div>
				@endif

				@if ($message = Session::get('warning'))
					<div class="alert alert-warning" style="margin-left: 10px;">
						<strong>{{ $message }}</strong>
					</div>
				@endif
        
          <h2>DİJİTALLEŞME PROJELERİ YÖNETİM SİSTEMİNE HOŞGELDİN</h2>
          <h1>{{ Auth::user()->name }}</h1>
          <img src="{{ asset('assets/img/sefamerve2.png') }}" alt="">
        </div>
 @endsection

 