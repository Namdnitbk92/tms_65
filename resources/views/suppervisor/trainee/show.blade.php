@extends('layouts.app')

@section("content")
    <div class="container">
        <section>
            <div class="row page-title-row">
                <div class="col-md-6">
                    <h3> {{ trans('trainee.trainee_detailt') }} </h3>
                    <a href="{{ route('admin.trainees.index') }}" class="btn btn-success"><i class="fa fa-chevron-circle-left"></i>{{ trans('trainee.back') }}</a>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-7">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            {{ trans('trainee.trainee_table') }}
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="user-information">
                                <div>
                                    <span class="information-label"><strong>{{ trans('trainee.name') }}</strong></span>
                                    <span>{{ $user['name'] }}</span>
                                </div>
                                <div>
                                    <span class="information-label"><strong>{{ trans('trainee.email') }}</strong></span>
                                    <span>{{ $user['email'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
