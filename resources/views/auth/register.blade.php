<div id="registerModal" class="modal fade" role="dialog">
    {{ Form::open(['url' => '/register', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header panel-heading">
                <h4 class="modal-title ">{{ trans('label.register') }}</h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="panel-body">
                        <div class="form-group{{ is_active_error($errors, 'name') }}">
                            {{ Form::label('name', trans('label.name'), ['class' => 'col-md-4 control-label ui blue ribbon label']) }}
                            <div class="col-md-6">
                                {{ Form::text('name', null, ['class'=>'form-control']) }}
                                {!! display_field_error($errors, 'name') !!}
                            </div>
                        </div>

                        <div class="form-group{{ is_active_error($errors, 'email') }}">
                            {{ Form::label('email', trans('label.email_address'), ['class' => 'col-md-4 control-label ui blue ribbon label']) }}
                            <div class="col-md-6">
                                {{ Form::email('email', null, ['class'=>'form-control', 'name'=>'email']) }}
                                {!! display_field_error($errors, 'email') !!}
                            </div>
                        </div>

                        <div class="form-group{{ is_active_error($errors, 'password') }}">
                            {{ Form::label('password', trans('label.password'), ['class' => 'col-md-4 control-label ui blue ribbon label']) }}
                            <div class="col-md-6">
                                {{ Form::password('password', ['class'=>'form-control', 'name'=>'password']) }}
                                {!! display_field_error($errors, 'password') !!}
                            </div>
                        </div>

                        <div class="form-group{{ is_active_error($errors, 'password_confirmation') }}">
                            {{ Form::label('email', trans('passwords.confirm_password'), ['class' => 'col-md-4 control-label ui blue ribbon label']) }}
                            <div class="col-md-6">
                                {{ Form::password('password', ['class'=>'form-control', 'name'=>'password_confirmation']) }}
                                {!! display_field_error($errors, 'password_confirmation') !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-user"></i> {{ trans('label.register') }}
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fa fa-btn fa-remove"></i> {{ trans('label.cancel') }}
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
