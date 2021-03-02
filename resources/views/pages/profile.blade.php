@extends('index')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Profile</h3>
                    {{-- {{ dd(Auth::user() )}} --}}
                    <img src="{!! asset('/images/user_p.png') !!}" alt="Avatar" class="img img-thumbnail">
                    <p>Nama: {!! Auth::user()->name ?? '<input type="text" name="name" placeholder="Nama Lengkap" class="form-control">' !!}</p>
                    <p>Username: {!! Auth::user()->username ?? '<input type="text" name="username" placeholder="User Name" class="form-control">' !!}</p>
                    <p>Email: {!! Auth::user()->email.'['.(Auth::user()->verified)?'verified':'not verified' .']' ?? '<input type="email" name="email" placeholder="Email" class="form-control">' !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection