<?php namespace App\Repositories;

use App\Models\PermissionGroup;

class PermissionGroupRepository extends Repository {

    public function __construct(PermissionGroup $permissiongroup)
    {
        $this->model = $permissiongroup;
    }

    public function getAllGroups($withChildren = false) {
        if ($withChildren)
            return $this->model->orderBy('name', 'asc')->get();

        return $this->model->with('children', 'permissions')
            ->whereNull('parent_id')
            ->orderBy('sort', 'asc')
            ->get();
    }

    public function getHierarchy($projects){
        $string = '<ol class="dd-list">';
        foreach ($projects as $i => $project) {
            $string .= '<li class="dd-item" data-id="'.$project->id.'">';
            $string .= '<div class="dd-handle">'.$project->name.'<span class="pull-right">'.$project->permissions->count().'个权限</span></div>';
            if($project->children->count()){
                $string .= $this->getHierarchy($project->children()->get());
            }
            $string .= "</li>";
        }
        $string .= "</ol>";
        return $string;
    }

    public function getTree($projects)
    {
        $string = '<ul>';
        foreach ($projects as $i => $project) {
            $string .= '<li data-id="'.$project->id.'" data-name="'.$project->name.'">';
            $string .= $project->name;
            if($project->permissions->count()){
                $string .= '<ul>';
                foreach ($project->permissions as $permission) {
                    $string .= '<li data-jstree=\'{"icon":"fa fa-lock","disabled":true}\'>'.$permission->display_name .'</li>';
                }
                $string .= "</ul>";
            }
            if ($project->children()->count()) {
                $string .= $this->getTree($project->children()->get());
            }
            $string .= "</li>";
        }
        $string .= "</ul>";
        return $string;
    }

    public function getPermissionsArray($projects)
    {
        $array = [];
        foreach ($projects as $project) {
            if($project->permissions->count()){
                $array[$project->id] = $project->permissions->lists('display_name', 'id')->toArray();
            }
            if ($project->children()->count()) {
                array_push($array,$this->getPermissionsArray($project->children()->get()));
            }
        }
        return $array;
    }

    public function getOrderdPermissions()
    {
        $projects = $this->getAllGroups();
        $permissions_array =  [];
        foreach (array_dot($this->getPermissionsArray($projects)) as $key => $permission) {
            $array =  explode('.',$key);
            end($array);
            $group =  prev($array);
            if (!isset($permissions_array[$group][last($array)])){
                $permissions_array[$group][last($array)] = [];
            }
            array_push($permissions_array[$group][last($array)],$permission);
        }
        return $permissions_array;
    }

    public function getGroupsArray($projects,$pre = '├─')
    {
        $array = [];
        foreach ($projects as $project) {
        	$array[$project->id]['name'] = $pre.$project->name;
            if ($project->children()->count()) {
            	array_push($array,$this->getGroupsArray($project->children()->get(),$pre.'──'));
            }
        }
        return $array;
    }

    public function getOrderdGroups(){
        $orderd_array =  array_dot($this->getGroupsArray($this->getAllGroups()));
        $groups_array =  [];
        foreach ($orderd_array as $key => $group_name) {
            $array =  explode('.',$key);
            end($array);
            $group =  prev($array);
            if(last($orderd_array)==$group_name)$group_name = str_replace('├─', '└─',$group_name);
            $groups_array[$group] = $group_name;
        }
        return $groups_array;
    }

    public function update($id, $input) {
        $group = $this->find($id);
        return $group->update($input);
    }

    public function updateSort($hierarchy) {
        foreach ($this->flattenJsonTree($hierarchy) as $group) {
            $this->find((int)$group['item_id'])->update([
                'parent_id' => (int)$group['parent'],
                'sort' => (int)$group['position'],
            ]);
        }
        return true;
    }

    private function flattenJsonTree($aJSON, $iParentId = 0, $iLevel = 0){
        $aRetval = [];
        $iPosition = 1;
        foreach ($aJSON as $aChilds) {
            $aDescendents = [];
            if (isset($aChilds['children'])) {
                $aDescendents = $this->flattenJsonTree(
                    $aChilds['children'], $aChilds['id'], $iLevel+1
                );
            }
            $aRetval[] = [
                'item_id'  => $aChilds['id'],
                'parent'   => $iParentId,
                'level'    => $iLevel,
                'position' => $iPosition++,
            ];
            $aRetval = array_merge($aRetval, $aDescendents);
        }
        return $aRetval;
    }

}