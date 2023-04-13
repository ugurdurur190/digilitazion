@extends('layouts.menu')
@section('content')
<div class="col-lg-12">

		<div class="row">
			<div class="col-3">
				<h4 style="color: #5A378C;">Anket Sonuçları</h4>
			</div>
			
		</div>
	<hr style="border-color:black;">
	<div class="card card-outline">

		<div class="card-header" style="background-color: white;border-top:5px solid #660066;">
			<br/>
			@if ($message = Session::get('warning'))
			<div class="alert alert-warning">
				<strong>{{ $message }}</strong>
			</div>
			@endif
		</div>

		<div class="card-body">
			<table class="table tabe-hover table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="30%">

				</colgroup>
				<thead style="border-width: 3px;">

					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proje Sahibi</th>
						<th class="text-center">Başlık</th>
						<th class="text-center">Açıklama</th>
						<th class="text-center">Görüntüle</th>
					</tr>

				</thead>
				<tbody style="border-width: 3px;">

					@foreach($projects as $project)
							@if($project->state_id != null && $project->score == null)
								<tr>
									<th class="text-center">{{$loop->iteration}}</th>
									<td class="text-center small">{{$users->where('id',$project->user_id)->value('name')}}<br/></td>
									<td class="text-center small">{{$project->title}}</td>
									<td class="text-center small">{{$project->description}}</td>
									<td class="text-center">
										<div>
											<a class="btn btn-flat" href="{{ url('projects/votes/reports/view',[$project->id]) }}">
												<i style="color: black;" class="fa fa-eye fa-lg"></i>
											</a>
										</div>
									</td>
								</tr>
							@endif
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
</div>
@endsection