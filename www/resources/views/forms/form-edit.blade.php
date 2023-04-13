@extends('layouts.menu')
    @section('content')
	<script type="text/javascript">
        $(document).ready(function () {
			$('#form-edit').on('submit', function () {
				$('#submit').attr('disabled', 'true');
			});
        });
    </script>
	<div class="col-lg-12">
	<h4 style="color: #5A378C;">Form Düzenle</h4>
	<hr/>
		<div class="card">
			<div class="card-body">
				<form action="{{ url('forms/update',[$forms->id]) }}" method="GET" id="form-edit">
				
                <input type="hidden" name="id" class="form-control form-control-sm" value="{{ $forms->id }}">
					<div class="row">
						<div class="col-md-6 border-right">
							<div class="form-group">
								<label for="" class="control-label">Başlık</label>
								<input type="text" name="title" class="form-control form-control-sm text-area" value="{{ $forms->title }}" placeholder="Maksimum 50 karakter..." maxlength="50"  required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Açıklama</label>
								<textarea class="form-control text-area"  name="description" cols="30" rows="4" maxlength="250" placeholder="Maksimum 250 karakter..." required >{{ $forms->description }}
                                </textarea>
							</div>
						</div>
					</div>
					<hr>
					<button class="btn btn-outline-dark mr-2" id="submit">Güncelle</button>
                    <a class="btn btn-outline-dark mr-2" href="{{ url('forms/list') }}">Geri</a>
				</form>
			</div>
		</div>
	</div>
	@endsection