@extends('layouts.menu')
    @section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br/>
            <input type="hidden" name="id" class="form-control form-control-sm" value="{{ $projects->id }}">
                
                <div class="row">
                    <div class="col-3">
                        <h4 style="color: #5A378C;">Çalışma Takımı</h4>
                        <a class="btn btn-outline-dark mr-2" href="{{ url('projects/todoes/works/view',[$projects->id]) }}">Geri</a>
                    </div>
                        
                </div>
                <br/>
            <div class="row justify-content-md-center">

                    <hr style="border-color:black;">

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

                        <div class="col-3" style="background-color:#FFFFFF; box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5); border-top: 5px solid #660066;">
                            
                                <h4>Proje Bilgileri</h4><br/>
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

                                <h5 style="color:#8B0000;">Etkilenen Birimler: </h5>
                                @foreach($affectedUnits as $affectedUnit)
                                    @foreach($units as $unit)
                                        @if($unit->id == $affectedUnit->affected_units_id)
                                        <p>{{ $unit->unit }}</p>
                                        @endif
                                    @endforeach
                                @endforeach

                                <br/>
                        </div>

                        
                        <div class="col-3" style="background-color:#FFFFFF; box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5); border-top: 5px solid #660066;">
                            <h4>Tüm Kullanıcılar</h4><br/>
                            @foreach($users as $user)
                                <p>{{ $user->email }}</p>

                                @if($teams->where('user_id',Auth::user()->id)->value('authorization') == 1)
                                <form action="{{ url('projects/todoes/teams/users/store',[$projects->id]) }}" method="GET">
                                    @csrf
                                        <input type="hidden" name="user_id" class="form-control form-control-sm" value="{{ $user->id }}">
                                        <button class="btn btn-flat" type="submit" onclick="this.form.submit(); this.disabled=true;">
                                            <i class="fa fa-user-plus fa-lg" style="color: black;"></i>
                                        </button>
                                </form>
                                @endif
                                <hr color="#660066;"/>
                            @endforeach
                        </div>



                        <div class="col-3" style="background-color:#FFFFFF; box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5); border-top: 5px solid #660066;">
                            <h4>Çalışma Takımı</h4><br/>


                            @foreach($users as $user)
                                @foreach($teams as $team)
                                    @if($user->id == $team->user_id)
                                    <p>{{ $user->email }}</p>

                                    @if($team->where('user_id',Auth::user()->id)->value('authorization') == 1)
                                        <div class="row">
                                            <div class="col">
                                                <form action="{{ url('projects/todoes/teams/users/delete',[$projects->id]) }}" method="GET">
                                                    @csrf
                                                        <input type="hidden" name="user_id" class="form-control form-control-sm" value="{{ $user->id }}">
                                                        <button class="btn btn-flat" type="submit" onclick="this.form.submit(); this.disabled=true;">
                                                            <i class="fa fa-remove fa-lg" style="color: black;"></i>
                                                        </button>
                                                </form>
                                            </div>

                                            <div class="col">
                                                <form action="{{ url('projects/todoes/teams/users/authorize',[$projects->id]) }}" method="GET">
                                                    @csrf
                                                        <input type="hidden" name="id" class="form-control form-control-sm" value="{{ $team->id }}">
                                                        <input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
                                                        <input type="hidden" name="user_id" class="form-control form-control-sm" value="{{ $user->id }}">
                                                        <button class="btn btn-outline-dark btn-sm" type="submit" onclick="this.form.submit(); this.disabled=true;">
                                                            Yetki Ver
                                                        </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                    <hr color="#660066;"/>
                                    @endif
                                @endforeach
                            @endforeach

                        </div>


                        <div class="col-3" style="background-color:#FFFFFF; box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5); border-top: 5px solid #660066;">
                            <h4>Proje Yetkilileri</h4><br/>
                            @foreach($users as $user)
                                @foreach($teams as $team)
                                    @if($user->id == $team->user_id && $team->authorization == 1)
                                    <p>{{ $user->email }}</p>

                                    @if($team->where('user_id',Auth::user()->id)->value('authorization') == 1)
                                    <div class="row">
                                        <div class="col">
                                            
                                        </div>

                                        <div class="col">
                                            <form action="{{ url('projects/todoes/teams/users/restrict',[$projects->id]) }}" method="GET">
                                                @csrf
                                                    <input type="hidden" name="id" class="form-control form-control-sm" value="{{ $team->id }}">
                                                    <input type="hidden" name="project_id" class="form-control form-control-sm" value="{{ $projects->id }}">
                                                    <input type="hidden" name="user_id" class="form-control form-control-sm" value="{{ $user->id }}">
                                                    <button class="btn btn-outline-dark btn-sm" type="submit" onclick="this.form.submit(); this.disabled=true;">
                                                        Yetki Al
                                                    </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    @endif
                                    <hr color="#660066;"/>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    
                        

            </div>
           <br/>
    

@endsection