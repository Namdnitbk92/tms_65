<div id="resetPasswordModal" class="modal fade" role="dialog">
    {{ Form::open(['url' => '/password/email', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header panel-heading">
                <h4 class="modal-title ">{{ trans('label.register') }}</h4>
            </div>

            <div class="modal-body">
                <div class="panel-body">
                    <div class="form-group{{ is_active_error($errors, 'email') }}">
                        {{ Form::label('name', trans('label.email_address'), ['class' => 'col-md-4 control-label ui blue ribbon label']) }}
                        <div class="col-md-6">
                            {{ Form::email('email', null, ['class' => 'form-control']) }}
                            {!! display_field_error($errors, 'email') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-envelope"></i>
                    {{ trans('passwords.send_password_reset_link') }}
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fa fa-btn fa-remove"></i>
                    {{ trans('label.cancel') }}
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
