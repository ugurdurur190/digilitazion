@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			var checkboxes = $('.checkboxes');
            checkboxes.change(function(){
                if($('.checkboxes:checked').length>0) {
                    checkboxes.removeAttr('required');
                } else {
                    checkboxes.attr('required', 'required');
                }
            });

			$('#voteQuestion-store').on('submit', function () {
				$('#store-submit').attr('disabled', 'true');
			});

			$('#voteQuestion-select').on('submit', function () {
				$('#select-submit').attr('disabled', 'true');
			});

			for(let i = 0; i < {{ $projectVoteQuestions->count() }}; i++){
				$(".select"+i).hover(function(){
					$(".select"+i).css("background-color", "#EDE9F2");
					}, function(){
					$(".select"+i).css("background-color", "#FFFFFF");
				});
			}
			
        });
    </script>
	<div class="col-lg-12">
		<div class="card card-outline">
			<div class="card-header" style="background-color: white;border-top:5px solid #660066;">
				<div class="card-tools">
				
					
					<div class="row">
						<div class="col-7">
							<h4 style="color: #5A378C;">Proje Değerlendirme Anketi Düzenleme</h4>
						</div>
					</div>
					<br/>

				</div>
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

			<div class="card-body">
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
						<td><h5>Etkilenen Birim</h5></td>
						<td><h5>Onay Durumu</h5></td>
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

				<table class="table tabe-hover table-bordered">
					<tr>
						<td>
							<h5 style="color:#8B0000;">*Lütfen "Proje Değerlendirme Anketine" eklenecek soruları seçiniz.</h5>
						</td>	
					</tr>
				</table>

				<table class="table tabe-hover table-bordered">
					<colgroup>
						<col width="5%">
						<col width="25%">
						<col width="10%">
					</colgroup>
					<tr>
						<td class="text-center"><h5>Ekle</h5></td>
						<td><h5>Proje Oylama Soruları</h5></td>
						<td><h5>Puan</h5></td>
					</tr>
					<form action="{{ url('projects/votes/questions/select')}}" method="GET" id="voteQuestion-select">
						@csrf
							<input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
							@foreach($projectVoteQuestions as $projectVoteQuestion)
								<tr>
									<td class="select{{$loop->index}} text-center">
										<input class="checkboxes" type="checkbox" name="projectVoteQuestions[]" value="{{$projectVoteQuestion->id}}" required/>
									</td>
									<td class="select{{$loop->index}}">{{$projectVoteQuestion->question}}</td>
									<td class="select{{$loop->index}}">
										<h5><pre><input type="radio" name="" value="1" disabled> 1   <input type="radio" name="" value="2" disabled> 2   <input type="radio" name="" value="3" disabled> 3   <input type="radio" name="" value="4" disabled> 4   <input type="radio" name="" value="5" disabled> 5</pre></h5>
									</td>
								</tr>
							@endforeach
					</form>
				</table>

				<button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModalVoteQuestion">
					Ankete Soru Ekle
				</button>

				<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#openToProject">
					Kaydet Ve Oylamaya Aç
				</button>
				<div class="modal fade" id="openToProject" tabindex="-1" aria-labelledby="openToProjectLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="openToProjectLabel">Onayla</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<p style="color:#8B0000;">"{{ $projects->title }}"</p> isimli projenin oylama sorularını kaydetmek ve projeyi oylamaya açmak istediğinize emin misiniz. Onay verdikten sonra oylama sorularını düzenleyemezsiniz!
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
								<input type="submit" class="btn btn-outline-danger" id="select-submit" form="voteQuestion-select" value="Onayla" />
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="exampleModalVoteQuestion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Değerlendirme Anketi Soru EKleme</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">

								<form action="{{ url('projects/votes/questions/store') }}" method="GET" id="voteQuestion-store">
									@csrf
										<input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
										<div class="container">
											<textarea class="bold text-area" name="voteQuestion" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Maksimum 250 Karakter" style="height:50px; width:400px; border:none;" maxlength="250" required></textarea>
											<br/>
											<h5><pre><input type="radio" name="" value="1" disabled> 1   <input type="radio" name="" value="2" disabled> 2   <input type="radio" name="" value="3" disabled> 3   <input type="radio" name="" value="4" disabled> 4   <input type="radio" name="" value="5" disabled> 5</pre></h5>
										</div>
										
										<div class="modal-footer">
											<input type="submit" class="btn btn-outline-dark" value="Ekle" id="store-submit" />
											<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
                                		</div>
								</form>
							</div>
							
						</div>
					</div>
				</div>
				
                 <a class="btn btn-outline-dark mr-2" href="{{ url('projects/list') }}">Geri</a>

			</div>

		</div>

		<br/>
		
	</div>
	@endsection