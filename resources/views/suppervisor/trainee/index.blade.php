@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 body-content">
            <div class="container">
                <section>
                    <div class="row page-title-row">
                        <div class="col-md-6">
                            <h3> {{ trans('trainee.manager_trainee') }} </h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('admin.trainees.create') }}" class="btn btn-success"> {{ trans('trainee.new_trainee') }} </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    {{ trans('trainee.trainee_table') }}
                                </div>
                                <div class="panel-body">
                                    @include('common.success')
                                    @include('errors.error')
                                    <table class="table" id="myTable">
                                        <thead>
                                            <tr class="filters">
                                                <th><input type="checkbox" id="checkAll"/></th>
                                                <th> {{ trans('trainee.id') }} </th>
                                                <th> {{ trans('trainee.name') }} </th>
                                                <th> {{ trans('trainee.email') }} </th>
                                                <th title="edit">{{ trans('trainee.edit') }}</th>
                                                <th title="delete">{{ trans('trainee.delete') }}</th>
                                                <th title="detail">{{ trans('trainee.detail') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rows as $key => $row)
                                                <tr>
                                                    <td><input type="checkbox" class="checkthis" name="checkbox[]" value="{{ $row->id }}"/></td>
                                                    <td> {{ $row->id }} </td>
                                                    <td> {{ $row->name }} </td>
                                                    <td> {{ $row->email }} </td>
                                                    <td>
                                                        <a class="btn btn-success" href="{{ route('admin.trainees.edit', [ $row->id ]) }}" title="{{ trans('trainee.edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {!! Form::open(['route' => ['admin.trainees.destroy', $row->id], 'method' => 'DELETE']) !!}
                                                            {{ Form::button("<i class=\"fa fa-trash-o\"></i> ", [
                                                                'class' => 'btn btn-danger',
                                                                'onclick' => "return confirm('" . trans('trainee.confirm_delete') . "')",
                                                                'type' => 'submit',
                                                            ]) }}
                                                        {!! Form::close() !!}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.trainees.show', [ $row->id ]) }}" title="detail">
                                                            <i class="glyphicon glyphicon-arrow-right"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pagination pull-right">
                                    {!! $rows->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
