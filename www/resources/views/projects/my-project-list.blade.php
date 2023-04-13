@extends('layouts.menu')
@section('content')
<div class="col-lg-12">
    <h4 style="color: #5A378C;">PROJELER</h4>
	@if(Auth::user()->privilege_id == '1')
    	<p class="small" style="color: #190F26;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Bu alanda "Admin" olan kullanıcılar projeleri güncelleyebilir. Ve bu alanda iptal edilen projeler gösterilmez. </p>
	@else
		<p class="small" style="color: #190F26;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Kullanıcılar bu alanda kendi proje bilgilerini, sorulara ve mevcut süreçlere verdikleri cevapları güncelleyebilir. Ve bu alanda iptal edilen projeleriniz gösterilmez. </p>
	@endif
	<hr style="border-color:black;">
	<div class="card card-outline mb-5">
		<div class="card-header" style="background-color: white;border-top:5px solid #660066;">
			<br/>
			<div class="card-tools">
				@if ($message = Session::get('success'))
				<div class="alert alert-success">
					<strong>{{ $message }}</strong>
				</div>
				@endif
				@if ($message = Session::get('warning'))
				<div class="alert alert-warning">
					<strong>{{ $message }}</strong>
				</div>
				@endif
			</div>
		</div>
		
		<div class="card-body">
			<table class="table tabe-hover table-bordered" style="table-layout: fixed;">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="30%">
					<col width="30%">
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proje Sahibi</th>
						<th class="text-center">Başlık</th>
						<th class="text-center">Aksiyon</th>
					</tr>
				</thead>
				<tbody style="border-width: 3px;">
						@if(Auth::user()->privilege_id == '1')
							@foreach($projects as $project)
								<tr>
									<th class="text-center">{{$loop->iteration}}</th>
									<td class="text-center small">{{$users->where('id',$project->user_id)->value('name')}}<br/></td>
									<td class="text-center small">{{$project->title}}</td>
									<td class="text-center">
										<a class="btn btn-flat" href="{{ url('my-projects/view',[$project->id]) }}">
											<i style="color: black;" class="fa fa-eye fa-lg"></i>
										</a>
									</td>
								</tr>
							@endforeach

						@else

							@foreach($projects->where('user_id',Auth::user()->id) as $project)
								<tr>
									<th class="text-center">{{$loop->iteration}}</th>
									<td class="text-center">{{$users->where('id',$project->user_id)->value('name')}}<br/></td>
									<td class="text-center">{{$project->title}}</td>
									<td class="text-center">
										<a class="btn btn-flat" href="{{ url('my-projects/view',[$project->id]) }}">
											<i style="color: black;" class="fa fa-eye fa-lg"></i>
										</a>
									</td>
								</tr>
							@endforeach

						@endif

					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection