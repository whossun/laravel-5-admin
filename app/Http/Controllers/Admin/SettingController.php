<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository as Setting;
use App\Http\Requests\SettingRequest;
use Datatables;

class SettingController extends Controller {

    /**
     * Repostory setting
     *
     * @var SettingRepository
     */
    private $setting;

    /**
     * Construc controller.
     *
     * @param  Setting $setting
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
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
            return Datatables::of($this->setting->all())
            ->addColumn('action', function($model) { return $this->setting->action_butttons($model);})
            ->make(true);
        }
        $html = $this->setting->columns();
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
        $form = $formBuilder->create('App\Forms\SettingForm', [
            'method' => 'POST',
            'url' => route('admin.settings.store')
        ]);

        return view('layout.partials.form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SettingRequest  $request
     * @return Response
     */
    public function store(SettingRequest $request)
    {
        $setting = $this->setting->save(null, $request->all());

        $route = ($request->get('task')=='apply') ? route('admin.settings.edit', $setting->id) : route('admin.settings.index');

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
        $setting = $this->setting->getModel()->findOrFail($id);

        return view('settings.show', compact('setting'));
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
        $setting = $this->setting->getModel()->findOrFail($id);

        $form = $formBuilder->create('App\Forms\SettingForm', [
            'model' => $setting,
            'method' => 'PUT',
            'url' => route('admin.settings.update', $id)
        ]);

        return view('layout.partials.form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  SettingRequest  $request
     * @return Response
     */
    public function update($id, SettingRequest $request)
    {
        $this->setting->save($id, $request->all());

        $route = ($request->get('task')=='apply') ? route('admin.settings.edit', $id) : route('admin.settings.index');

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
        $this->setting->deleteAll(explode(',', $ids));
        return [
            'status' => trans('messages.delete.success'), 
            'type' => 'success'
        ];
    }


}
