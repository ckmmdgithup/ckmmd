<?php
namespace app\admin\business;

use think\Exception;
use app\common\model\mysql\ArticleCategory as ArticleCategoryModel;



class ArticleCategory
{

    protected $article_category_model;

    public function __construct()
    {
        $this->article_category_model = new ArticleCategoryModel();
    }

    public function add($data){
        $article_category_by_name = $this->article_category_model->getArticleCategoryByName($data['name']);
        if ($article_category_by_name){
            throw new Exception('类名已经存在',config('status.break'));
        }
        $save_data = [
            'pid'=>0,
            'name' => $data['name'],
            'has_son'=>0,
            'create_time'=>time(),
            'update_time'=>time(),
            'status'=>config('status.mysql.dis_init'),
            'path'=>'0,',
        ];
        $result = $this->article_category_model->saveArticleCategory($save_data);
        if (!$result){
            throw new Exception('添加失败!',config('status.break'));
        }
        return true;
    }
    public function getArticleCategoryById($id){
        $article_category_by_id = $this->article_category_model->getArticleCategoryById($id);
        if ($article_category_by_id == []){
            throw new Exception('查找不到!',config('status.break'));
        }
        return $article_category_by_id;

    }

    public function ArticleCategoryUpdate($data){

        $article_category = $this->article_category_model->getArticleCategoryById($data['id']);
        $article_category_by_uname = $this->article_category_model->getArticleCategoryByUname($data['uname']);
        if (!empty($article_category_by_uname) && $article_category_by_uname['id']!=$article_category['id']){
            throw new Exception('类名已经存在',config('status.break'));
        }
        if ($data['has_son'] == 1 && $article_category->pid != $data['pid']){
            //return 123;
            //&& $article_category->pid != $data['pid']
            $result_son = $this->article_category_model->getArticleCategorySonByPath(strval($article_category['path']).$article_category['id']);
            //return $result_son;
            foreach ($result_son as $son_data){

                $sub = strpos($son_data['path'],strval($article_category['id']));
                $son_path = substr($son_data['path'],$sub);
                $son_update = [
                    'id'=>$son_data['id'],
                    'path'=>$data['path'].$son_path,
                    'update_time'=>time(),
                ];
                //print_r($sub);
                $this->article_category_model->updateArticleCategory($son_update);
            }
        }
        $result = $this->article_category_model->updateArticleCategory($data);
        if (!$result){
            throw new Exception('更新失败!',config('status.break'));
        }
        if ($article_category['uname']!=$data['uname']){
            $this->article_category_model->article()->where(['cate_uname'=>$article_category['uname']])->update(['cate_uname'=>$data['uname']]);
        }
        $result_brother = $this->article_category_model->getArticleCategoryByPid($article_category['pid']);
        if (empty($result_brother) == true){
            //return 456;
            $update_data_pid = [
                'id'=>$article_category['pid'],
                'update_time'=>time(),
                'has_son'=>0
            ];
            $this->article_category_model->updateArticleCategory($update_data_pid);
        }
        //return 123;
        $update_data_pid = [
            'id'=>$data['pid'],
            'update_time'=>time(),
            'has_son'=>1
        ];
        $this->article_category_model->updateArticleCategory($update_data_pid);
        return true;

    }
    public function ArticleCategoryStatusUpdate($data){

        $status = [
            'status'=>$data['status']
        ];
        if ($data['has_son']==1){
            $where = [
                ['path','like','%'.$data['path'].$data['id'].'%']
            ];

            $result_son = $this->article_category_model->updateArticleCategoryStatus($where,$status);
            if (!$result_son){
                throw new Exception('更新失败!',config('status.break'));
            }
            //获取子分类
            $article_category_son = $this->article_category_model->getArticleCategorySonByWhere($where);
            //更新所有子分类的文章
            foreach ($article_category_son as $item=>$value){
                $this->article_category_model->article()->where(['cate_uname'=>$value['uname']])->update($status);
            }
        }
        if ($data['status']==0) {
            $status = [
                'status' => 2
            ];
        }
        $where = [
            ['id','=',$data['id']]
        ];
        $result = $this->article_category_model->updateArticleCategoryStatus($where,$status);
        if (!$result){
            throw new Exception('更新失败!',config('status.break'));
        }
        $result_article = $this->article_category_model->article()->where(['cate_uname'=>$data['uname']])->update($status);
        return true;
    }
    public function getArticleCategoryList(){
        $article_category_list = $this->article_category_model->getArticleCategoryList();
        if ($article_category_list==[]){
            throw new Exception('查找不到!',config('status.break'));
        }
        return $article_category_list;
    }


}















