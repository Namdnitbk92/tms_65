<table class="table table-striped table-hover" id="tblData">
    <thead>
    <tr>
        <th class="th_chk"><input type="checkbox" id="checkAll"></th>
        <th class="col-md-2">{{ trans('common.title_th.name') }}</th>
        <th class="col-md-4">{{ trans('common.title_th.description') }}</th>
        <th class="col-md-2">{{ trans('common.title_th.update') }}</th>
        <th class="th_action" colspan="3">{{ trans('common.title_th.action') }}</th>
    </tr>
    </thead>
    <tbody>
    @if(count($listSubjects) > 0)
        @foreach($listSubjects as $subject)
            <tr id="{{ $subject['id'] }}">
                <td class="chk">
                    <input type="checkbox" class="case" value="{{ $subject['id'] }}"/>
                </td>
                <td class="col-md-2">{{ $subject['name'] }}</td>
                <td class="col-md-4">{{ $subject['description'] }}</td>
                <td class="col-md-2">{{ $subject['updated_at_status'] }}</td>

                <td class="col-md-1 td_action">
                    {!! Html::decode(link_to_route(
                        'admin.subjects.show',
                        '<i class="fa fa-th-list fa-fw"></i> ' . trans('common.button.list_task'),
                        [$subject['id']],
                        ['class' => 'btn btn-link']
                    )) !!}
                </td>

                <td class="col-md-1 td_action">
                    {!! Html::decode(link_to_route(
                        'admin.subjects.edit',
                        '<i class="fa fa-pencil fa-fw"></i> ' . trans('common.button.edit'),
                        [$subject['id']],
                        ['class' => 'btn btn-link']
                    )) !!}
                </td>

                <td class="col-md-1 td_action">
                    {!! Form::open(['route' => ['admin.subjects.destroy', $subject['id']], 'method' => 'DELETE']) !!}
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
    @include('admin.partials.pagination', ['listItems' => $listSubjects])
</div>

