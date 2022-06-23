<div wire:ignore.self data-backdrop="static" data-keyboard="false" class="modal fade" id="modalEntry" tabindex="-1"
    role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Entry ROOM_911</h5>
            </div>
            <div class="modal-body pt-1">
                <form>
                    <div class="form-group">
                        <label class="form-label" >Document Number</label>
                        <input type="text" class="form-control" name="document_number_entry" wire:model.lazy="document_number_entry">
                        @if ($errors->has('document_number_entry'))
                            <span class="text-danger text-left">{{ $errors->first('document_number_entry') }}</span>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click=" restart">Cancel</button>
                <button type="button" class="btn btn-primary" wire:click="entry">Entry</button>
            </div>
        </div>
    </div>
</div>