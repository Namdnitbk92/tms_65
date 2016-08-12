var appBuilder = function () {

    this.initLib = function () {
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '275578219472356',
                xfbml      : true,
                version    : 'v2.7'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });



    }

    this.tooltip = function (configs) {
        if (_.isNull(configs) || _.isUndefined(configs)) {
            return;
        } else {
            for (var k in configs) {
                var config = configs[k];
                var element = config.element ? config.element : null;
                if (_.isNull(element)) {
                    return;
                }

                if (_.isFunction(element.popup)) {
                    element.popup({
                        position: config.position ? config.position : 'right center',
                        content: config.content ? config.content : ''
                    })
                }
            }
        }
    };

    this.animate = function (configs) {
        for (var k in configs) {
            var config = configs[k];
            var animate = config.animate ? config.animate : null;
            if (_.isNull(animate)) {
                continue;
            } else {
                var callback = config.callack ? config.callback : undefined;
                if (_.isUndefined(callback)) {
                    setTimeout(function () {
                        animate.transition(config.animateName);
                    }, 400);
                } else {
                    callback();
                }
            }
        }
    }

    this.utils = new function () {
        var parent = this;
        /*format data send ajax from serialize data*/
        var processData = function (data) {
            if (_.contains(data, '&')) {
                data = data.split('&');
                var obj = {};
                for (var k in data) {
                    if (_.contains(data[k], '=')) {
                        var temp = data[k].split('=');
                        if (Array.isArray(temp)) {
                            obj[temp[0]] = temp[1];
                        }
                    }
                }
                return obj;
            }
            ;
            return data;
        };
        /*common method send request with ajax*/
        this.sendData = function (config) {
            var request = $.ajax({
                url: config.url ? config.url : '',
                data: config.data ? config.data : null,
                dataType: config.dataType ? config.dataType : 'json',
                type: config.method ? config.method : 'POST',
                beforeSend: config.beforeSend ? config.beforeSend : function () {
                }
            });

            request.done(function (res) {
                if (typeof config.callback === 'function') {
                    config.callback(res);
                }
            })
        };

        this.loading = function (action, delay) {
            var _loading = $('.loadingArea');
            var _delay = delay ? delay : 1;
            if (action === 'show') {
                _loading.show(_delay);
            } else {
                _loading.hide(_delay);
            }
        };

        this.isset = function (val) {
            return !_.isUndefined(val) && !_.isNull(val);
        };

        this.redirect = function (url, type) {
            if (_.isNull(url) || _.isUndefined(url))
                return;
            if (this.isset(type)) {
                window.location.href = url;
            } else {
                window.open(url, '_blank');
            }
        };

        this.validate = function (config) {
            var validateRules = {};
            for (var c in config.rules) {
                validateRules[config.rules[c].id] = {
                    identifier: config.rules[c].id,
                    rules: [
                        {
                            type: config.rules[c].type ? config.rules[c].type : 'empty',
                            prompt: config.rules[c].text ? config.rules[c].text : 'Please enter field information',
                        }
                    ],
                }
            }

            config.form.form(validateRules, {
                inline: true,
                on: 'blur'
            });
        }
    };

    this.bindEvent = function (callback) {
        return _.isFunction(callback) ? callback() : function () {
        };
    }

};

/*init Component*/
var loginBuilder = (function (appBuilder) {
    var appLogin = new appBuilder();

    return {
        tooltip: function () {
            var configs = [
                {
                    element: $('input[name="password"]'),
                    content: 'Please enter password to login with your"s account',
                },
                {
                    element: $('input[name="email"]'),
                    content: 'Please enter email to login with your"s account',
                },
            ];
            appLogin.tooltip(configs);
        },
        animate: function () {
            appLogin.animate([
                {
                     animate: $('.navbar-header'),
                     animateName: 'jiggle'
                },
                {
                    animate: $('.landing-page'),
                    animateName: 'fly up'
                },
            ]);
        },
        bindEvent: function () {
        },
        build: function () {
            this.tooltip();
            this.animate();
            this.bindEvent();
        }
    }
}(appBuilder))

var courseBuilder = (function () {
    var course = new appBuilder();

    return {
        tooltip: function () {
            var configs = [
                {
                    element: $('.add-course'),
                    position: 'top center',
                    content: 'Add New Course'
                },
                {
                    element: $('.del-course-multi'),
                    position: 'top center',
                    content: 'Delete Course Selected'
                },
                {
                    element: $('.btn-excel'),
                    position: 'top center',
                    content: 'Export Excel'
                },
                {
                    element: $('.btn-csv'),
                    position: 'top center',
                    content: 'Export CSV'
                },
            ];
            course.tooltip(configs);
        },
        bindEvent: function () {
            $('form[id="delRoute"]').submit(function (e) {
                e.preventDefault();
            });
            var input_all = $('input[name="select-all"]');
            input_all.change(function () {
                var check = input_all.prop('checked');
                var all_input = $('input[type="checkbox"]');
                if (check) {
                    all_input.prop('checked', true);
                } else {
                    all_input.prop('checked', false);
                }
            });

            $('.btn-confirm').click(function () {
                var selected = localStorage.getItem('selected');
                var courses = localStorage.getItem('courseList');
                courses = JSON.parse(courses);
                var input = $('input[name="select-all"]');
                var checkboxs = $('input[type="checkbox"]');
                if (input.prop('checked') && checkboxs.length > 1) {
                    var courses = [];
                    for (var i = 0; i < checkboxs.length; i++) {
                        var element = $(checkboxs[i]);
                        if (element.attr('name') !== 'select-all') {
                            courses.push(element.val());
                        }
                    }
                }
                if (!course.utils.isset(selected) && courses !== undefined) {
                    $.ajax({
                        url: 'courses/destroySelected',
                        data: {
                            ids: courses
                        },
                        type: 'POST',
                        beforeSend: function () {
                            $('#confirmModal').modal('hide');
                            course.utils.loading('show');
                        }
                    }).done(function (res) {
                        setTimeout(function () {
                            for (var c in courses) {
                                $('tr.row-' + parseInt(courses[c])).addClass('hide');
                            }
                            localStorage.clear();
                            course.utils.loading('hide');
                            $('.result-msg').show(1000);
                            $('.result-msg-content').text('Delete Courses Success!');
                            setTimeout(function () {
                                $('.result-msg').hide(1000);
                            }, 2000);
                        }, 400)
                    });
                } else {
                    var formName = 'delRoute' + selected;
                    var _form = $('form[name="' + formName + '"]');
                    _form.unbind('submit');
                    _form.submit();
                }
            });

            $('.del-course').click(function () {
                $('#confirmModal').modal('show');
            });

            $('.prompt').change(function () {
                course.utils.loading('show');
                $('input[name="term"]').val($('.prompt').val());
                setTimeout(function () {
                    $('form[name="search"]').submit();
                }, 500);
            });

            $('#confirmModal').on('hidden.bs.modal', function () {
                $('.modal-body').text('Are you sure?');
                localStorage.removeItem('selected');
                $('.btn-confirm').prop('disabled', false);
            });

            $('.del-course-multi').click(function () {
                var courses = localStorage.getItem('courseList');
                var checkall = $('input[name="select-all"]').prop('checked');
                if ((_.isUndefined(courses) || _.isNull(courses)) && !checkall) {
                    $('.modal-body').text('Please select courses before delete!');
                    $('.btn-confirm').prop('disabled', true);
                    $('#confirmModal').modal('show');
                    return;
                } else {
                    $('#confirmModal').modal('show');
                }
            });

            $('.dropdown-entry').change(function () {
                course.utils.loading('show');
                $('input[name="entry"]').val($('.dropdown-entry').val());
                $('form[name="show-entry"]').submit();
            });

            $('input[name="elementAll"]').click(function () {
                var check = $('input[name="elementAll"]').prop('checked');
                var input = $('input[type="checkbox"]');
                var data = [];
                for (var i = 0; i < input.length; i++) {
                    if (input[i].hasAttribute('element')) {
                        data.push($(input[i]).val());
                    }
                }
                if (check) {
                    $(input).prop('checked', true);
                    $('input[name="subjectData"]').val(data);
                } else {
                    $(input).prop('checked', false);
                    $('input[name="subjectData"]').val('');
                }
            })

            $('form[name="CI"]').submit(function (e) {
                e.preventDefault();
            })

            $('.btn-ci').click(function () {
                $('form[name="CI"]').unbind('submit');
                course.utils.validate({
                    form: $('form[name="CI"]'), rules: [
                        {
                            id: 'name',
                            text: 'Please enter course name'
                        },
                        {
                            id: 'description',
                            text: 'Please enter course description'
                        }
                    ]
                });
                var input = $('input[type="checkbox"]');
                var data = [];
                for (var i = 0; i < input.length; i++) {
                    var isCheck = $(input[i]).prop('checked');
                    if (isCheck && input[i].hasAttribute('element')) {
                        data.push($(input[i]).val());
                    }
                }
                if(total_trainee !== undefined && total_trainee != null) {
                    $('input[name="userInCourses"]').val(total_trainee);
                }
                $('input[name="subjectData"]').val(data);
                $('form[name="CI"]').submit();
            });

            $('.share-fb-btn').click(function(){
                if(course.utils.isset(FB)) {
                    FB.ui({
                        method: 'feed',
                        display: 'popup',
                        link: 'http://laravel.dev/Project1/tms/public/course',
                        caption: 'Course List',
                        redirect_uri : 'http://laravel.dev/Project1/tms/public/course',
                        name : 'Laravel dev',
                        description : 'This is course list',
                        picture : 'http://www.phpgang.com/wp-content/themes/PHPGang_v2/img/logo.png',
                    }, function(response){});
                }
            });

            $('#assignModal').on('hidden.bs.modal', function () {
                joins = [];
                $('.total-trainee').text(joins.length + ' trainee');
            });

            (function () {
                var input = $('input[type="checkbox"]');
                for (var i = 0; i < input.length; i++) {
                    if (input[i].hasAttribute('element')) {
                        var _input = $(input[i]);
                        if (_input.attr('belongCourse') == "true") {
                            _input.prop('checked', true);
                        } else continue;
                    }
                }
            }());
        },
        saveSelect: function (id) {
            localStorage.setItem('selected', id);
        },
        saveStorage: function (id) {
            var checked = $('input[name="radio-' + id + '"]').prop('checked');
            var list = localStorage.getItem('courseList');
            list = _.isUndefined(list) || _.isNull(list) ? null : JSON.parse(list);
            if (_.isArray(list) && !_.isEmpty(list)) {
                var find = _.find(list, function (element) {
                    return id === element;
                });
                if (find === undefined) {
                    if (checked) {
                        list.push(id);
                    }
                    localStorage.setItem('courseList', JSON.stringify(list));
                } else {
                    if (!checked) {
                        var index = _.indexOf(list, "" + id);
                        list.splice(index, 1);
                        localStorage.setItem('courseList', JSON.stringify(list));
                    }
                }
            } else {
                if (checked) {
                    localStorage.setItem('courseList', JSON.stringify([id]));
                }
            }
        },
        openAssign: function (courseName, courseId)  {
            $('#assignModal').modal('show');
            $('course').text(courseName);
            $('#assignModal').attr('course-current', courseId);
        },
        addCourse : function (userId) {
                if (!_.contains(joins, userId)) {
                    $('.btn-trainee').transition('jiggle');
                    joins.push(userId);
                }
                $('.total-trainee').text(joins.length + ' trainee');
        },
        removeCourse : function (userId) {
                var index = _.indexOf(joins, userId);
                if (index != -1) {
                    $('.btn-trainee').transition('jiggle');
                    joins.splice(_.indexOf(joins, userId), 1);
                }
                $('.total-trainee').text(joins.length + ' trainee');
        },   
        removeTrainee : function (userId) {
            var index = _.indexOf(total_trainee, userId);
            if (index != -1) {
                $('.btn-trainee').transition('jiggle');
                total_trainee.splice(_.indexOf(total_trainee, userId), 1);
            }
            $('.total-trainee').text(total_trainee.length + ' trainee in course');
        },
        addTrainee : function (userId) {
            if (!_.contains(total_trainee, userId)) {
                $('.btn-trainee').transition('jiggle');
                total_trainee.push(userId);
            }
            $('.total-trainee').text(total_trainee.length + ' trainee in course');
        },
        assignTraiee : function () {
                $.ajax({
                    url: 'assignTrainee',
                    data: {ids: joins, course_id: $('#assignModal').attr('course-current')},
                    type: 'POST',
                    beforeSend: function () {
                        $('.loading-ajax').show();
                    }
                }).done(function (res) {
                    setTimeout(function () {
                        $('.loading-ajax').hide();
                        $('.result-assign').show(300);
                        $('result-assign').text(res.message ? res.message : res);
                    }, 1000)

                    setTimeout(function () {
                        $('.result-assign').hide();
                    }, 2500);
                })
        },
        utils: function () {
            return course.utils;
        },
        build: function () {
            localStorage.clear();
            this.tooltip();
            this.bindEvent();
        }
    }

}(appBuilder))

var activities = (function(){
    return {
        build: function () {
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
                        if(!line['active_user_avatar']) 
                            line['active_user_avatar'] = 'images/trainee.png';

                        console.log(line['active_user_avatar'])
                        html_text = '<div class="ui feed"><div class="event"><div class="label">';
                        html_text = '<div class="ui feed"><div class="event"><div class="label">';
                        html_text += '<img src="' + line['active_user_avatar'] + '"></div>';
                        html_text += '<div class="content"><div class="summary"><a class="user">';
                        html_text += line['active_user_name'] + '&nbsp;&nbsp;</a><b class="ui label red btn-action-k"> ' + line['action'] + ' </b>&nbsp;' + line['className'];
                        html_text += '&nbsp;<a class="ui label blue" onclick="courseBuilder.utils().redirect(&quot;' + line['link-to-object-detail'] + '&quot;)"> ' + line['objectName'] + ' [' + line['target_id'] + '] </a>';
                        html_text += ' <div class="date">' + line['time'] + '</div></div></div></div></div> ';
                        element.append(html_text);
                        html_text = '';
                    }
                    $('.loading-ajax').hide();
                    element.show(5000);
                }
            })

            //init chart
             $('#subject').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Course Information'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Course Information'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },

                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [{
                        name: 'Microsoft Internet Explorer',
                        y: 56.33,
                        drilldown: 'Microsoft Internet Explorer'
                    }, {
                        name: 'Chrome',
                        y: 24.03,
                        drilldown: 'Chrome'
                    }, {
                        name: 'Firefox',
                        y: 10.38,
                        drilldown: 'Firefox'
                    }, {
                        name: 'Safari',
                        y: 4.77,
                        drilldown: 'Safari'
                    }, {
                        name: 'Opera',
                        y: 0.91,
                        drilldown: 'Opera'
                    }, {
                        name: 'Proprietary or Undetectable',
                        y: 0.2,
                        drilldown: null
                    }]
                }],
            });
        }
    }
}());

$(document).ready(function () {
    (new appBuilder()).initLib();
    loginBuilder.build();
    courseBuilder.build();

    // select multi
    $("#data_grid").on('click', '#checkAll', function () {
        $('.case').prop('checked', this.checked);
    });

    $(".case").click(function () {
        if ($(".case").length == $(".case:checked").length) {
            $("#checkAll").prop("checked", "checked");
        } else {
            $("#checkAll").removeAttr("checked");
        }
    });

//  Delete multi subject
    $('#btn_del_subject').click(function () {
        var ids = [];
        $('.case:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length === 0) { //tell you if the array is empty
            alert("No subjects were selected?");
        } else {
            if (!confirm("Are you sure you want to delete this?")) {
                return false;
            } else {
                $.ajax({
                    url: 'subjects/delete_multi',
                    type: 'POST',
                    data: {id: ids},
                    dateType: 'json',
                    success: function (response) {
                        $('#data_grid').html(response['view']);
                        alert("Delete multi subjects success!");
                    }
                });

                return true;
            }
        }
    });

// Dellete multi tasks
    $('#btn_del_task').click(function () {
        var ids = [];
        $('.case:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length === 0) { //tell you if the array is empty
            alert("No subjects were selected?");
        } else {
            if (!confirm("Are you sure you want to delete this?")) {
                return false;
            } else {
                $.ajax({
                    url: 'tasks/delete_multi',
                    type: 'POST',
                    data: {id: ids},
                    dateType: 'json',
                    success: function (response) {
                        $('#data_grid').html(response['view']);
                        alert("Delete multi tasks success!");
                    }
                });

                return true;
            }
        }
    });
    
    // validate form Subject-Task
    $(document).ready(function () {
        $('#formDialog').formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The name is required'
                        }
                    }
                },
                subject_id: {
                    validators: {
                        notEmpty: {
                            message: 'The subject is required'
                        }
                    }
                }
            }
        });
    });
})

