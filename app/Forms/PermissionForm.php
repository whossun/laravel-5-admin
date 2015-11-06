<?php namespace App\Forms;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Repositories\PermissionGroupRepository;
use Kris\LaravelFormBuilder\Form;

class PermissionForm extends Form
{

    public function __construct(PermissionGroupRepository $permissiongroup)
    {
        $this->permissiongroup = $permissiongroup;
    }

    protected function getGroups()
    {
        // return PermissionGroup::lists('name', 'id')->toArray();
        dd($this->permissiongroup->getOrderdGroups());
        // dd(PermissionGroup::lists('name', 'id')->toArray());
        list($keys, $values) = array_divide($this->getOrderdPermissions());
        dd($this->permissiongroup->getModel()->find($keys)->lists('name', 'id')->toArray());
    }

    protected function getGroupsSelected()
    {
        return !isset($this->model->id) ?'': $this->model->group_id;
    }

    protected function getPermissons()
    {
        $array = Permission::lists('display_name', 'id')->toArray();
        return !isset($this->model->id) ? $array : array_except($array,$this->model->id);
    }

    protected function getOrderdPermissions()
    {
        return $this->permissiongroup->getOrderdPermissions();
    }

    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('messages.name')])
            ->add('display_name', 'text', ['label' => trans('messages.display_name')])
            ->add('group_id', 'select', [
                'label' => trans('messages.group_id'),
                'choices' => $this->getGroups(),
                'selected' => $this->getGroupsSelected(),
                'empty_value' => trans('messages.please_select'),
			])
			->add('sort', 'text', ['label' => trans('messages.sort')])
            ->add('permission_dependencies', 'permission_checkbox', [
                'label' => '权限依赖',
                'choices' => $this->getPermissons(),
                'tree' => $this->getPermissonss(),
                'current' => isset($this->model->id)?$this->model->id:0,
                'selected' => [1,2],

            ])
        ;
    }
}