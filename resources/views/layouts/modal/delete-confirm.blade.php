<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Удаление</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                Вы действительно хотите удалить строку? <br/>
                ID = <span class="id-delete"></span>
                <form action="{{ url($baseUrlDelete) }}" data-action="{{ url($baseUrlDelete) }}" method="POST"
                      id="form-delete">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default mr-3" data-dismiss="modal">Отмена</button>
                <button type="submit" rel="tooltip" class="btn btn btn-danger" form="form-delete">Удалить</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('js/delete-confirm.js') }}?v=@version" defer></script>
@endpush
