@extends('layouts.app')

@section('title', trans('common.title_page.list_subject'))

@section('content')
    <div class="row">
        <div class="col-lg-12 body-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('common.title_page.list_subject') }}
                </div>

                <div class="panel-body">
                    <div>
                        <div class="col-md-6">
                            {!! Html::decode(link_to_route(
                                'admin.subjects.create',
                                '<i class="fa fa-plus fa-fw"></i> ' . trans('common.button.create'),
                                '',
                                ['class' => 'btn btn-success']
                            )) !!}

                            <a id="btn_del_subject" class="btn btn-danger">
                                <i class="fa fa-trash-o fa-fw"></i> {{ trans('common.button.delete_multi') }}
                            </a>
                        </div>

                        <div class="col-md-6">
                            {!! Form::open(['url' => 'admin/subjects', 'method' => 'GET']) !!}

                            <div class="col-md-8 col-md-offset-1">
                                {!! Form::text('search', old('search'),
                                ['id' => 'search', 'class' => 'form-control', 'placeholder' => trans('common.placeholder.search')]) !!}
                            </div>

                            {!! Form::button('<i class="fa fa-search fa-fw"></i> ' . @trans('common.button.search'),
                            ['type' => 'submit', 'class' => 'btn btn-primary col-md-3']) !!}

                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div id="data_grid" class="dataTable_wrapper data_list">
                        @include('admin.partials.list_subject', ['listSubjects' => $listSubjects])
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
