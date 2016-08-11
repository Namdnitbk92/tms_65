<div id="assignModal" class="modal fade" role="dialog" course-current="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header panel-heading">
                <h4 class="modal-title ">
                    Assign Trainee To Course <i class="pointing right icon"></i>
                    <course class="ui label tag red"></course>
                    </label>
                    <button class="ui circular google plus icon button btn-trainee">
                        <value class="total-trainee"> 0 trainee</value>
                    </button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="ui active centered inline loader loading-ajax" style="display:none;"></div>
                <div class="ui green message result-assign" style="display:none;">
                    <result-assign></result-assign>
                </div>
                @if(isset($trainees) && !empty($trainees))
                    <div class="ui middle aligned animated list">
                        @foreach($trainees as $trainee)
                            <div class="item">
                                <div class="right floated content">
                                    <div class="ui buttons">
                                        <button class="ui button active red"
                                                onclick="removeCourse('{{ $trainee->id }}')">
                                            <i class="minus square icon"></i>
                                        </button>
                                        <div class="or"></div>
                                        <button class="ui blue button" onclick="addCourse('{{ $trainee->id }}')">
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
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="assignTraiee()">
                    <i class="fa fa-btn fa-check"></i> Ok
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fa fa-btn fa-remove"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var joins = [];
    function addCourse(userId) {

        if (!_.contains(joins, userId)) {
            $('.btn-trainee').transition('jiggle');
            joins.push(userId);
        }
        $('.total-trainee').text(joins.length + ' trainee');
    }

    function removeCourse(userId) {
        var index = _.indexOf(joins, userId);
        if (index != -1) {
            $('.btn-trainee').transition('jiggle');
            joins.splice(_.indexOf(joins, userId), 1);
        }
        $('.total-trainee').text(joins.length + ' trainee');
    }

    function assignTraiee() {
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
    }

    $('#assignModal').on('hidden.bs.modal', function () {
        joins = [];
        $('.total-trainee').text(joins.length + ' trainee');
    });

</script>