<?php
namespace app\common\model\mysql;


use think\Model;

class User extends Model
{
    protected $table = 'user';

    public function getUserByUsername($username){
        if (empty($username)){
            return false;
        }
        return $this->where(['name'=>trim($username)])->find();

    }
    public function upDateById($id,$data){

        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data) ){
            return false;
        }
        return $this->where(['id'=>$id])->save($data);

    }

}
