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
                            <a id="btn_finish_task" class="btn btn-danger">
                                <i class="fa fa-stop fa-fw"></i> {{ trans('common.button.finish') }}
                            </a>
                        </div>
                    </div>

                    <div id="data_grid" class="dataTable_wrapper data_list">
                        <table class="table table-striped table-hover" id="tblData">
                            <thead>
                            <tr>
                                <th class="th_chk"><input type="checkbox" id="checkAll"></th>
                                <th class="col-md-3">{{ trans('common.title_th.task') }}</th>
                                <th class="col-md-3">{{ trans('common.title_th.subject') }}</th>
                                <th class="col-md-3">{{ trans('common.title_th.course') }}</th>
                                <th class="col-md-1">{{ trans('common.title_th.status') }}</th>
                                <th class="th_action" colspan="3">{{ trans('common.title_th.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($listTasks) > 0)
                                @foreach($listTasks as $task)
                                    <tr id="{{ $task['id'] }}">
                                        <td class="chk">
                                            <input type="checkbox" class="case" value="{{ $task['id'] }}"/>
                                        </td>
                                        <td class="col-md-3">{{ $task['task'] }}</td>
                                        <td class="col-md-3">{{ $task['subject'] }}</td>
                                        <td class="col-md-3">{{ $task['course'] }}</td>
                                        <td class="col-md-1">{{ fill_status_task($task['task_status']) }}</td>

                                        <td class="col-md-1 td_action">
                                            {!! Html::decode(link_to_route(
                                                'tasks/finish',
                                                '<i class="fa fa-stop fa-fw"></i> ' . trans('common.button.finish'),
                                                [Auth::user()->id, $task['id'], $task['subject_id'],$task['user_course_id'], $task['task_status']],
                                                ['class' => 'btn btn-link']
                                            )) !!}
                                        </td>
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