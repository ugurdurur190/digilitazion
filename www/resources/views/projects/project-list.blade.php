@extends('layouts.menu')
@section('content')
<div class="col-lg-12">

	<div class="row">
		<div class="col-3">
			<h4 style="color: #5A378C;">Proje Listesi</h4>
		</div>
		
	</div>
    <p class="small" style="color: #190F26;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Bu alanda gönderilen tüm "Proje Fikirleri" bulunur. "Birim Onayı" ve "Proje Oylaması" bu alanda yapılır. </p>
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
					<col width="5%"/>
					<col width="12%"/>
					<col width="20%"/>
					<col width="25%"/>
					<col width="10%"/>
					<col width="15%"/>
					<col width="13%"/>
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proje Sahibi</th>
						<th class="text-center">Başlık</th>
						<th class="text-center">Aksiyon</th>
						@if(Auth::user()->privilege_id != '5')
							<th class="text-center">Oylama Durumunuz</th>
						@endif
						<th class="text-center">Proje Durumu</th>
						<th class="text-center">Değerlendirme Oranı</th>
					</tr>
				</thead>
				<tbody style="border-width: 3px;">
					@foreach($projects as $project)
								<tr>
									<th class="text-center">{{$loop->iteration}}</th>
									<td class="text-center small">{{$users->where('id',$project->user_id)->value('name')}}<br/></td>
									<td class="text-center small">{{$project->title}}</td>
									<td class="text-center">
										<div>
											<a class="btn btn-flat" href="{{ url('projects/view',[$project->id]) }}">
												<i style="color: black;" class="fa fa-eye fa-lg"></i>
											</a>
											@if(Auth::user()->privilege_id == '1' || Auth::user()->privilege_id == '4')
												<a class="btn btn-flat" href="{{ url('projects/units/approval',[$project->id]) }}">
													<i style="color: black;" class="fa fa-edit fa-lg"></i>
												</a>
											@endif
											@if(Auth::user()->privilege_id == '1')
												<a class="btn btn-flat" href="{{ url('projects/votes/questions/manage',[$project->id]) }}">
													<i style="color: black;" class="fa fa-cog fa-lg"></i>
												</a>
											@endif
											@if(Auth::user()->privilege_id != '5')
												<a class="btn btn-flat" href="{{ url('projects/vote',[$project->id]) }}">
													<i style="color: black;" class="fa fa-check fa-lg"></i>
												</a>
											@endif
											@if(Auth::user()->privilege_id == '1')
												<button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal{{$project->id}}">
														<i class="fa fa-trash fa-lg text-danger"></i>
												</button>
												<div class="modal fade" id="exampleModal{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Onayla</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<p style="color:#8B0000;">{{$project->title}}</P> isimli projeyi silmek istediğinize emin misiniz ?
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
																<a class="btn btn-outline-danger delete" href="{{ url('projects/delete',[$project->id]) }}">
																	Sil
																</a>
															</div>
														</div>
													</div>
												</div>
											@endif
										</div>
									</td>
									@if(Auth::user()->privilege_id != '5')
										@if(in_array($project->id,$voteDone))
											<td style="color:green;" class="text-center small"><b> Oylandı</b></td>
										@else
											<td style="color:red;" class="text-center small"><b> Oylanmadı</b></td>
										@endif
									@endif
								
									
									@if($project->state_id == null)
										<td class="text-center" style="color:#660066;">Fikir</td>
									@else

										<td class="text-center" style="color:#660066;">
											<div class="col small">
												@foreach($situations as $situation)
													{{ $project->state_id == $situation->id ? $situation->state : '' }}
												@endforeach
												
												@foreach($canceledProjects as $canceledProject)
													@if($project->id == $canceledProject->project_id)
														(TKR-%{{ $canceledProject->score }})
													@endif
												@endforeach
												<br/>

												<a class="btn btn-flat" href="{{ url('projects/situations/filters/activites',[$project->id]) }}">
													<i style="color: black;" class="fa fa-comment fa-sm"></i>
												</a>
												@if(Auth::user()->privilege_id == '1')
													<a class="btn btn-flat" href="{{ url('projects/situations/filters',[$project->id]) }}">
														<i style="color: black;" class="fa fa-filter fa-sm"></i>
													</a>
												@endif
											</div>
										</td>
									@endif

									
									@if($votes->where('project_id',$project->id)->count() != 0)
									    <th class="text-center"><b style="color:#ff0000;">%{{ round((($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->sum('vote')+($votes->where('project_id',$project->id)->where('privilege_id',3)->sum('vote')*10))*100) / (($voteQuestions->where('project_id',$project->id)->where('state',1)->count()*5)*(($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->unique('user_id')->count())+($votes->where('project_id',$project->id)->where('privilege_id',3)->unique('user_id')->count()*10))),0) }}</b></th>
									@else
										<th class="text-center"><b style="color:#ff0000;">%0</b></th>
									@endif

								</tr>
					@endforeach

					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection