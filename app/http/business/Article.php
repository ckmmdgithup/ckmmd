<?php

namespace app\http\business;

use think\Exception;
use app\common\model\mysql\Article as ArticleModel;


class Article
{
    protected $article_model;

    public function __construct()
    {
        $this->article_model = new ArticleModel();
    }
    public function getArticleDetailed($url){
        $article = $this->article_model->getArticleByUrl($url);
        if(!$article){
            throw new Exception('查找失败!',config('status.break'));
        }
        $article_prev = $this->article_model->getArticlePrevByTime($article->update_time);
        if (!$article_prev){
            $article_prev = null;
        }
        $article_next = $this->article_model->getArticleNextByTime($article->update_time);
        if (!$article_next){
            $article_next = null;
        }
        $data = [
            'article'=>$article,
            'article_prev'=>$article_prev,
            'article_next'=>$article_next,
        ];

        return $data;



    }

}