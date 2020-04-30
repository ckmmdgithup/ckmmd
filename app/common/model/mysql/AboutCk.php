<?php
namespace app\common\model\mysql;


use think\Model;

class AboutCk extends Model
{
    protected $table = 'about_ck';

    public function updateAboutCk($data){
        if (empty($data) || !is_array($data)) return false;
        $where = [
            'id' => 1,

        ];
        return $this->where($where)->update($data);
    }
    public function getCkInformation(){
        $where = [
            'id' => 1,
        ];
        return $this->where($where)->find();

    }


}
