<div wire:ignore.self data-backdrop="static" data-keyboard="false" class="modal fade" id="modalCreateCsv" tabindex="-1"
    role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee create CSV</h5>
            </div>
            <div class="modal-body pt-1">
                <form>
                    <div class="form-group">
                        <label class="form-label">CSV</label>
                        <input type="file"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                            class="form-control" name="file_csv" wire:model.lazy="file_csv">
                        @if ($errors)
                            <span class="text-danger text-left">{{ $errors->first() }}</span>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click=" restart">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:target="file_csv"
                    wire:click="storeCsv">Guardar</button>
            </div>
        </div>
    </div>
</div>
