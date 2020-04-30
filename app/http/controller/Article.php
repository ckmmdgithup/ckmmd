<?php

namespace app\http\controller;


use app\common\model\mysql\Article as ArticleModel;
use app\http\business\Article as ArticleBusiness;
use think\App;
use think\Exception;
use think\facade\Cache;
use think\facade\View;
use think\Request;

class Article extends HttpBaseController
{
    protected $article_model;
    protected $article_business;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->article_business = new ArticleBusiness();
        $this->article_model = new ArticleModel();
    }

    public function index(Request $request){
        //如果有分类,复写 $this->article_list
        $cate = $request->param('cate','','trim');
        //halt($cate);
        if ($cate<>''){
            try {
                $article_model = new ArticleModel();
                $this->article_list = $article_model->getMoreArticleByCate($cate);
                View::assign([
                    'article_list'=>$this->article_list,
                    'article_cate'=>$cate
                ]);
                return View::fetch();
            }catch (Exception $exception){
                return $exception->getMessage();
            }
        }
        return View::fetch();

    }
    public function moreArticle(Request $request){
        $data = $request->param();
        //halt($data);exit();
        if (!is_array($data) || $data['page']==null){
            return config('status.error');
        }
        try {
            $more_article = $this->article_model->getMoreArticle($data['page'],$data['cate']);
            if ($more_article){
                $view = view('more_article',[
                    'more_article'=>$more_article,
                ]);
                return $view;
            }
        }catch (Exception $exception){
            return config('status.error');
        }
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Exception
     * @function  detailed  文章详情
     */
    public function detailed(Request $request){
        if (!$request->isGet()){
            abort(404);
        }
        $article_url = $request->baseUrl();
        $ip = $request->ip();
        if (empty($article_url)||empty($ip)) abort(404,'页面异常!!');
        $article_cache = Cache::get($article_url.$ip);
        if ($article_cache){
            View::assign([
                'article'=>$article_cache['article'],
                'article_prev'=>$article_cache['article_prev'],
                'article_next'=>$article_cache['article_next'],
            ]);
            return View::fetch();
        };
        try {
            $article_arr = $this->article_business->getArticleDetailed($article_url);
            //halt($article_arr);exit();
            if ($article_arr){
                //点击数量更新++
                $article_arr['article']->read_num++;
                $data = [
                    'id' => $article_arr['article']->id,
                    'read_num'=>$article_arr['article']->read_num
                ];
                $this->article_model->updateArticle($data);
                View::assign([
                    'article'=>$article_arr['article'],
                    'article_prev'=>$article_arr['article_prev'],
                    'article_next'=>$article_arr['article_next'],
                ]);
                //设置缓存 url与访问ip 拼接生成唯一缓存
                Cache::set($article_url.$ip, $article_arr, 100);
                return View::fetch();
            }
        }catch (Exception $exception){
            abort(404,'页面异常!!!');
        }
    }
}




