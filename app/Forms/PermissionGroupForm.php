<?php namespace App\Forms;

use App\Models\PermissionGroup;
use Kris\LaravelFormBuilder\Form;

class PermissionGroupForm extends Form{

    protected function getGroups()
    {
        $array = PermissionGroup::lists('name', 'id')->toArray();
		return !isset($this->model->id) ? $array : array_except($array,$this->model->id);
    }

    protected function getGroupsSelected()
    {
        return !isset($this->model->id) ?'': $this->model->parent_id;
    }

    public function buildForm()
    {
        $this
			->add('name', 'text', ['label' => trans('messages.name')])
            ->add('parent_id', 'select', [
                'label' => trans('messages.parent_id'),
                'choices' => $this->getGroups(),
                'selected' => $this->getGroupsSelected(),
                'empty_value' => trans('messages.please_select'),
			]);
    }
}