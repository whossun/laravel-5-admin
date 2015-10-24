<?php namespace App\Repositories;

use Illuminate\Http\Request;
use App\Setting;

class SettingRepository extends Repository {

    protected $datatable_fields = [
        'id'         => ['orderable' => true,'searchable' => false],
        'title'      => ['orderable' => true,'searchable' => true],
        'key'        => ['orderable' => true,'searchable' => true],
        'created_at' => ['orderable' => true,'searchable' => false],
        'updated_at' => ['orderable' => true,'searchable' => false],
    ];

    public function __construct(Setting $setting, $paginate=true)
    {
        $this->model = $setting;
    }

    //自定义显示
/*    public function columns(){
        return "[".$this->config().$this->datatable_addtions['action']."]";
    }*/

}