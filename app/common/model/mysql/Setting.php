<?php
namespace app\common\model\mysql;


use think\Model;

class Setting extends Model
{
    protected $table = 'setting';

    public function updateSetting($data){
        if (empty($data) || !is_array($data)) return false;
        $where = [
            'id' => 1,

        ];
        return $this->where($where)->update($data);
    }
    public function getWebInformation(){
        $where = [
            'id' => 1,
        ];
        return $this->where($where)->find();

    }


}
