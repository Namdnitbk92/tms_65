<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header panel-heading">
                <h4 class="modal-title ">
                    @if(isset($title))
                        {{ $title }}
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                @if(isset($content))
                    {{ $content }}
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-confirm">
                    <i class="fa fa-btn fa-check"></i> {{ trans('label.ok') }}
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fa fa-btn fa-remove"></i> {{ trans('label.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
