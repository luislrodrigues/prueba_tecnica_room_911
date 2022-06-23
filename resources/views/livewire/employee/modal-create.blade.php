<div wire:ignore.self data-backdrop="static" data-keyboard="false" class="modal fade" id="modalCreate" tabindex="-1"
    role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee create</h5>
            </div>

            <div class="modal-body pt-1">
                <form>
                    <div class="form-group">
                        <label  class="form-label">Department</label>
                        <select wire:model="department_id" class="form-control">
                            <option value="Elegir">Elegir</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('department_id'))
                            <span class="text-danger text-left">{{ $errors->first('department_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" >First Name</label>
                        <input type="text" class="form-control" name="first_name" wire:model.lazy="first_name">
                        @if ($errors->has('first_name'))
                            <span class="text-danger text-left">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" wire:model.lazy="last_name">
                        @if ($errors->has('last_name'))
                            <span class="text-danger text-left">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" wire:model.lazy="email">
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">Document Number</label>
                        <input type="text" class="form-control" name="document_number" wire:model.lazy="document_number">
                        @if ($errors->has('document_number'))
                            <span class="text-danger text-left">{{ $errors->first('document_number') }}</span>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click=" restart">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:loading.attr="disabled"
                    wire:click="store">Guardar</button>
            </div>
        </div>
    </div>
</div>
