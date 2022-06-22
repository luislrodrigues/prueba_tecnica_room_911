<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row d-flex justify-content-center mx-2">
                    <div class="col-sm-4 mb-2 ">
                        <input type="search" placeholder="Search" class="form-control " wire:model="search" />
                    </div>
                    <div class="col-sm-2 mb-2">
                        <button data-toggle="modal" data-target="#modalCreate" class="btn btn-success">Newuser</button>
                    </div>

                </div>
            </div>
            @if ($users->count())
                <div class="table-responsive mx-3">
                    <table
                        class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                        {{ $user->id }}</td>
                                    <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                        {{ $user->user_name }}</td>
                                    <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                        {{ $user->email }}</td>
                                    <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                        {{ $user->role->name }}</td>
                                    <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                        {{ $user->status }}</td>
                                    <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                        <button type="button" class="btn btn-sm btn-primary mx-1" data-toggle="modal"
                                            data-target="#modalUpdate" wire:click="edit({{ $user->id }})">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleted('user.user', 'destroy',{{ $user->id }})">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="d-flex justify-content-center mt-3">
                    <h4>There are no records</h4>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
    <div class="col-12 position-absolute top-50 text-center ">
        <div wire:loading class="spinner-border text-primary" role="status"></div>
    </div>


    @include('livewire.user.modal-create')
    @include('livewire.user.modal-update')

    @push('scripts')
        <script type="text/javascript" src="{{ asset('js/alert/alert.js') }}"></script>
        <script>
            livewire.on('alertSuccess', (message) => {
                alertSuccess(message)
            });
            window.livewire.on('closeModal', () => {
                $("[data-dismiss=modal]").trigger({
                    type: "click"
                })
            });
        </script>
    @endpush

</div>
