@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 body-content ui form">
            <h2 class="ui dividing header blue">
                Subject Information Detail - [ {{ auth()->user()->name }} ]
            </h2>
            <div class="field">
                <div class="two fields">
                    <div class="field">
                        <label>Name</label>
                        <span>{{ $subject->subject_name }}</span>
                    </div>
                    <div class="field">
                        <label>Description</label>
                        <span>{{ $subject->description }}</span>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label>Start Date</label>
                        <span>{{ $subject->start_date }}</span>
                    </div>
                    <div class="field">
                        <label>End Date</label>
                        <span>{{ $subject->end_date }}</span>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Progress</label>
                        <span class="ui red ribbon label">{{ $subject->progress }} %</span>
                    </div>
                    <div class="field">
                        <label>Status {{ $subject->status }}</label>
                        <span>{!! fill_status($subject->status) !!}</span>
                    </div>
                </div>
            </div>
            <div class="two field">
                <div class="field f-right">
                    <button type="submit" class="ui facebook blue icon button"
                            onclick="app.redirect(&quot;{{ route('course.index') }}&quot;)">
                        <i class="back icon"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection