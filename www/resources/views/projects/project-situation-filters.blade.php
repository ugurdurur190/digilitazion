@extends('layouts.menu')
    @section('content')
        <script type="text/javascript">
            $(document).ready(function () {
                $('#filter-store').on('submit', function () {
                    $('#submit').attr('disabled', 'true');
                });
            });
        </script>
        <div class="col-lg-12">
            <h4 style="color: #5A378C;">Proje Durumu Düzenleme</h4>
            <p style="color:#8B0000;"></p>
            <hr />
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('projects/situations/filters/status/edit',[$project->id]) }}" method="GET" id="filter-store">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 border-right">

                                <div class="form-group">
                                    <label for="" class="control-label">Proje İsmi</label>
                                    <textarea cols="30" rows="5" class="form-control text-area" maxlength="1000" placeholder="{{ $project->title }}" disabled></textarea>
                                </div>
                                <br/>
                                <div class="form-group">
                                    <td>
                                        <label for="priority">Proje Durumu</label>
                                    </td>
                                    <td>
                                        <select class="form-select" name="state_id"  id="priority" required>
                                            <option value="">Durum Seç</option>
                                            @foreach($situations as $situation)
                                                <option value="{{ $situation->id }}">{{ $situation->state }}</option>              
                                            @endforeach
                                        </select>
                                    </td>
                                </div>
                                <br/>
                                <div class="form-group">
                                    <td>
                                        <label for="priority">İşlem Sahibi</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-area" maxlength="50" value="{{ Auth::user()->name }}" disabled>
                                    </td>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">İşlem Sahibi Yorumu</label>
                                    <textarea name="stateComment" id="" cols="30" rows="7" class="form-control text-area" maxlength="1000" placeholder="Maksimum 1000 karakter..." required></textarea>
                                </div>
                                <br>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-outline-danger mr-2" id="submit">Kaydet</button>
                            <a class="btn btn-outline-dark mr-2" href="{{ url()->previous() }}">Geri</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    @endsection