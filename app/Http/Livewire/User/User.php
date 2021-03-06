<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User as ModelsUser;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_name, $email, $password, $role_id, $status, $id_selected, $search, $roles;

    protected $listeners = ['render' => 'render', 'destroy'];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        $users = ModelsUser::where('user_name', 'like', '%' . $this->search . '%')->handleAll()->paginate(7);

        return view('livewire.user.user', compact('users'));
    }

    public function store()
    {
        $this->validate([
            'user_name' => ['bail', 'required', 'string', 'min:4', Rule::unique('users')->whereNull('deleted_at')],
            'email' => ['bail', 'required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'password' => ['bail', 'required', 'min:4'],
            'role_id' => ['bail', 'required', 'exists:roles,id'],
        ]);

        ModelsUser::create([
            'user_name' => $this->user_name,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->role_id,
        ]);

        $this->emit('closeModal');
        $this->emit('alertSuccess', 'User created successfully');
        $this->reset('user_name', 'email', 'password', 'role_id');
    }

    public function edit(ModelsUser $user)
    {
        $this->id_selected = $user->id;
        $this->user_name = $user->user_name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->status = $user->status;
    }

    public function update()
    {
        $user = ModelsUser::find($this->id_selected);

        $this->validate([
            'user_name' => ['bail', 'required', 'string', Rule::unique('users')->ignore($this->id_selected)->whereNull('deleted_at')],
            'email' => ['bail', 'required', 'email', Rule::unique('users')->ignore($this->id_selected)->whereNull('deleted_at')],
            'password' => ['bail', 'nullable', 'min:4'],
            'role_id' => ['bail', 'required', 'exists:roles,id'],
        ]);

        $user->update([
            'user_name' => $this->user_name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'status' => $this->status,
        ]);

        if ($this->password) {
            $user->password = bcrypt($this->password);
            $user->save();
        }

        $this->emit('closeModal');
        $this->emit('alertSuccess', 'User updated successfully');
        $this->reset('user_name', 'email', 'password', 'role_id', 'id_selected');
    }

    public function destroy(ModelsUser $user)
    {
        $user->delete();
        $this->emit('render');
    }

    public function restart()
    {
        $this->resetValidation();
        $this->reset('user_name', 'email', 'password', 'role_id', 'status', 'id_selected');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
