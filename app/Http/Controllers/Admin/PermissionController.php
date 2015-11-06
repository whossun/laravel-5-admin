<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\PermissionGroupRepository as PermissionGroup;
use App\Http\Requests\PermissionRequest;
use Datatables;

class PermissionController extends Controller {

    private $permission;

    public function __construct(Permission $permission,PermissionGroup $permissiongroup)
    {
        $this->permission = $permission;
        $this->permissiongroup = $permissiongroup;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of($this->permission->all())
            ->addColumn('action', function($model) { return $this->permission->action_butttons($model);})
            ->editColumn('group_id', function($model) { if($model->group){return $model->group->name;}})
            ->make(true);
        }
        $html = $this->permission->columns();
        return view('datatable',compact('html'));
    }

    public function create(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\PermissionForm', [
            'method' => 'POST',
            'url' => route('admin.permissions.store')
        ]);
        return view($request->ajax()?'rbac.permission_ajaxform':'layout.partials.form', compact('form'));
    }

    public function store(PermissionRequest $request)
    {
        $permission = $this->permission->save(null, $request->all());
        if($request->ajax()){
            return response()->json([
                'status' => trans('messages.saved'),
                'type' => 'success'
            ]);
        }
        $route = ($request->get('task')=='apply') ? route('admin.permissions.edit', $permission->id) : route('admin.permissions.index');
        return redirect($route)->with([
            'status' => trans('messages.saved'),
            'type' => 'success'
        ]);
    }

    public function show($id)
    {
        $permission = $this->permission->find($id);

        return view('rbac.permission', compact('permission'));
    }

    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        $permission = $this->permission->find($id);

        $form = $formBuilder->create('App\Forms\PermissionForm', [
            'model' => $permission,
            'method' => 'PUT',
            'url' => route('admin.permissions.update', $id)
        ]);
        return view($request->ajax()?'rbac.permission_ajaxform':'layout.partials.form', compact('form'));
    }

    public function update($id, PermissionRequest $request)
    {
        $this->permission->save($id, $request->all());
        if($request->ajax()){
            return response()->json([
                'status' => trans('messages.saved'),
                'type' => 'success'
            ]);
        }        $route = ($request->get('task')=='apply') ? route('admin.permissions.edit', $id) : route('admin.permissions.index');
        return redirect($route)->with([
            'status' => trans('messages.saved'),
            'type' => 'success'
        ]);
    }

    public function destroy($ids)
    {
        $this->permission->deleteAll(explode(',', $ids));
        return [
            'status' => trans('messages.delete.success'), 
            'type' => 'success'
        ];
    }


}
