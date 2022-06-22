<div wire:ignore.self data-backdrop="static" data-keyboard="false" class="modal fade" id="modalUpdate" tabindex="-1"
    role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Update</h5>
            </div>

            <div class="modal-body pt-1">
                <form>
                    <div class="form-group">
                        <label for="inputUsername">Userame</label>
                        <input type="text" class="form-control" name="user_name" wire:model.lazy="user_name">
                        @if ($errors->has('user_name'))
                            <span class="text-danger text-left">{{ $errors->first('user_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="text" class="form-control" name="email" wire:model.lazy="email">
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" name="password" wire:model.lazy="password">
                        @if ($errors->has('password'))
                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="role_id" class="form-label">Role</label>
                        <select wire:model="role_id" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('role_id'))
                            <span class="text-danger text-left">{{ $errors->first('role_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Role</label>
                        <select wire:model="status" class="form-control">
                            <option value="ENABLED">ENABLED</option>
                            <option value="DISABLED">DISABLED</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    wire:click=" restart">Cancel</button>
                <button type="button" class="btn btn-primary" wire:loading.attr="disabled"
                    wire:click="update">Update</button>
            </div>
        </div>
    </div>
</div>
