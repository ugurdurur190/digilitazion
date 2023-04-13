@extends('layouts.menu')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
		$('#newUnit-store').on('submit', function () {
			$('#submit').attr('disabled', 'true');
		});
    });
</script>
<div class="col-lg-12">
	<h4 style="color: #5A378C;">BİRİMLER</h4>
	<hr style="border-color:black;">
	<div class="card card-outline card-succes">
		<div class="card-header" style="background-color: white;border-top: 5px solid #660066;">
			<div class="card-tools">

                <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#unitStore">
					<i style="color: black;" class="fa fa-plus fa-lg"></i>Yeni Birim Ekle
				</button>
				<div class="modal fade" id="unitStore" tabindex="-1" aria-labelledby="unitStoreLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="unitStoreLabel">YENİ BİRİM EKLE</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('units/store') }}" method="GET" id="unit-store">
                                @csrf
                                    <div class="container">
                                        <h4>Birim İsmi:</h4>
                                        <textarea class="form-control text-area" name="newUnitName" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Maksimum 250 karakter..." style="height:50px; width:400px;" maxlength="250" required></textarea>
                                        <br/>
                                    </div>
                                                    
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-outline-dark" value="Kaydet" id="submit" />
                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
                                    </div>
                                </form>
                            </div>			
						</div>
					</div>
				</div>

				<br/><br/>
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
			<table class="table tabe-hover table-bordered" id="list">
                <colgroup>
						<col width="3%">
						<col width="50%">
						<col width="20%">
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">İsim</th>
						<th class="text-center">Aksiyon</th>
					</tr>

				</thead>
				<tbody style="border-width: 3px;">
                    @foreach($units as $unit)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td class="text-center">{{ $unit->unit }}</td>
                            <td class="text-center">

                                <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#unitEdit{{$unit->id}}">
										<i style="color: black;" class="fa fa-edit fa-lg"></i>
								</button>
								<div class="modal fade" id="unitEdit{{$unit->id}}" tabindex="-1" aria-labelledby="unitEditLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="unitEditLabel">BİRİM DÜZENLE</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('units/edit',[$unit->id]) }}" method="GET" id="unit-edit">
                                                @csrf
                                                    <div class="container">
                                                        <h4>Birim İsmi:</h4>
                                                        <textarea class="form-control text-area" name="unitName" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="{{ $unit->unit }}" style="height:50px; width:400px;" maxlength="250" required></textarea>
                                                        <br/>
                                                    </div>
                                                    
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-outline-dark" value="Düzenle" id="submit" />
                                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
                                                    </div>
                                                </form>
                                            </div>
										
										</div>
									</div>
								</div>


                                <button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#unitDelete{{$unit->id}}">
										<i class="fa fa-trash fa-lg text-danger"></i>
								</button>
								<div class="modal fade" id="unitDelete{{$unit->id}}" tabindex="-1" aria-labelledby="unitDeleteLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="unitDeleteLabel">BİRİM SİL</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
										<p style="color:#8B0000;">{{$unit->unit}}</P> birimini silmek istediğinize emin misiniz ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
											<a class="btn btn-outline-danger delete" href="{{ url('units/delete',[$unit->id]) }}">
												Sil
											</a>
										</div>
										</div>
									</div>
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