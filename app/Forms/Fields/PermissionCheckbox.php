<?php namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class PermissionCheckbox extends FormField {

    protected function getTemplate()
    {
        return 'rbac.permission_checkbox';
    }

    public function render(array $options = [],  $showLabel = true, $showField = true, $showError = true)
    {
        return parent::render($options, $showLabel, $showField, $showError);
    }
}