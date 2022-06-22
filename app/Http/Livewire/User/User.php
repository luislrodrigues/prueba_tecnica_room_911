<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User as ModelsUser;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_name, $email, $password, $role_id, $status, $id_selected ,$search;

    protected $listeners =['render' => 'render','destroy'];


    public function render()
    {
        $users = ModelsUser::where('user_name','like','%' . $this->search . '%')->handleAll()->paginate(7);
        $roles = Role::all();

        return view('livewire.user.user', compact('users','roles'));
    }


    public function store(){
        $this->validate([
            'user_name' => ['required','string','min:4',Rule::unique('users')->whereNull('deleted_at')],
            'email'     => ['required','email',Rule::unique('users')->whereNull('deleted_at')],
            'password'  => ['required','min:4'],
            'role_id'   => ['required','exists:roles,id']
        ]);

        ModelsUser::create([
            'user_name' => $this->user_name,
            'email'     => $this->email,
            'password'  => $this->password,
            'role_id'   => $this->role_id,
        ]);

        $this->emit('closeModal');
        $this->emit('alertSuccess','User created successfully');
        $this->reset('user_name','email','password','role_id');
    }

    public function edit(ModelsUser $user){
        $this->id_selected = $user->id;
        $this->user_name = $user->user_name;
        $this->email = $user->email;
        $this->role_id  = $user->role_id;
        $this->status = $user->status;
    }

    public function update(){
        $user = ModelsUser::find($this->id_selected);

        $this->validate([
            'user_name'   => ['required','string',Rule::unique('users')->ignore($this->id_selected)->whereNull('deleted_at')],
            'email'       => ['required','email',Rule::unique('users')->ignore($this->id_selected)->whereNull('deleted_at')],
            'password'    => ['nullable','min:4'],
            'role_id'     => ['required','exists:roles,id']
        ]);

        $user->update([
            'user_name'   => $this->user_name,
            'email'       => $this->email,
            'role_id'     => $this->role_id,
            'status'      => $this->status
        ]);

        if($this->password){
            $user->password = bcrypt($this->password);
            $user->save();
        }

        $this->emit('closeModal');
        $this->emit('alertSuccess','User updated successfully');
        $this->reset('user_name','email','password','role_id','id_selected');
    }

    public function destroy (ModelsUser $user){
        $user->delete();
        $this->emit('render');
    }
   
    public function restart(){
        $this->resetValidation();
        $this->reset('user_name','email','password','role_id','status','id_selected');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
