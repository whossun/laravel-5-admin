<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PermissionGroupForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('messages.name')])
            ->add('task', 'hidden')
        ;
    }
}