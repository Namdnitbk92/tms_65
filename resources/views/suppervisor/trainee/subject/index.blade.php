@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 body-content">
            <div class="ui message result-msg info" style="display:none;">
                <div class="header">
                    {{ trans('label.notification') }}
                </div>
                <p class="result-msg-content"></p>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Subjects List</h3>
                    <i class="fa fa-refresh" onclick="courseBuilder.utils().redirect(&quot;{{ route('user.subject.index', ['user' => Auth::user()->id]) }}&quot;)"></i>
                </div>
                <div class="panel-body">
                    <div class="responstable-toolbar">
                        @can('is_user', Auth::user())
                            <button class="ui circular blue icon button my-subject"
                                    onclick="courseBuilder.utils().redirect(&quot;{{ route('user.subject.index', ['user' => Auth::user()->id, 'view_subject_of_user' => true]) }}&quot;)">
                                <i class="list layout icon"></i>
                            </button>
                        @endcan
                        <button class="ui circular yellow icon button btn-excel"
                                onclick="courseBuilder.utils().redirect(&quot;{{route('exportExcel')}}&quot;)">
                            <i class="file excel outline icon"></i>
                        </button>

                        <button class="ui circular orange icon button btn-csv"
                                onclick="courseBuilder.utils().redirect(&quot;{{route('exportCSV')}}&quot;)">
                            <i class="file text outline icon"></i>
                        </button>

                        <div class="f-right">
                            <div class="ui fluid category search">
                                <div class="ui icon input">
                                    <form role="form" name="search" method="GET" action="{{ url('/search') }}">
                                        {{ csrf_field() }}
                                        <input name="term" type="hidden">
                                    </form>
                                    <input class="prompt" type="text" placeholder="Search course...">
                                    <i class="search icon"></i>

                                </div>
                                <div class="results"></div>
                            </div>
                        </div>
                    </div>
                    <table class="responstable">
                        <tbody>
                        <tr>
                            <th>Id</th>
                            @if(isset($subjects->first()->course_id))<th>Course Id</th>@endif
                            <th>Name</th>
                            @if(isset($subjects->first()->progress))<th>Progress</th>@endif
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        @if(!empty($subjects))
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ !isset($subject->subject_id) ?  $subject->id : $subject->subject_id }}</td>
                                    @if(isset($subject->course_id))<td>{{ $subject->course_id }}</td>@endif
                                    <td>{{ !isset($subject->subject_name) ?  $subject->name : $subject->subject_name }}</td>
                                    @if(isset($subject->course_id))
                                    <td>
                                        <div class="progress">
                                            <div name="progress-{{ $subject->subject_id }}" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ $subject->progress }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $subject->progress }}%">
                                                {{ $subject->progress }}%
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    <td>{{ $subject->description }}</td>
                                    <td>
                                        <div class="field">
                                            <button class="ui circular twitter icon button btn-info-subject"
                                                    onclick="courseBuilder.utils().redirect(&quot;{{route('user.subject.show', ['user' => auth()->user()->id, 'subject' => $subject->subject_id])}}&quot;)">
                                                <i class="info icon"></i>
                                            </button>
                                            @if(app('request')->input('view_subject_of_user'))
                                            <button class="ui circular red icon button btn-finish"
                                                    onclick="finish('{{$subject->id}}')">
                                                <i class="check icon"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Data Empty</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    @if(!app('request')->input('view_subject_of_user'))
                    {{ Form::open(['method' => 'GET', 'route' => ['user.subject.index', 'user' => auth()->user()->id], 'name' => 'show-entry']) }}
                        <input type="hidden" name="entry"/>
                    {{ Form::close() }}
                    {!! show_entry($subjects) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('common.confirm')
    <script>
        $('.btn-finish').popup({
            position : 'top left',
            content : 'Finish Subject'
        })

        $('.btn-info-subject').popup({
            position : 'top left',
            content : 'View information of subject'
        })

        function finish(id){
            $('.confirmModal').modal('show');
            $('.confirmModal').attr('_id', id);
        }
        $('#btn-confirm').click(function(){
            var userSubjectId = $('.confirmModal').attr('_id');
            $.ajax({
                url : '{{ route('finishSubject') }}',
                type : 'POST',
                data : {
                    id : userSubjectId
                },
                dataType : 'json',
                beforeSend : function () {}
            }).done(function(res) {
                $('.result-msg').show(1000);
                $('.result-msg-content').text(res.messsage);
                $('.confirmModal').modal('hide');
            });
        });
    </script>
@endsection
