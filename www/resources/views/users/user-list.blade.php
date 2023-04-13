@extends('layouts.menu')
@section('content')
<div class="col-lg-12">
	<h4 style="color: #5A378C;">KULLANICI LISTESI</h4>
	<hr style="border-color:black;">
	<div class="card card-outline card-succes">
		<div class="card-header" style="background-color: white;border-top: 5px solid #660066;">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-black " href="{{ url('users/new') }}"><i style="color: #111111;" class="fa fa-plus"></i> YENİ KULLANICI OLUŞTUR</a>
				<a class="btn btn-block btn-sm btn-default btn-flat border-black " href="{{ url('units/list') }}"><i style="color: #111111;" class="fa fa-plus"></i> BİRİM AYARLARI</a>
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
						<col width="15%">
						<col width="15%">
						<col width="20%">
						<col width="5%">
				</colgroup>
				<thead style="border-width: 3px;">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">İsim</th>
						<th class="text-center">Statü</th>
						<th class="text-center">E-posta</th>
						<th class="text-center">Aksiyon</th>
					</tr>

				</thead>
				<tbody style="border-width: 3px;">
					@foreach($users as $i)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td class="text-center">{{$i->name}}</td>

						@if($i->privilege_id == 1)
						<td class="text-center">Admin</td>
						@elseif($i->privilege_id == 2)
						<td class="text-center">Personel</td>
						@elseif($i->privilege_id == 3)
						<td class="text-center">Yönetici</td>
						@elseif($i->privilege_id == 4)
						<td class="text-center">
							Birim Yöneticisi
							(
							@foreach($units as $u)
								@if($i->unit_id == $u->id)
									{{$u->unit}}
								@endif
							@endforeach
							)
						</td>
						@else
						<td class="text-center">Developer</td>
						@endif

						

						<td class="text-center">{{$i->email}}</td>
						<td class="text-center">

							<div>
								<a class="btn btn-flat" href="{{ url('users/edit',[$i->id]) }}">
									<i style="color: black;" class="fa fa-edit fa-lg"></i>
								</a>

								<button type="button" class="btn btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal{{$i->id}}">
										<i class="fa fa-trash fa-lg text-danger"></i>
								</button>

								<div class="modal fade" id="exampleModal{{$i->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Onayla</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
										<p style="color:#8B0000;">{{$i->name}}</P> isimli kullanıcıyı silmek istediğinize emin misiniz ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Geri</button>
											<a class="btn btn-outline-danger delete" href="{{ url('users/delete',[$i->id]) }}">
												Sil
											</a>
										</div>
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