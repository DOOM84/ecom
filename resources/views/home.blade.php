@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <p>Name: {!! Auth::user()->name !!}</p>
                    <p>Email: {!! Auth::user()->email !!}</p>
                    <a class="btn btn-primary" href="{{route('allProducts')}}">Main Website</a>
                        @if($userData->isAdmin())
                    <a class="btn btn-warning" href="{{route('adminDisplayProducts')}}">Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
