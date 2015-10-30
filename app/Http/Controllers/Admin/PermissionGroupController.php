<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionGroupRepository as PermissionGroup;
use App\Http\Requests\PermissionGroupRequest;
use Datatables;

class PermissionGroupController extends Controller {

    private $permissiongroup;

    public function __construct(PermissionGroup $permissiongroup)
    {
        $this->permissiongroup = $permissiongroup;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of($this->permissiongroup->all())
            ->addColumn('action', function($model) { return $this->permissiongroup->action_butttons($model);})
            ->make(true);
        }
        $html = $this->permissiongroup->columns();
        return view('datatable',compact('html'));
    }

    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\PermissionGroupForm', [
            'method' => 'POST',
            'url' => route('admin.permissiongroups.store')
        ]);
        return view('layout.partials.form', compact('form'));
    }

    public function store(PermissionGroupRequest $request)
    {
        $permissiongroup = $this->permissiongroup->save(null, $request->all());
        $route = ($request->get('task')=='apply') ? route('admin.permissiongroups.edit', $permissiongroup->id) : route('admin.permissiongroups.index');
        return redirect($route)->with([
            'status' => trans('messages.saved'),
            'type-status' => 'success'
        ]);
    }

    public function show($id)
    {
        $permissiongroup = $this->permissiongroup->getModel()->findOrFail($id);
        return view('permissiongroups.show', compact('permissiongroup'));
    }

    public function edit($id, FormBuilder $formBuilder)
    {
        $permissiongroup = $this->permissiongroup->getModel()->findOrFail($id);
        $form = $formBuilder->create('App\Forms\PermissionGroupForm', [
            'model' => $permissiongroup,
            'method' => 'PUT',
            'url' => route('admin.permissiongroups.update', $id)
        ]);
        return view('layout.partials.form', compact('form'));
    }

    public function update($id, PermissionGroupRequest $request)
    {
        $this->permissiongroup->save($id, $request->all());
        $route = ($request->get('task')=='apply') ? route('admin.permissiongroups.edit', $id) : route('admin.permissiongroups.index');
        return redirect($route)->with([
            'status' => trans('messages.saved'),
            'type-status' => 'success'
        ]);
    }

    public function destroy($ids)
    {
        $this->permissiongroup->deleteAll(explode(',', $ids));
        return [
            'status' => trans('messages.delete.success'),
            'type' => 'success'
        ];
    }

}
