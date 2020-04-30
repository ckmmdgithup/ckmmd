<?php
namespace app\http\controller;

use app\BaseController;
use think\App;
use think\Exception;
use think\facade\View;
use app\common\model\mysql\Carousel as CarouselModel;
use app\common\model\mysql\Setting as WebSetting;
use app\common\model\mysql\AboutCk as AboutCk;
use app\common\model\mysql\ArticleCategory as ArticleCategoryModel;
use app\common\model\mysql\Article as ArticleModel;

class HttpBaseController extends BaseController
{
    protected $carousel;
    protected $web_info;
    protected $ck_info;
    protected $article_list;
    protected $article_hot_list;
    protected $article_list_read_order;
    protected $article_category_list;
    protected $article_category_list_by_pid;


    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->carousel = $this->getCarousel();
        $this->web_info = $this->getWebInfo();
        $this->ck_info = $this->getCkInfo();
        $this->article_list = $this->getMoreArticle();
        $this->article_hot_list = $this->getHotArticleList();
        $this->article_list_read_order = $this->getArticleListOrderByRead();
        $this->article_category_list = $this->getArticleCategoryList();
        $this->article_category_list_by_pid = $this->getArticleCategoryListByPid(0);
        View::assign([
            'article_cate'=>'',
            'carousel'=>$this->carousel,
            'ck_info'=>$this->ck_info,
            'web_info'=>$this->web_info,
            'article_list'=>$this->article_list,
            'article_list_read_order'=>$this->article_list_read_order,
            'article_hot_list'=>$this->article_hot_list,
            'article_category_list'=>$this->article_category_list,
            'article_category_list_by_pid'=>$this->article_category_list_by_pid
        ]);
    }
    public function getCarousel(){
        try {
            $carousel_model = new CarouselModel();
            return $carousel_model->getCarousel();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
    public function getWebInfo(){
        try {
            $web_setting_model = new WebSetting();
            return $web_setting_model->getWebInformation();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
    public function getCkInfo(){
        try {
            $ck_model = new AboutCk();
            return $ck_model->getCkInformation();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
    public function getMoreArticle(){
        try {
            $article_model = new ArticleModel();
            return $article_model->getMoreArticle();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
    public function getArticleListOrderByRead(){
        try {
            $article_model = new ArticleModel();
            return $article_model->getArticleListOrderByRead();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
    public function getHotArticleList(){
        try {
            $article_model = new ArticleModel();
            return $article_model->getHotArticleList();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
    public function getArticleCategoryList(){
        try {
            $article_category_model = new ArticleCategoryModel();
            return $article_category_model->getArticleCategoryList();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
    public function getArticleCategoryListByPid($pid){
        try {
            $article_category_model = new ArticleCategoryModel();
            return $article_category_model->getArticleCategoryByPid($pid);
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }


}
