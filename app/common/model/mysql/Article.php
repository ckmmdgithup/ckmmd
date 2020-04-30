<?php
namespace app\common\model\mysql;

use think\Model;

class Article extends Model
{
    protected $table = 'article';

    public function category(){
        return $this->belongsTo(ArticleCategory::class,'cate_uname','uname');
    }

    public function saveArticle($data){
        if (empty($data) || !is_array($data)) return false;

        return $this->save($data);
    }

    public function updateArticle($data){
        if (empty($data) || !is_array($data)) return false;

        $where = [
            'id' => $data['id'],


        ];
        return $this->where($where)->update($data);
    }
    public function getArticleList(){
        $where = [
            ['status','<>', config('status.mysql.disable')],
        ];
        $order = [
            'update_time'=>'desc',
        ];
        return $this->where($where)->order($order)->paginate(config('app.page_num'));
    }

    public function getAllArticleList(){
        $where = [
            ['status','<>', config('status.mysql.disable')],
        ];
        $order = [
            'update_time'=>'desc',
        ];
        return $this->where($where)->order($order)->select();
    }

    public function getMoreArticleByCate($cate,$page = 1){
        $where = [
            ['status','=', config('status.mysql.normal')],
            ['cate_uname','=',$cate]
        ];
        $order = [
            'update_time'=>'desc',
        ];
        return $this->where($where)->order($order)->page($page,config('app.page_num'))->select();
    }
    public function getMoreArticle($page = 1,$cate = ''){
        if ($cate == ''){
            $where = [
                ['status','=', config('status.mysql.normal')],
            ];
        }else{
            $where = [
                ['status','=', config('status.mysql.normal')],
                ['cate_uname','=',$cate]
            ];
        }
        $order = [
            'update_time'=>'desc',
        ];
        return $this->where($where)->order($order)->page($page,config('app.page_num'))->select();
    }


    public function getArticleListOrderByRead(){
        $where = [
            ['status','<>', config('status.mysql.disable')],
        ];
        $order = [
            'read_num'=>'desc',
        ];
        return $this->where($where)->order($order)->page(1,config('app.page_num'))->select();
    }
    public function getHotArticleList(){
        $where = [
            ['status','<>', config('status.mysql.disable')],
            ['is_hot','=',config('status.mysql.normal')]
        ];
        $order = [
            'update_time'=>'desc',
        ];
        return $this->where($where)->order($order)->page(1,config('app.page_num'))->select();
    }
    public function getArticleByTitle($title){
        if (empty($title)) return false;

        $where = [
            ['title','=',$title],
            ['status','<>', config('status.mysql.disable')],
        ];
        return $this->where($where)->find();
    }
    public function getArticleById($id){
        if (empty($id)) return false;

        $where = [
            'id' => $id,
        ];
        return $this->where($where)->find();
    }
    public function getArticleByCate($uname){
        if (empty($uname)) return false;
        $where = [
            ['cate_uname' ,'=', $uname,],
            ['status','<>',config('status.mysql.disable')]
        ];
        $order = [
            'update_time'=>'desc',
            'status'=>'desc'
        ];
        return $this->where($where)->order($order)->paginate(config('app.page_num'));

    }
    public function getArticleBySreach($where){
        if (empty($where)) return false;
        $order = [
            'update_time'=>'desc',

            'status'=>'desc'

        ];
        return $this->where($where)->order($order)->select();

    }

    public function getArticleByUrl($url){
        if (empty($url)) return false;

        $where = [
            'url' => $url,
            'status' => config('status.mysql.normal'),
        ];
        return $this->where($where)->find();
    }
    public function getArticlePrevByTime($time){
        if (empty($time)) return false;

        $where = [
            ['update_time','>', strtotime($time)],
            ['status','=',config('status.mysql.normal')]

        ];
        $order = [
            'update_time'=>'asc',
        ];
        return $this->where($where)->order($order)->find();


    }
    public function getArticleNextByTime($time){

        if (empty($time)) return false;
        $where = [
            ['update_time','<', strtotime($time)],
            ['status','=',config('status.mysql.normal')]
        ];
        $order = [
            'update_time'=>'desc',
        ];
        return $this->where($where)->order($order)->find();


    }

}