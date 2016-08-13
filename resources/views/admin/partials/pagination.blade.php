<div class="pagination pull-left">
    <select>
        <option value="">5</option>
        <option value="">10</option>
        <option value="">15</option>
    </select>

    @if ($listItems->total() > 1)
        {!! trans('pagination.display') !!} {!! ($listItems->perPage())*($listItems->currentPage() - 1) + 1 !!} ~
        {!! ($listItems->perPage())*($listItems->currentPage() - 1) +  $listItems->count()!!} of
        {!! $listItems->total() !!} {!! trans('pagination.items') !!}
    @else
        {!! trans('pagination.display') !!} {!! $listItems->total() !!} {!! trans('pagination.item') !!}
    @endif
</div>
<div class="pagination pull-right">
    {!! $listItems->render() !!}
</div>