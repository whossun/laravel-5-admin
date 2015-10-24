<?php namespace App\Repositories;

use Illuminate\Http\Request;
use App\User;

class UserRepository extends Repository
{

    protected $datatable_fields = [
        'id'         => ['orderable' => true,'searchable' => false],
        'name'      => ['orderable' => true,'searchable' => true],
        'email'      => ['orderable' => true,'searchable' => true],
        'created_at' => ['orderable' => true,'searchable' => false],
        'updated_at' => ['orderable' => true,'searchable' => false],
    ];    

    public function __construct(User $user)
    {
        $this->model = $user;
    }


    public function save($id, $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = parent::save($id, $data);

        //Assing user roles
        if (count($data['roles']) > 0) {
            $user->roles()->sync($data['roles']);
        }

        return $user;
    }
}
