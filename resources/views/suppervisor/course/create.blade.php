@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12 body-content">
            <h2 class="ui dividing header blue">
                {{ trans('course.course_information') }}
            </h2>
            {{ Form::open(['url' => (empty($course) ? route('admin.courses.store') : route('admin.courses.update', ['course' => $course->id])), 'method' => (empty($course) ? 'POST' : 'PUT'), 'class' => 'ui form', 'name' => 'CI']) }}
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <label>{{ trans('label.name') }}</label>
                        <input type="text" name="name" id="name" placeholder="{{ trans('label.name') }}" value="{{ render_field($course, 'name', null) }}">
                    </div>
                    <div class="field">
                        <label>{{ trans('label.description') }}</label>
                        <input type="text" name="description" id="description" placeholder="{{ trans('label.description') }}" value="{{ render_field($course, 'description', null) }}">
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>{{ trans('label.start_date') }}</label>
                        {{ Form::date('start_date', render_field($course, 'start_date', 'date')) }}
                    </div>
                    <div class="field">
                        <label>{{ trans('label.end_date') }}</label>
                        {{ Form::date('end_date', render_field($course, 'end_date', 'date')) }}
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>{{ trans('course.course_image') }}</label>
                        {{ Form::file('image_url', ['class'=>'file']) }}
                    </div>
                    <div class="field">
                        <label>{{ trans('label.status') }}</label>
                        <span class="ui red">{{ Form::select('size', config('common.status'), 1, ['name' => 'status']) }}</span>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="panel panel-default pl">
                    <div class="panel-heading">
                        {{ trans('course.subject_list') }}
                    </div>
                    <div class="panel-body">
                        <input name="subjectData" type="hidden"/>
                        <div class="ui checkbox subject-list">
                            <input type="checkbox" name="elementAll" style="margin-left:5px;">
                            <label>{{ trans('label.all') }}</label>
                        </div>
                        @if(count($subjects) > 0)
                            @foreach($subjects as $subject)
                                @if(count($subjectsOfCourse) > 0)
                                    @foreach($subjectsOfCourse as $soc)
                                        <div class="ui checkbox subject-list" data="{{ $subject->id }}">
                                            @if($soc->id == $subject->id)
                                                <input belongCourse="true" element="true" type="checkbox" name="element{{ $subject->id }}" value="{{ $subject->id }}" style="margin-left:5px;">
                                            @else
                                                <input belongCourse="false" element="true" type="checkbox" name="element{{ $subject->id }}" value="{{ $subject->id }}" style="margin-left:5px;">
                                            @endif
                                            <label class="">{{ $subject->name }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="ui checkbox subject-list" data="{{ $subject->id }}">
                                        <input belongCourse="false" element="true" type="checkbox" name="element{{ $subject->id }}" value="{{ $subject->id }}" style="margin-left:5px;">
                                        <label class="">{{ $subject->name }}</label>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="two field">
                <div class="field f-right">
                    <button type="submit" class="ui facebook submit blue icon button btn-ci">
                        <i class="checkmark icon"></i> {{ empty($course) ? trans('label.create') : trans('label.update') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection
