<?php
namespace app\common\model\mysql;

use think\Model;

class ArticleCategory extends Model
{

    protected $table = 'article_category';

    public function article(){


        return $this->hasOne(Article::class,'cate_uname','uname');
    }

    public function saveArticleCategory($data){
        if (empty($data) || !is_array($data)) return false;

        return $this->save($data);
    }
    public function updateArticleCategory($data){
        if (empty($data) || !is_array($data)) return false;
        $where = [
            'id' => $data['id'],

        ];
        return $this->where($where)->update($data);
    }
    public function updateArticleCategoryStatus($where,$status){

        return $this->where($where)
            ->update($status);
    }
    public function getArticleCategoryByName($name){
        if (empty($name)) return false;

        $where = [
            'name' => $name,
        ];

        return $this->where($where)->find();

    }
    public function getArticleCategoryByUname($uname){
        if (empty($uname)) return false;

        $where = [
            'name' => $uname,
        ];

        return $this->where($where)->find();

    }
    public function getArticleCategoryList(){
        $where = [
            ['status','<>',-1]
        ];

        return $this->where($where)
                    ->orderRaw("concat(path,id)")
                    ->select()
                    ->toArray();
    }
    public function getArticleCategoryById($id){
        $where = [
            'id'=>$id,
            'status'=>1
        ];
        return $this->where($where)->find();
    }
    public function getArticleCategoryByPid($pid){
        $where = [
            'pid'=>$pid,
            'status'=>1
        ];
        return $this->where($where)
            ->select()
            ->toArray();
    }
    public function getArticleCategorySonByPath($path){

        $where = [
            ['status','=',1],
            ['path','like','%'.$path.'%']
        ];

        return $this->where($where)
            ->select()
            ->toArray();
    }

    public function getArticleCategorySonByWhere($where){

        return $this->where($where)
            ->select()
            ->toArray();
    }

    
}










