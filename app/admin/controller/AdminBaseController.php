<?php
namespace app\admin\controller;

use app\BaseController;
use think\App;
use think\Exception;
use think\facade\Session;
use think\facade\View;
use app\admin\business\ArticleCategory as ArticleCategoryBusiness;
use app\common\model\mysql\ArticleCategory as ArticleCategoryModel;



class AdminBaseController extends BaseController
{
    protected $article_category_list;
    protected $article_category_list_by_pid;
    protected $user_info;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->user_info = Session::get(config('admin.admin_session'));
        $this->article_category_list = $this->getArticleCategoryList();
        $this->article_category_list_by_pid = $this->getArticleCategoryListByPid(0);

        View::assign([
            'user_info'=>$this->user_info,
            'article_category_list'=>$this->article_category_list,
            'article_category_list_by_pid'=>$this->article_category_list_by_pid
        ]);
    }
    public function getArticleCategoryList(){
        try {
            $article_category_model = new ArticleCategoryModel();
            return $article_category_model->getArticleCategoryList();
        }catch (Exception $exception){
            throw new Exception('查找不到!',config('status.break'));
        }
    }
    public function getArticleCategoryListByPid($pid){
        try {
            $article_category_model = new ArticleCategoryModel();
            return $article_category_model->getArticleCategoryByPid($pid);
        }catch (Exception $exception){
            throw new Exception('查找不到!',config('status.break'));
        }
    }


}
