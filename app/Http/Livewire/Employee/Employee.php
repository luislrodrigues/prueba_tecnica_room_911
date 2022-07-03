<?php

namespace App\Http\Livewire\Employee;

use App\Imports\EmployeesImport;
use App\Models\Department;
use App\Models\Employee as ModelsEmployee;
use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class Employee extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $department_id, $first_name, $last_name, $email, $document_number, $status, $id_selected;
    public  $departments, $search, $departmentFilter, $file_csv, $document_number_entry, $action = 1 ;
    protected $listeners = ['render' => 'render', 'destroy'];
    public $entries, $employee, $date_from, $date_to;

    public function mount()
    {
        $this->departments = Department::all();

    }

    public function render()
    {
        $employees = ModelsEmployee::handleAll();
        return view('livewire.employee.employee', [
            'employees'   => $this->employeeFilter($employees)->paginate(10)
        ]);
    }


    public function store()
    {
        $this->validate([
            'department_id'   => ['bail', 'required', 'exists:departments,id'],
            'first_name'      => ['bail', 'required', 'string'],
            'last_name'       => ['bail', 'required', 'string'],
            'email'           => ['bail', 'required', 'email',Rule::unique('employees')->whereNull('deleted_at')],
            'document_number' => ['bail', 'required', 'numeric', 'digits_between:7,12', Rule::unique('employees')->whereNull('deleted_at')],
        ]);

        ModelsEmployee::create([
            'department_id' => $this->department_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'document_number' => $this->document_number,
        ]);

        $this->emit('closeModal');
        $this->emit('alertSuccess', 'Employee created successfully');
        $this->reset('department_id', 'first_name', 'last_name', 'email', 'document_number');
    }

    public function show(ModelsEmployee $employee, $action)
    {
        $this->action = $action;
        $this->id_selected = $employee->id;
        $this->employee = $employee;
        $this->entries = $employee->entries;        
    }

    public function entryShowFilter()
    {
        $entries = Entry::getEntryEmployee($this->id_selected);
        if ($this->date_from && $this->date_to ) {
            $entries->dateEntry($this->date_from, $this->date_to);
        }
        $this->entries = $entries->get();
    }

    public function edit(ModelsEmployee $employee)
    {
        $this->id_selected = $employee->id;
        $this->department_id = $employee->department_id;
        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->email = $employee->email;
        $this->document_number = $employee->document_number;
        $this->status = $employee->status;
    }


    public function update()
    {
        $employee = ModelsEmployee::find($this->id_selected);

        $this->validate([
            'department_id'   => ['bail', 'required', 'exists:departments,id'],
            'first_name'      => ['bail', 'required', 'string'],
            'last_name'       => ['bail', 'required', 'string'],
            'email'           => ['bail', 'required', 'email', Rule::unique('employees')->ignore($this->id_selected)->whereNull('deleted_at')],
            'document_number' => ['bail', 'required', 'numeric', 'digits_between:7,12', Rule::unique('employees')->ignore($this->id_selected)->whereNull('deleted_at')],
        ]);

        $employee->update([
            'department_id'   => $this->department_id,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'email'           => $this->email,
            'document_number' => $this->document_number,
            'status'          => $this->status,
        ]);

        $this->emit('closeModal');
        $this->emit('alertSuccess', 'Employee updated successfully');
        $this->reset('department_id', 'first_name', 'last_name', 'email', 'document_number', 'status', 'id_selected');
    }


    public function destroy(ModelsEmployee $employee)
    {
        $employee->delete();
        $employee->entries()->delete();
        $this->emit('render');
    }

    public function storeCsv()
    {
        Excel::import(new EmployeesImport, $this->file_csv);
        $this->emit('closeModal');
        $this->emit('alertSuccess', 'Employees created successfully');
        $this->reset('file_csv');
    }


    public function entry()
    {
        $employee = ModelsEmployee::where('document_number', $this->document_number_entry)->first();
        if ($employee) {
            if ($employee->status == 'ENABLED') {
                Entry::create([
                    'employee_id'  => $employee->id,
                    'entry_action' => 'YES',
                ]);
                $this->emit('alertSuccess', 'allowed access');
            } else {
                Entry::create([
                    'employee_id'  => $employee->id,
                    'entry_action' => 'NO',
                ]);
                $this->emit('alertFailed', 'disabled employee');
            }
            $this->emit('closeModal');
            $this->reset('document_number_entry');
        } else {
            entry::create([
                'document_number' => $this->document_number_entry,
                'entry_action'    => 'NO',
            ]);
            $this->emit('closeModal');
            $this->reset('document_number_entry');
            $this->emit('alertFailed', 'unauthorized');
        }
    }

    public function historyPDF(){
        $entries = Entry::all();
        $pdf = PDF::loadView('historyPDF',compact('entries'));
        return $pdf->stream("history-PDF.pdf");
    }


    public function employeeFilter($employees)
    {
        if ($this->search) {
            $this->resetPage();
            $employees->search($this->search);
        }
        if ($this->departmentFilter > 0) {
            $this->resetPage();
            $employees->departmentFilter($this->departmentFilter);
        }
        return $employees;
    }


    public function cleanFilter()
    {
        $this->reset('search', 'departmentFilter');
        $this->resetPage();
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function restart()
    {
        $this->resetValidation();
        $this->reset('department_id', 'first_name', 'last_name', 'email', 'document_number', 'document_number_entry','action');
    }
}
