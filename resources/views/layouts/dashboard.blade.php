@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 body-content">
            <h2 class="ui dividing header blue">
                DashBoard
            </h2>
            <div class="ui segment">
                <h2 class="ui right floated header blue">
                    Activity
                </h2>
                <div class="ui clearing divider"></div>
                <div class="ui active centered inline loader loading-ajax"></div>
                <activities style="display:none;"></activities>
            </div>
            <div class="ui two column stackable grid">
                <div class="column">
                    <div class="ui segment">
                        <div id="course"></div>
                    </div>
                </div>
                <div class="column">
                    <div class="ui segment">
                        <div id="subject"></div>
                    </div>
                </div>
            </div>
            <div class="ui two column stackable grid">
                <div class="column">
                    <div class="ui segment">
                        <div id="course_survey"></div>
                    </div>
                </div>
                <div class="column">
                    <div class="ui segment">
                        <div id="subject_survey"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .ui.feed > .event > .label {
            width: 4.5em;
        }
    </style>
    <script>
        var interval = setInterval(function(){
            if (document.readyState === "complete") {clearInterval(interval);activities.build();}
        },200);
    </script>
@endsection
