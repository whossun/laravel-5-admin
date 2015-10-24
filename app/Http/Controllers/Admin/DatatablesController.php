<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use Datatables;

class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('articles.datatable');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        return Datatables::of(Article::select('*'))
        ->addColumn('action', '<a class="btn btn-primary btn-xs" href="articles/{{$id}}/edit" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>')       
        // ->addColumn('check', '<input type="checkbox" name="ids[]" value="{{$id}}" class="chbids" />')
        ->make(true);
    }
}
