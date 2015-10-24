<?php namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $model;

    public $datatable_addtions =  [
        "checkbox" => "{ data: null,title:'<input type=\"checkbox\" name=\"select_all\"/>',render: function (data){return '<input type=\"checkbox\" name=\"ids[]\" value=\"' + data.id + '\"/>'},className:'dt-center',width:'25px',orderable: false, searchable: false},",
        "action"   => "{ data: 'action', name: 'action',className:'dt-center',title:'#', orderable: false, searchable: false}",
    ];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function save($id, $data)
    {
        $class = get_class($this->model);

        $object = (is_null($id)) ? new $class() : $class::find($id);
        $object->fill($data);
        $object->save();

        return $object;
    }

    public function deleteAll($ids)
    {
        $this->model->destroy($ids);
    }

    public function all()
    {
        return $this->model->select(array_divide($this->datatable_fields)[0]);
    }

    public function config()
    {
        $str = "";
        $array = array_dot($this->datatable_fields);
        foreach (array_divide($this->datatable_fields)[0] as $value) {
            $str .= "{ data: '".$value."', name: '".$value."', title:'".trans('messages.'.$value)."', orderable: ".strbool($array[$value.'.orderable']).", searchable: ".strbool($array[$value.'.searchable'])." },";
        }
        return $str;
    }
    
    public function columns(){
        return "[".$this->datatable_addtions['checkbox'].$this->config().$this->datatable_addtions['action']."]";
    }


    public function action_butttons($search_array) {
        $buttons =  [
        'show' => '<a class="btn btn-warning btn-xs" href="'.$this->model->getTable().'/{{$id}}" data-toggle="tooltip" title="'.trans('messages.show').'" data-original-title="'.trans('messages.show').'"><i class="fa fa-eye"></i></a>',
        'edit' => '<a class="btn btn-primary btn-xs" href="'.$this->model->getTable().'/{{$id}}/edit" data-toggle="tooltip" title="'.trans('messages.edit').'" data-original-title="'.trans('messages.edit').'"><i class="fa fa-pencil"></i></a>',
        'delete' => '<a class="btn btn-danger btn-xs btn-delete" data-toggle="tooltip"  data-id="{{$id}}" title="'.trans('messages.delete').'" data-original-title="'.trans('messages.delete').'"><i class="fa fa-trash"></i></a>',
        ];
        $str = "";
        foreach ($buttons as $key=>$value) {
            if (in_array($key, $search_array)) {
                $str .= $value."\n";
            }
        }
        return $str;
    }  

}
