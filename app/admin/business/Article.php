<?php

namespace app\admin\business;

use think\Exception;
use app\common\model\mysql\Article as ArticleModel;

/**
 * Class Article
 * @package app\admin\busis
 *
 *
 */
class Article
{
    protected $article_model;

    public function __construct()
    {
        $this->article_model = new ArticleModel();
    }

    public function add($data){
        $article_by_name = $this->article_model->getArticleByTitle($data['title']);
        if ($article_by_name){
            throw new Exception('文章标题已经使用过',config('status.break'));
        }
        $save_data = [
            'title'=>$data['title'],
            'cate_uname'=>$data['cate_uname'],
            'author'=>($data['author']),
            'url'=>'/http/article/detailed/'.get_url().'.html',
            'thumbnail'=>$data['thumbnail'],
            'is_carousel'=>isset($data['is_carousel'])?1:0,
            'is_hot'=>isset($data['is_hot'])?1:0,
            'keywords'=>htmlspecialchars($data['keywords']),
            'description'=>htmlspecialchars($data['description']),
            'content'=>remove_xss($data['content']),
            'create_time'=>time(),
            'update_time'=>time(),
            'status'=>1
        ];
        $result = $this->article_model->saveArticle($save_data);
        if (!$result){
            throw new Exception('添加失败!',config('status.break'));
        }
        return true;
    }
    public function update($data){
        $article = $this->article_model->getArticleById($data['id']);
        $article_by_name = $this->article_model->getArticleByTitle($data['title']);

        if ($article_by_name && $article['title']!=$data['title']){
            throw new Exception('文章标题已经使用过',config('status.break'));
        }
        $up_data = [
            'id'=>$data['id'],
            'title'=>$data['title'],
            'cate_uname'=>$data['cate_uname'],
            'author'=>($data['author']),
            'thumbnail'=>$data['thumbnail'],
            'is_carousel'=>empty($data['is_carousel'])?0:1,
            'is_hot'=>empty($data['is_hot'])?0:1,
            'keywords'=>htmlspecialchars($data['keywords']),
            'description'=>htmlspecialchars($data['description']),
            'content'=>remove_xss($data['content']),
            'update_time'=>time(),
        ];
        $result = $this->article_model->updateArticle($up_data);
        if (!$result){
            throw new Exception('添加失败!',config('status.break'));
        }
        return true;
    }
    public function sreach($data){
            if ($data['title']==''){
                $where = [
                    ['create_time','between',[
                        ($data['start']=='') ? '1500000000':strtotime($data['start']),
                        ($data['end']=='') ? time():strtotime($data['end']),
                    ]],
                    ['status','<>',config('status.mysql.disable')]
                ];

            }else{
                $where = [
                    ['create_time','between',[
                        ($data['start']=='') ? '1500000000':strtotime($data['start']),
                        ($data['end']=='') ? time():strtotime($data['end']),
                    ]],
                    ['title','like','%'.$data['title'].'%'],
                    ['status','<>',config('status.mysql.disable')]
                ];
            }
            //return $where;
            return $this->article_model->getArticleBySreach($where);
        
    }
    public function articleStatusUpdate($data){

        $status = [
            'status'=>$data['status']
        ];
        $where = [
            ['id','=',$data['id']]
        ];
        $result = $this->article_model->where($where)
                                    ->update($status);
        if (!$result){
            throw new Exception('更新失败!',config('status.break'));
        }
        return true;
    }

    public function articleHotUpdate($data){

        $status = [
            'is_hot'=>$data['is_hot']
        ];
        $where = [
            ['id','=',$data['id']]
        ];
        $result = $this->article_model->where($where)
            ->update($status);
        if (!$result){
            throw new Exception('更新失败!',config('status.break'));
        }
        return true;
    }
    public function articleCarouselUpdate($data){

        $status = [
            'is_carousel'=>$data['is_carousel']
        ];
        $where = [
            ['id','=',$data['id']]
        ];
        $result = $this->article_model->where($where)
            ->update($status);
        if (!$result){
            throw new Exception('更新失败!',config('status.break'));
        }
        return true;
    }
    public function getArticleByUname($uname = null){
        if ($uname == ''){
            $article_list = $this->article_model->getArticleList();
        }else{
            $article_list = $this->article_model->getArticleByCate($uname);
        }
        return $article_list;
    }
    public function getArticleById($id){
        $article_by_id = $this->article_model->getArticleById($id);
        if ($article_by_id == []){
            throw new Exception('查找不到!',config('status.break'));
        }
        return $article_by_id;
    }
}