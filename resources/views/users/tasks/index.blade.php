@extends('layouts.app')

@section('title', trans('common.title_page.list_task'))

@section('content')
    <div class="row">
        <div class="col-lg-12 body-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('common.title_page.list_task') }}
                </div>

                <div class="panel-body">
                    <div>
                        <div class="col-md-6">
                            {!! Html::decode(link_to_route(
                                'report',
                                '<i class="fa fa-pencil-square-o fa-fw"></i> ' . trans('common.button.report'),
                                [Auth::user()->id],
                                ['class' => 'btn btn-warning']
                            )) !!}
                        </div>
                    </div>

                    <div id="data_grid" class="dataTable_wrapper data_list">
                        <table class="table table-striped table-hover" id="tblData">
                            <thead>
                            <tr>
                                <th class="col-md-3">{{ trans('common.title_th.task') }}</th>
                                <th class="col-md-3">{{ trans('common.title_th.subject') }}</th>
                                <th class="col-md-3">{{ trans('common.title_th.course') }}</th>
                                <th class="col-md-1">{{ trans('common.title_th.status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($tasks) > 0)
                                @foreach($tasks as $task)
                                    <tr>
                                        <td class="col-md-3">{{ $task->task->name }}</td>
                                        <td class="col-md-3">{{ $task->task->subject->name }}</td>
                                        <td class="col-md-3">{{ $task->userCourse->course->name }}</td>
                                        <td class="col-md-1">{{ trans("common.status.finish") }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
