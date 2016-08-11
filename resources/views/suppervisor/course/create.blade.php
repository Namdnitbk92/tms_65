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
                        <input type="text" name="name" id="name" placeholder="{{ trans('label.name') }}"
                               value="{{ render_field($course, 'name', null) }}">
                    </div>
                    <div class="field">
                        <label>{{ trans('label.description') }}</label>
                        <input type="text" name="description" id="description"
                               placeholder="{{ trans('label.description') }}"
                               value="{{ render_field($course, 'description', null) }}">
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
                                                <input belongCourse="true" element="true" type="checkbox"
                                                       name="element{{ $subject->id }}" value="{{ $subject->id }}"
                                                       style="margin-left:5px;">
                                            @else
                                                <input belongCourse="false" element="true" type="checkbox"
                                                       name="element{{ $subject->id }}" value="{{ $subject->id }}"
                                                       style="margin-left:5px;">
                                            @endif
                                            <label class="">{{ $subject->name }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="ui checkbox subject-list" data="{{ $subject->id }}">
                                        <input belongCourse="false" element="true" type="checkbox"
                                               name="element{{ $subject->id }}" value="{{ $subject->id }}"
                                               style="margin-left:5px;">
                                        <label class="">{{ $subject->name }}</label>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @if(!empty($course))
                <div class="field">
                    <input name="userInCourses" type="hidden"/>
                    <div class="panel panel-default pl">
                        <div class="panel-heading">
                            User List &nbsp;
                            <button class="ui circular google plus icon button btn-trainee">
                                <value class="total-trainee"> 0 trainee in course</value>
                            </button>
                        </div>
                        <div class="panel-body">
                            @if(isset($trainees) && !empty($trainees))
                                <div class="ui middle aligned animated list">
                                    @foreach($trainees as $trainee)
                                        <div class="item">
                                            <div class="right floated content">
                                                <label class="ui label tag yellow">In Course</label>
                                                <div class="ui buttons">
                                                    <button class="ui button active red"
                                                            onclick="removeTrainee('{{ $trainee->id }}')">
                                                        <i class="minus square icon"></i>
                                                    </button>
                                                    <div class="or"></div>
                                                    <button class="ui blue button"
                                                            onclick="addTrainee('{{ $trainee->id }}')">
                                                        <i class="add user icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <img class="ui avatar image"
                                                 src="{{ empty($trainee->avatar) ? asset('images/trainee.png') : $trainee->avatar}}">
                                            <div class="content">
                                                <div class="header">{{ $trainee->name }}</div>
                                                <div class="field">{{ $trainee->email }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @foreach($allTrainees as $trainee)
                                        <div class="item">
                                            <div class="right floated content">
                                                <div class="ui buttons">
                                                    <button class="ui button active red"
                                                            onclick="removeTrainee('{{ $trainee->id }}')">
                                                        <i class="minus square icon"></i>
                                                    </button>
                                                    <div class="or"></div>
                                                    <button class="ui blue button"
                                                            onclick="addTrainee('{{ $trainee->id }}')">
                                                        <i class="add user icon"></i>
                                                    </button>
                                                </div>
                                            </div>
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
            @endif
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
    <script>
        var total_trainee = [];
        function initTrainee() {
            @if(isset($trainees))
                @foreach($trainees as $trainee)
                    total_trainee.push('{{ $trainee->id }}');
            @endforeach
        @endif
        $('.total-trainee').text(total_trainee.length + ' trainee in course');
        }

        function removeTrainee(userId) {
            var index = _.indexOf(total_trainee, userId);
            if (index != -1) {
                $('.btn-trainee').transition('jiggle');
                total_trainee.splice(_.indexOf(total_trainee, userId), 1);
            }
            $('.total-trainee').text(total_trainee.length + ' trainee in course');
        }

        function addTrainee(userId) {
            if (!_.contains(total_trainee, userId)) {
                $('.btn-trainee').transition('jiggle');
                total_trainee.push(userId);
            }
            $('.total-trainee').text(total_trainee.length + ' trainee in course');
        }
        initTrainee();
    </script>
@endsection
