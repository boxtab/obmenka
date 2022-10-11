<div class="modal fade" id="clearModal" tabindex="-1" role="dialog" aria-labelledby="clearModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clearModalLabel">Очистка</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                Вы действительно хотите очистить таблицу средних курсов? <br/>
                <form action="{{ url('/average-rate/clear') }}" method="POST"
                      id="form-average-rate-clear">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default mr-3" data-dismiss="modal">Отмена</button>
                <button type="submit" rel="tooltip" class="btn btn btn-danger" form="form-average-rate-clear">Очистить</button>
            </div>
        </div>
    </div>
</div>
