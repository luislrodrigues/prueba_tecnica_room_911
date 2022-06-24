<div class="mx-4">
<div class="row mb-3 ">
  <div class="col-lg-3 col-md-4 col-sm-6">
      <label>Full Name</label>
      <h5>{{$employee->full_name}}</h5>
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 ">
    <label>Document number</label>
    <h5>{{$employee->document_number}}</h5>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 ">
  <label>Email</label>
  <h5>{{$employee->email}}</h5>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 ">
  <label>Department</label>
  <h5>{{$employee->department->name}}</h5>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 ">
  <label>Status</label>
  <h5>{{$employee->status}}</h5>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 ">
  <label>Last access</label>
  <h5>{{$employee->last_entry}}</h5>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 ">
  <label>Total entry</label>
  <h5>{{$employee->last_entry_total}}</h5>
</div>
</div>
    <div class="form-group">
        <div class="row mb-2  d-flex justify-content-center">
            <div class="col-sm-3 col-xs-12 ">
                <label class="form-label fw-bold">Date initial</label>
                <input type="date" class="form-control" wire:change="entryShowFilter" wire:model="date_from" />
            </div>
            <div class="col-sm-3 col-xs-12 ">
                <label class="form-label fw-bold">Date final</label>
                <input type="date" class="form-control" wire:change="entryShowFilter" wire:model="date_to" />
            </div>
        </div>
        <div class="d-flex justify-content-center row">

            <div class="table-responsive mx-3 mb-2 col-lg-4 col-md-6 col-sm-8">
                @if ($entries->count())
                    <table
                        class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">Entry</th>
                                <th class="text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td
                                        class="text-center fw-bold {{ $entry->entry_action == 'YES' ? 'text-success' : 'text-danger' }}">
                                        {{ $entry->entry_action }}
                                    </td>
                                    <td class="text-center">{{ $entry->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="d-flex justify-content-center mt-3">
                        <h4>There are no records</h4>
                    </div>
                @endif
            </div>
        </div>
        <div class="position-absolute" style="bottom: 60px">
            <button class="btn btn-success" wire:click="restart">EXIT</button>
        </div>
    </div>
