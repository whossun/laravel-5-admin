<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository as User;
use App\Http\Requests\UserRequest;
use Datatables;

class UserController extends Controller
{
    /**
     * Repostory user
     *
     * @var UserRepository
     */
    private $user;

    /**
     * Construc controller.
     *
     * @param  User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of($this->user->all())
            ->addColumn('action', function($model) { return $this->user->action_butttons($model);})
            ->make(true);
        }
        $html = $this->user->columns();
        return view('datatable',compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  FormBuilder  $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\UserForm', [
            'method' => 'POST',
            'url' => route('admin.users.store')
        ]);

        return view('layout.partials.form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $user = $this->user->save(null, $request->all());

        $route = ($request->get('task')=='apply') ? route('admin.users.edit', $user->id) : route('admin.users.index');

        return redirect($route)->with([
            'status' => trans('messages.saved'),
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = $this->user->getModel()->findOrFail($id);

        return view('access.user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  FormBuilder  $formBuilder
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $user = $this->user->getModel()->findOrFail($id);

        $form = $formBuilder->create('App\Forms\UserForm', [
            'model' => $user,
            // 'method' => 'PATCH',
            'method' => 'PUT',
            'url' => route('admin.users.update', $id)
        ]);

        return view('layout.partials.form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  UserRequest  $request
     * @return Response
     */
    public function update($id, UserRequest $request)
    {
        $data = ($request->has('password')) ? $request->all() : $request->except('password');

        $this->user->save($id, $data);

        $route = ($request->get('task')=='apply') ? route('admin.users.edit', $id) : route('admin.users.index');

        return redirect($route)->with([
            'status' => trans('messages.saved'),
            'type' => 'success'
        ]);
    }

    /**
     * Remove  resources from storage.
     *
     * @param  array  $id
     * @return Response
     */
    public function destroy($ids)
    {
        $this->user->deleteAll(explode(',', $ids));
        return [
            'status' => trans('messages.delete.success'), 
            'type' => 'success'
        ];
    }

}
