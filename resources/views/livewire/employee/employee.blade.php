<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="form-group">
                    <div class="row mb-2 mx-1 d-flex justify-content-center">
                        <div class="col-sm-3 col-xs-12 mb-2">
                            <input type="search" wire:model="search" class="form-control mt-4" placeholder="Search" />
                        </div>
                        <div class="col-sm-3 col-xs-12 mb-2">
                            <label class="fw-bold">Department</label>
                            <select wire:model = "departmentFilter" class="form-select mb-2">
                                <option value="0">Select</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-danger mt-4" wire:click="cleanFilter">Clean</button>
                        </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-center">
                        <button data-toggle="modal" data-target="#modalCreate"
                            class="btn btn-success rounded-pill mx-3">New Employee</button>
                        <button class="btn btn-info rounded-pill mx-3">History PDF</button>
                        <button class="btn btn-info rounded-pill mx-3">CSV</button>
                        <button class="btn btn-info rounded-pill mx-3">Entry</button>
                    </div>
                </div>
                @if ($employees->count())
                    <div class="table-responsive mx-3 mb-2">
                        <table
                            class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Firts Name</th>
                                    <th class="text-center">Last Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Document Number</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            {{ $employee->id }}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            {{ $employee->department->name }}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            {{ $employee->first_name }}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            {{ $employee->last_name }}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            {{ $employee->email }}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            {{ $employee->document_number }}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            {{ $employee->status }}
                                        </td>
                                        <td class="text-center" style="background-color: rgb(249, 253, 253);">
                                            <button type="button" class="btn btn-sm btn-success mx-1"
                                             data-toggle="modal" data-target="#modalShow"
                                                wire:click="edit({{ $employee->id }})">
                                                <i class="bi bi-card-list"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary mx-1"
                                                data-toggle="modal" data-target="#modalUpdate"
                                                wire:click="edit({{ $employee->id }})">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleted('employee.employee', 'destroy',{{ $employee->id }})">
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
            {{ $employees->links() }}
        </div>
        <div class="col-12 position-absolute top-50 text-center ">
            <div wire:loading class="spinner-border text-primary" role="status"></div>
        </div>

        @include('livewire.employee.modal-create')
        @include('livewire.employee.modal-update')
        @include('livewire.employee.modal-show')

        @push('scripts')
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
