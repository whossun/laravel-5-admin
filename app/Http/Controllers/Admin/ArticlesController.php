<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository as Article;
use App\Http\Requests\ArticleRequest;
use Datatables;
use Auth;


class ArticlesController extends Controller {

    /**
     * Repostory article
     *
     * @var ArticleRepository
     */
    private $article;

    /**
     * Construc controller.
     *
     * @param  Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of($this->article->all())
            ->editColumn('author', function ($model) {
                return $model->user->name;
            })
            ->addColumn('action', $this->article->action_butttons(['show','edit','delete']))
            ->make(true);
        }
        $html = $this->article->columns();
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
        $form = $formBuilder->create('App\Forms\ArticleForm', [
            'method' => 'POST',
            'url' => route('admin.articles.store')
        ]);

        return view('layout.partials.form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {

        $data = $request->all();
        $data['author'] =  Auth::id();
        
        $article = $this->article->save(null,$data);
        $route = ($request->get('task')=='apply') ? route('admin.articles.edit', $article->id) : route('admin.articles.index');

        return redirect($route)->with([
            'status' => trans('messages.saved'), 
            'type-status' => 'success'
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
        $article = $this->article->getModel()->findOrFail($id);

        return view('articles.show', compact('article'));
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
        $article = $this->article->getModel()->findOrFail($id);

        $form = $formBuilder->create('App\Forms\ArticleForm', [
            'model' => $article,
            'method' => 'PATCH',
            'url' => route('admin.articles.update', $id)
        ]);

        return view('layout.partials.form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  ArticleRequest  $request
     * @return Response
     */
    public function update($id, ArticleRequest $request)
    {
        $data = $request->all();
        // $data['name'] =  '123';
        // $data['author'] =  Auth::id();
        $this->article->save($id, $data);

        $route = ($request->get('task')=='apply') ? route('admin.articles.edit', $id) : route('admin.articles.index');

        return redirect($route)->with([
            'status' => trans('messages.saved'), 
            'type-status' => 'success'
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
        $this->article->deleteAll(explode(',', $ids));
        return [
            'status' => trans('messages.delete.success'), 
            'type-status' => 'success'
        ];
    }


}
