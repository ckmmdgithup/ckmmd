<?php
namespace app\common\model\mysql;


use think\Model;

class Carousel extends Model
{
    protected $table = 'carousel';

    public function saveCarousel($data){
        if (empty($data) || !is_array($data)) return false;

        return $this->save($data);
    }
    public function getCarousel(){
        $order = [
            'sort'=>'desc',
        ];
        return $this->order($order)->paginate(config('app.page_num'));

    }
    public function delCarouselById($id){
        $where = [
            'id'=>$id
        ];

        return $this->where($where)->delete();
    }
    public function sortCarouselById($id,$sort){
        $where = [
            'id'=>$id
        ];
        $sort = [
            'sort'=>$sort
        ];

        return $this->where($where)->update($sort);
    }



}
