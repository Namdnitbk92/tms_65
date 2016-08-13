@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 body-content ui form">
            <h2 class="ui dividing header blue">
                {{ trans('course.course_detail') }}
            </h2>
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <label class="">{{ trans('label.name') }}</label>
                        <span>{{ $course->name }}</span>
                    </div>
                    <div class="field">
                        <label>{{ trans('label.description') }}</label>
                        <span>{{ $course->description }}</span>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label>{{ trans('label.start_date') }}</label>
                        <span>{{ $course->start_date }}</span>
                    </div>
                    <div class="field">
                        <label>{{ trans('label.end_date') }}</label>
                        <span>{{ $course->end_date }}</span>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>{{ trans('course.course_image') }}</label>
                    </div>
                    <div class="field">
                        <label>{{ trans('label.status') }}</label>
                        <span class="ui red">{!! fill_status($course->status) !!}</span>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="panel panel-default pl">
                    <div class="panel-heading">
                        {{ trans('course.subject_list') }}
                    </div>
                    <div class="panel-body">
                        <div class="ui middle aligned selection list">
                            @if(count($subjects) > 0)
                                @foreach($subjects as $subject)
                                    <div class="item" onclick="courseBuilder.utils().redirect(&quot;{{ route('admin.subjects.show', ['id' => $subject->id]) }}&quot;)">
                                        <img class="ui avatar image" src="{{ asset('images/subject.png') }}">
                                        <div class="content">
                                            <div class="header">{{ $subject->name }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="panel panel-default pl">
                    <div class="panel-heading">
                        User List
                    </div>
                    <div class="panel-body">
                        @if(isset($trainees) && !empty($trainees))
                            <div class="ui middle aligned animated list">
                                @foreach($trainees as $trainee)
                                    <div class="item">
                                        <img class="ui avatar image"
                                             src="{{ empty($trainee->avatar) ? asset('images/trainee.png') : $trainee->avatar}}">
                                        <div class="content">
                                            <div class="header">{{ $trainee->name }}</div>
                                            <div class="field">{{ $trainee->email }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="two field">
                <div class="field f-right">
                    <button type="submit" class="ui facebook blue icon button" onclick="courseBuilder.utils().redirect(&quot;{{ route('admin.courses.index') }}&quot;, 'none')">
                        <i class="left arrow icon"></i> {{ trans('label.back') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
