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
                                                onclick="courseBuilder.removeCourse('{{ $trainee->id }}')">
                                            <i class="minus square icon"></i>
                                        </button>
                                        <div class="or"></div>
                                        <button class="ui blue button" onclick="courseBuilder.addCourse('{{ $trainee->id }}')">
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
                <button class="btn btn-primary" onclick="courseBuilder.assignTraiee()">
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
</script>