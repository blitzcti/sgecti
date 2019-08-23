<div class="modal fade" id="cloneScheduleModal" tabindex="-1" role="dialog" aria-labelledby="cloneScheduleModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Clonar horário</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="schedule" class="control-label">Horário</label>

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <td>
                                    <label class="control-label">Entrada</label>
                                </td>

                                <td >
                                    <label class="control-label">Saída</label>
                                </td>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input name="cMonS" id="inputCMonS" type="text" class="form-control input-time">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <input name="cMonE" id="inputCMonE" type="text" class="form-control input-time">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group  @if($errors->has('days')) has-error @endif">
                            <label for="weekDays" class="control-label">Dias da semana</label>

                            <table id="weekDays" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        <label for="inputMonday" class="control-label">Seg</label>
                                    </th>

                                    <th>
                                        <label for="inputTuesday" class="control-label">Ter</label>
                                    </th>

                                    <th>
                                        <label for="inputWednesday" class="control-label">Qua</label>
                                    </th>

                                    <th>
                                        <label for="inputThursday" class="control-label">Qui</label>
                                    </th>

                                    <th>
                                        <label for="inputFriday" class="control-label">Sex</label>
                                    </th>

                                    <th>
                                        <label for="inputSaturday" class="control-label">Sab</label>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        <input name="days[]" value="mon" id="inputMonday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="tue" id="inputTuesday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="wed" id="inputWednesday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="thu" id="inputThursday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="fri" id="inputFriday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="sat" id="inputSaturday" type="checkbox"
                                               class="iCheckbox">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        onclick="cloneSchedule();">Clonar</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        jQuery('.iCheckbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        let days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        let schedule2 = false;

        function getDays() {
            return Array.from(document.querySelectorAll(`input[name="days[]"]:checked`)).map(d => d.value);
        }

        function cloneSchedule() {
            days = getDays();

            if (Array.isArray(days) && typeof schedule2 === "boolean") {
                let s = jQuery(`input[name=cMonS]`).val();
                let e = jQuery(`input[name=cMonE]`).val();

                if (!schedule2) {
                    days.forEach(day => {
                        jQuery(`input[name=${day}S]`).val(s);
                        jQuery(`input[name=${day}E]`).val(e);
                    });
                } else {
                    days.forEach(day => {
                        jQuery(`input[name=${day}S2]`).val(s);
                        jQuery(`input[name=${day}E2]`).val(e);
                    });
                }
            }
        }
    </script>
@endsection
