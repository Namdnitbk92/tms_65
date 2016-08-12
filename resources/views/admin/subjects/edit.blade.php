@extends('layouts.app')

@section('title', trans('common.title_page.edit_subject'))

@section('css')
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 body-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('common.title_page.edit_subject') }}
                </div>

                {!! Form::open(['route' => ['admin.subjects.update', $subjects['id']], 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formDialog']) !!}
                <div class="panel-body">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', trans('label.name'), ['class' => 'col-md-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', $subjects['name'], [
                                'class' => 'form-control',
                                'placeholder' => trans('common.placeholder.name')
                            ]) !!}

                            @if ($errors->has('name'))
                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', trans('label.description'), ['class' => 'col-md-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', $subjects['description'], [
                                'class' => 'form-control',
                                'rows' => '2',
                                'placeholder' => trans('common.placeholder.description')
                            ]) !!}
                        </div>
                    </div>

                    <div class="pull-right">
                        {!! link_to_route('admin.subjects.index', trans('common.button.cancel'), '', ['class' => 'btn btn-default']) !!}

                        {!! Form::button(trans('common.button.save'), ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
