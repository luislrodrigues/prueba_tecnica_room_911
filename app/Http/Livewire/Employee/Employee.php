<?php

namespace App\Http\Livewire\Employee;

use App\Models\Department;
use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class Employee extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $department_id, $first_name, $last_name, $email, $document_number, $status, $id_selected;
    public $search, $departmentFilter;
    protected $listeners =['render' => 'render','destroy'];
    

    public function render()
    {
        $employees = ModelsEmployee::handleAll();
        $departments = Department::all();
        return view('livewire.employee.employee',[
            'employees'=> $this->employeeFilter($employees)->paginate(10),
        
        'departments'=> $departments]);
    }

    public function store(){

        $this->validate([
            'department_id'   => ['bail','required','exists:departments,id'],
            'first_name'      => ['bail','required','string'],
            'last_name'       => ['bail','required','string'],
            'email'           => ['bail','required','email'],
            'document_number' => ['bail','required','numeric','digits_between:7,12',Rule::unique('employees')->whereNull('deleted_at')]
        ]);

        ModelsEmployee::create([
            'department_id'   => $this->department_id ,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name ,
            'email'           => $this->email,
            'document_number' => $this->document_number ,
        ]);

        $this->emit('closeModal');
        $this->emit('alertSuccess','Employee created successfully');
        $this->reset('department_id','first_name', 'last_name','email','document_number');

    }

    public function destroy (ModelsEmployee $employee){
        $employee->delete();
        $this->emit('render');
    }

    public function edit(ModelsEmployee $employee){
        $this->id_selected = $employee->id;
        $this->department_id = $employee->department_id;
        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->email = $employee->email;
        $this->document_number = $employee->document_number;
        $this->status = $employee->status;
    }
    public function update(){
        $employee = ModelsEmployee::find($this->id_selected);

        $this->validate([
            'department_id'   => ['bail','required','exists:departments,id'],
            'first_name'      => ['bail','required','string'],
            'last_name'       => ['bail','required','string'],
            'email'           => ['bail','required','email'],
            'document_number' => ['bail','required','numeric','digits_between:7,12',Rule::unique('employees')->ignore($this->id_selected)->whereNull('deleted_at')]
        ]);

        $employee->update([
            'department_id'   => $this->department_id ,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name ,
            'email'           => $this->email,
            'document_number' => $this->document_number ,
            'status'          => $this->status
        ]);

        $this->emit('closeModal');
        $this->emit('alertSuccess','Employee updated successfully');
        $this->reset('department_id','first_name', 'last_name','email','document_number', 'status','id_selected');
    }
    public function restart(){
        $this->resetValidation();
        $this->reset('department_id','first_name', 'last_name','email','document_number');
    }

    public function employeeFilter($employees){
       if($this->search){
        $employees->search($this->search);
       }

       if($this->departmentFilter > 0){    
            $employees->departmentFilter($this->departmentFilter);
       }
       return $employees;
    }

    public function cleanFilter(){
        $this->reset('search','departmentFilter');
    }
}
