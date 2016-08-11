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
        $(function () {
            var element = $('activities');
            var html_text = '';
            $.ajax({
                url: 'getActivities',
                type: 'POST',
            }).done(function (res) {
                if (res.data) {
                    var data = res['data'];
                    for (var k in data) {
                        var line = JSON.parse(data[k]);
                        html_text = '<div class="ui feed"><div class="event"><div class="label">';
                        html_text = '<div class="ui feed"><div class="event"><div class="label">';
                        html_text += '<img src="' + line['active_user_avatar'] + '"></div>';
                        html_text += '<div class="content"><div class="summary"><a class="user">';
                        html_text += line['active_user_name'] + '&nbsp;&nbsp;</a><b class="ui label red btn-action-k"> ' + line['action'] + ' </b>&nbsp;' + line['className'];
                        html_text += '&nbsp;<a class="ui label blue" onclick="courseBuilder.utils().redirect(&quot;' + line['link-to-object-detail'] +'&quot;)"> ' + line['objectName'] + ' [' + line['target_id'] + '] </a>';
                        html_text += ' <div class="date">' + line['time'] + '</div></div></div></div></div> ';
                        element.append(html_text);
                        html_text = '';
                    }
                    $('.loading-ajax').hide();
                    element.show(5000);
                }
            })
        });
    </script>
@endsection
