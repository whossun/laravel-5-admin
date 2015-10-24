<?php namespace App\Repositories;

use Illuminate\Http\Request;
use App\Article;

class ArticleRepository extends Repository {

    protected $datatable_fields = [
        'id'         => ['orderable' => true,'searchable' => false],
        'name'      => ['orderable' => true,'searchable' => true],
        'description'      => ['orderable' => true,'searchable' => true],
        'author'      => ['orderable' => true,'searchable' => true],
        'created_at' => ['orderable' => true,'searchable' => false],
        'updated_at' => ['orderable' => true,'searchable' => false],
    ];

    public function __construct(Article $article, $paginate=true)
    {
        $this->model = $article;
    }

}