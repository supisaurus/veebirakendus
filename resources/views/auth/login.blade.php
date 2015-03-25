<!-- -->
@extends('master')
 
@section('main')
    <div class="col-md-8 col-md-offset-2 form-content">
        <h3 class="heading">Sisse logimine</h3>
        @foreach($errors->all() as $error)
            <p class="alert alert-danger">{!!$error!!}</p>
        @endforeach
        {!!Form::open(['url'=>'/login','class'=>'form form-horizontal','style'=>'margin-top:50px'])!!}
        <div class="form-group">
            {!! Form::label('username','Kasutajanimi:',['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::text('username',Input::old('username'),['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
        {!! Form::label('password','Parool:',['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::password('password',['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="text-center">
            {!!Form::submit('Logi sisse',['class'=>'btn btn-default'])!!}
        </div>
        {!!Form::close()!!}
    </div>
 
@stop