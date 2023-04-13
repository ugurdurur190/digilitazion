@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#comment-store').on('submit', function () {
				$('#comment-submit').attr('disabled', 'true');
			});
        });
    </script>
        <div class="col-lg-12">
            <h4 style="color: #5A378C;">Proje Durumu Düzenleme İşlem Kayıtları Ve Yorumları</h4>
            <p style="color:#8B0000;"></p>
            <hr />
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

			<div class="card">
				<div class="card-body">
					<label class="control-label" style="color: #590202;">Proje İsmi:</label>
					<textarea cols="30" rows="3" class="form-control text-area" style="background-color: white;" maxlength="1000" placeholder="{{ $project->title }}" disabled></textarea><br/>
					<label class="control-label" style="color: #590202;">Proje Açıklaması:</label>
					<textarea cols="30" rows="5" class="form-control text-area" style="background-color: white;"  maxlength="1000" placeholder="{{ $project->description }}" disabled></textarea>
				</div>
			</div>

			@foreach($activites as $activite)
				<br/>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<label>İşlem Tarihi</label>
								<input type="text" class="form-control form-control-sm text-area" style="background-color:#EDE9F2;" maxlength="50" value="{{ $activite->created_at }}" disabled>
								<br/>
								<label>Yapılan Proje Durumu</label>
								@foreach($situations as $situation)
									@if($activite->state_id == $situation->id)
										<input type="text" class="form-control form-control-sm text-area" style="background-color:#EDE9F2;" maxlength="50" value="{{ $situation->state }}" disabled>
									@endif
								@endforeach
								<br/>
								<label>İşlem Sahibi</label>
								<input type="text" class="form-control form-control-sm text-area" style="background-color:#EDE9F2;" maxlength="50" value="{{ $users->where('id',$activite->user_id)->value('name') }}" disabled>
							</div>
							<div class="col">
								<label class="control-label">İşlem Sahibi Yorumu</label>
								<textarea cols="30" rows="5" class="form-control text-area" style="background-color:#EDE9F2;" maxlength="1000" placeholder="{{ $activite->comment }}" disabled></textarea>
							</div>
						</div>
					</div>
				</div>
			@endforeach
			<br/>

			@foreach($comments as $comment)
				<div class="card">
					<div class="card-body">
						<div class="col">
							{{ $users->where('id',$comment->user_id)->value('name') }} 
							<textarea cols="30" rows="4" class="form-control text-area" style="background-color:#EDE9F2;" maxlength="1000" placeholder="{{ $comment->comment }}" disabled></textarea>
							<br/>
							<div style="text-align:right; ">{{ $comment->created_at }}</div>
						</div>
					</div>
				</div>
				<br/>
			@endforeach
			<br/>

			<div class="card">
				<div class="card-body">
					<form action="{{ url('projects/comment/store',[$project->id]) }}" method="GET" id="comment-store">
						@csrf
							<div class="col">
								<textarea cols="20" rows="5" class="form-control text-area" name="comment" maxlength="1000" placeholder="Yorum yazınız..." required></textarea>
								<br/>
								<button class="btn btn-outline-dark" id="comment-submit"><i class="fa fa-paper-plane"></i></button>
							</div>
					</form>
				</div>
			</div>

			<br/>
			<div class="text-center">
                <a class="btn btn-outline-dark mr-2" href="{{ url()->previous() }}">Geri</a>
            </div>

        </div>
    @endsection