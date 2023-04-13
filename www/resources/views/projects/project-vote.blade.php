@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#vote-store').on('submit', function () {
				$('#store-submit').attr('disabled', 'true');
			});

			$('#vote-update').on('submit', function () {
				$('#update-submit').attr('disabled', 'true');
			});

			$(".voteQuestion").hover(function(){
				$(this).css("background-color", "#EDE9F2");
				}, function(){
				$(this).css("background-color", "#FFFFFF");
			});
        });
    </script>
	<div class="d-flex justify-content-center">
		<div class="col-lg-10">
			<div class="card card-outline">
				<div class="card-header" style="background-color: white;border-top:5px solid #660066;">
					<div class="card-tools text-center">
						<h4 class="text-center" style="color: #5A378C;">Proje Değerlendirme Anketi</h4>
						<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#voteProjectInfo">
							Proje Bilgileri
						</button>
						<br>
					</div>
						@if ($message = Session::get('success'))
							<div class="alert alert-success">   
								<strong>{{ $message }}</strong>
							</div>
						@endif
				</div>

				<div class="card-body">

					<div class="modal fade" id="voteProjectInfo" tabindex="-1" aria-labelledby="voteProjectLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="voteProjectLabel">Proje Bilgileri</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<h5 style="color:#8B0000;">Proje Sahibi: </h5><p>{{$users->where('id',$projects->user_id)->value('name')}}</p>
									<br/>
									<h5 style="color:#8B0000;">Proje: </h5><p>{{ $projects->title }}</p>
									<br/>
									<h5 style="color:#8B0000;">Proje Açıklaması: </h5><p>{{ $projects->description }}</p>
									<br/>
									@foreach($units as $unit)
										@if($projects->unit_id == $unit->id)
											<h5 style="color:#8B0000;">Proje Ait Olduğu Birim: </h5><p>{{ $unit->unit }}</p>
										@endif
									@endforeach
									<br/>
									<table class="table tabe-hover table-bordered">
										<tr>
											<td><h5 style="color:#8B0000;">Etkilenen Birim</h5></td>
											<td><h5 style="color:#8B0000;">Onay Durumu</h5></td>
										</tr>
										@foreach($affectedUnits as $affectedUnit)
											@foreach($units as $unit)
												@if($unit->id == $affectedUnit->affected_units_id)
													<tr>
														<td>{{$unit->unit}}</td>

														@if($affectedUnit->approval == 1)
															<td style="color:#008000;"><b>Onay Verildi</b></td>
														@else
															<td style="color:#8B0000;"><b>Onaylanmadı</b></td>
														@endif
													</tr>
												@endif
											@endforeach
										@endforeach
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
								</div>
							</div>
						</div>
					</div>


				@if($projectDone==0)
					<form action="{{ url('projects/vote/store',[$projects->id]) }}" method="GET" id="vote-store">
						<br/>

						<table class="table tabe-hover table-bordered">
							<tr>
								<td>
									<h5 style="color:#8B0000;">Değerlendirme Soruları Ve Puanlama</h5>
									<div class="progress" style="width: 350px; height: 7px;">
										<div class="progress-bar" role="progressbar" style="background-color:#cc0000; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#FF0000; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#FF8C00; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#FFFF00; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#7CFC00; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#008000; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</td>
							</tr>
							@foreach($projectVoteQuestions as $projectVoteQuestion)
								<input type="hidden" name="questionId[]" value="{{ $projectVoteQuestion->id }}" />
								<tr>
									<td class="voteQuestion">
										<p>{{$projectVoteQuestion->question}}</p>
										<h5><pre><input type="radio" name="vote{{$loop->index}}" required value="1" > 1   <input type="radio" name="vote{{$loop->index}}" required value="2" > 2   <input type="radio" name="vote{{$loop->index}}" required value="3" > 3   <input type="radio" name="vote{{$loop->index}}" required value="4" > 4   <input type="radio" name="vote{{$loop->index}}" required value="5" > 5</pre></h5>
									</td>
								</tr>
							@endforeach
						</table>

						<div class="card-header-light text-center">
							<input type="submit" class="btn btn-outline-dark" value="Gönder" id="store-submit" />
							<a class="btn btn-outline-dark mr-2" href="{{ url('projects/list') }}">Geri</a>
						</div>
						<br/>
					</form>

				@else

					<form action="{{ url('projects/vote/update',[$projects->id]) }}" method="GET" id="vote-update">
						<br/>
						
						<table class="table tabe-hover table-bordered">
							<tr>
								<td>
									<h5 style="color:#8B0000;">Değerlendirme Soruları Ve Puanlama</h5>
									<div class="progress" style="width: 350px; height: 7px;">
										<div class="progress-bar" role="progressbar" style="background-color:#cc0000; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#FF0000; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#FF8C00; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#FFFF00; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#7CFC00; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
										<div class="progress-bar" role="progressbar" style="background-color:#008000; width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</td>
							</tr>
							
							@foreach($projectVoteQuestions as $projectVoteQuestion)
								@foreach($votes as $vote)
									@if($vote->question_id == $projectVoteQuestion->id)
										<input type="hidden" name="questionId[]" value="{{ $projectVoteQuestion->id }}" />
										<tr>
											<td class="voteQuestion">
												<p>{{$projectVoteQuestion->question}}</p>
												<h5><pre><input type="radio" name="vote{{$loop->parent->index}}" required value="1" {{ ($vote->vote==1) ? "checked" : "" }}> 1    <input type="radio" name="vote{{$loop->parent->index}}" required value="2" {{ ($vote->vote==2) ? "checked" : "" }}> 2    <input type="radio" name="vote{{$loop->parent->index}}" required value="3" {{ ($vote->vote==3) ? "checked" : "" }}> 3    <input type="radio" name="vote{{$loop->parent->index}}" required value="4" {{ ($vote->vote==4) ? "checked" : "" }}> 4    <input type="radio" name="vote{{$loop->parent->index}}" required value="5" {{ ($vote->vote==5) ? "checked" : "" }}> 5</pre></h5>
											</td>
										</tr>
									@endif
								@endforeach
							@endforeach


							
						</table>

						<div class="card-header-light text-center">
							<input type="submit" class="btn btn-outline-dark" value="Gönder" id="update-submit" />
							<a class="btn btn-outline-dark mr-2" href="{{ url('projects/list') }}">Geri</a>
						</div>
						<br/>
					</form>

				@endif
				</div>
				
			</div>
			<br/>
		</div>
	</div>
	@endsection