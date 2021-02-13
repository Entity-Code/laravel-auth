@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- EMAIL --}}
            <div class="card">
                <div class="card-header">EMAIL</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                    <form action="{{route('send-mail')}}" method="POST">

                        @csrf
                        @method('POST')

                        <label for="mailText">Text mail: </label>
                        <input name="mailText" type="text">
                        <br>
                        <input type="submit" value="INVIA">
                                            
                    </form>

                </div>
            </div>
            
            {{-- UPLOAD --}}
            <div class="card">
                <div class="card-header">UPLOAD USER ICON</div>
                
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    
                    
                    <form action="{{route('update-icon')}}" method="POST" enctype="multipart/form-data">
                        
                        @csrf
                        @method('POST')
                        
                        <input name="icon" type="file" class="form-control border-0">

                        <input type="submit" class="btn btn-primary" value="UPLOAD">
                        
                        <a href="{{route('clear-icon')}}" class="btn btn-danger">CLEAR ICON</a>
                    </form>
                    
                    
                </div>
            </div>
            
            {{-- IMG (USER ICON) --}}
            {{-- (mostra la card solo se l'icona esiste) --}}
            @if (Auth::user() -> icon) 
                
                <div class="card">
                    <div class="card-header">USER ICON</div>

                    <div class="card-body">
                        <h1>Trust me, I'm a developer</h1> <br>
                        <img src="{{asset('/storage/icon/' . Auth::user() -> icon)}}" width="300px">
                    </div>

                </div>
            @endif
            

        </div>
    </div>
</div>
@endsection
