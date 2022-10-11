<div class="modal fade" id="buildModal" tabindex="-1" role="dialog" aria-labelledby="buildModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buildModalLabel">Формировка среднего курса</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="block-progress-done" style="display: none">
                    <strong>Готово</strong>
                </div>
                <div id="block-progress-run" class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default mr-3" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn btn-danger mr-3" id="button-build">Сформировать</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('js/average-rate/build.js') }}?v=@version" defer></script>
@endpush
