<?php namespace App\Forms;

use App\Models\Permission;
use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    protected function getPermissions()
    {
        return Permission::lists('display_name', 'id')->toArray();
    }

    protected function getPermissionsSelected()
    {
        return !isset($this->model->id) ?: $this->model->permissions()->lists('id')->toArray();
    }

    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('messages.name')])
            ->add('display_name', 'text', ['label' => trans('messages.label')])
            ->add('permissions', 'select', [
                'choices' => $this->getPermissions(),
                'selected' => $this->getPermissionsSelected(),
                'display_name' => trans('messages.permissions.index'),
                'attr' => [
                    'multiple' => true,
                    'id' => 'permissions'
                ],
            ])
            ->add('task', 'hidden')
        ;
    }
}
