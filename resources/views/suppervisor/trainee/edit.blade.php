@extends('layouts.app')

@section("content")
    <div class="row">
        <div class="col-lg-12 col-md-12 body-content">
            <div class="container-fluid">
                <div class="row page-title-row">
                    <div class="col-md-12">
                        <h3> {{ trans('trainee.edit_trainee') }} </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 col-md-offset-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"> {{ trans('trainee.trainee_title_form') }} </h3>
                        </div>
                        <div class="panel-body">
                            @include('errors.error')
                            {!! Form::model($trainee, ['route' => ['admin.trainees.update', $trainee['id']], 'class' => 'form-horizontal', 'enctype' =>"multipart/form-data", 'method' => 'PUT']) !!}
                                <div class="form-group">
                                    {!! Form::label('name', trans('trainee.name'), ['class' => 'control-label col-sm-2 required']) !!}
                                    <div class="col-md-7">
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('email', trans('trainee.email'), ['class' => 'control-label col-sm-2 required']) !!}
                                    <div class="col-md-7">
                                        {!! Form::email('email', null, ['class' => 'form-control', 'readonly' => true]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('password', trans('trainee.password'), ['class' => 'control-label col-sm-2 required']) !!}
                                    <div class="col-md-7">
                                        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5 col-md-offset-6">
                                        {{ Form::button('<i class="fa fa-btn fa-user"></i> ' . trans("trainee.save"), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                        <a href="{{ route('admin.trainees.index') }}" class="btn btn-success"><i class="fa fa-chevron-circle-left"></i>{{ trans('trainee.back') }}</a>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
