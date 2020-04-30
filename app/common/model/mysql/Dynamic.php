<?php
namespace app\common\model\mysql;


use think\Model;

class Dynamic extends Model
{
    protected $table = 'dynamic';

    public function saveDynamic($data){
        if (empty($data) || !is_array($data)) return false;

        return $this->save($data);
    }
    public function getDynamic(){

        $order = [
            'create_time'=>'desc',
        ];
        return $this->order($order)->paginate(config('app.page_num'));

    }
    public function delDynamicById($id){
        $where = [
            'id'=>$id
        ];

        return $this->where($where)->delete();
    }


}
