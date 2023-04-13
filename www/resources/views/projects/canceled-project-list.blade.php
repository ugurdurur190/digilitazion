@extends('layouts.menu')
@section('content')
<div class="col-lg-12">

	<div class="row">
		<div class="col-4">
			<h4 style="color: #5A378C;">İPTAL EDİLEN PROJELER</h4>
		</div>
		
	</div>
    <p class="small" style="color: #190F26;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Bu alanda iptal edilen projeler bulunur. Admin projeleri tekrar oylamaya açabilir.</p>
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
					<col width="12%">
					<col width="35%">
					<col width="20%">
					<col width="13%">
					<col width="15%">
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proje Sahibi</th>
						<th class="text-center">Başlık</th>
						<th class="text-center">Aksiyon</th>
						<th class="text-center">Değerlendirme Oranı</th>
						<th class="text-center">Proje Durumu</th>
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
											
											<a class="btn btn-flat" href="{{ url('projects/todoes/works/view',[$project->id]) }}">
												<i style="color: black;" class="fa fa-list fa-lg"></i>
											</a>
											
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
								
                                    @if(empty($project->score))
										@if($votes->where('project_id',$project->id)->count() != 0)
									    	<th class="text-center"><b style="color:#ff0000;">%{{ round((($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->sum('vote')+($votes->where('project_id',$project->id)->where('privilege_id',3)->sum('vote')*10))*100) / (($voteQuestions->where('project_id',$project->id)->where('state',1)->count()*5)*(($votes->where('project_id',$project->id)->where('privilege_id','<>',3)->unique('user_id')->count())+($votes->where('project_id',$project->id)->where('privilege_id',3)->unique('user_id')->count()*10))),0) }}</b></th>
										@else
											<th class="text-center"><b style="color:#ff0000;">%0</b></th>
										@endif
                                    @else
                                        <th class="text-center"><b style="color:#ff0000;">%{{ $project->score }}</b></th>
                                    @endif


									<td class="text-center" style="color:#660066;">
										
										<div class="col small">
											@foreach($situations as $situation)
												{{ $project->state_id == $situation->id ? $situation->state : '' }}
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
								
								</tr>
					@endforeach
                    

					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection