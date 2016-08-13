<table class="table table-striped table-hover" id="tblData">
    <thead>
    <tr>
        <th class="th_chk"><input type="checkbox" id="checkAll"></th>
        <th class="col-md-2">{{ trans('common.title_th.name') }}</th>
        <th class="col-md-4">{{ trans('common.title_th.description') }}</th>
        <th class="col-md-2">{{ trans('common.title_th.subject') }}</th>
        <th class="col-md-2">{{ trans('common.title_th.update') }}</th>
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
                <td class="col-md-2">{{ $task['name'] }}</td>
                <td class="col-md-4">{{ $task['description'] }}</td>
                <td class="col-md-2">{{ $task->subject->name }}</td>
                <td class="col-md-2">{{ $task['updated_at_status'] }}</td>

                <td class="col-md-1 td_action">
                    {!! Html::decode(link_to_route(
                        'admin.tasks.edit',
                        '<i class="fa fa-pencil fa-fw"></i> ' . trans('common.button.edit'),
                        [$task['id']],
                        ['class' => 'btn btn-link']
                    )) !!}
                </td>

                <td class="col-md-1 td_action">
                    {!! Form::open(['route' => ['admin.tasks.destroy', $task['id']], 'method' => 'DELETE']) !!}
                    {!! Form::button('<i class="fa fa-remove fa-fw"></i> ' . trans('common.button.delete'), [
                        'type' => 'submit',
                        'class' => 'btn btn-link',
                        'onclick' => "return confirm('" . trans('common.confirm.delete') . "')"
                    ]) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<div id="pagination">
    @include('admin.partials.pagination', ['listItems' => $listTasks])
</div>
