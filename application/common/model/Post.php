<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/15
 * Time: 14:09
 */
namespace app\common\model;
use think\Db;
use think\Model;
/**
 * 活动管理
 */
class Post extends Model{
    /**
     * 添加内容
     * @Author   jiayangyang
     * @DateTime 2017-03-29T16:15:18+0800
     */
    public function addPost(){
        $data['title']=input('title');
        $data['detail']=input('detail','','htmlspecialchars');
        $data['detail']=preg_replace('/alt=&quot;.+?&quot;/','alt=&quot;'.$data['title'].'&quot;',$data['detail']);
        $data['detail']=preg_replace('/title=&quot;.+?&quot;/','title=&quot;'.$data['title'].'&quot;',$data['detail']);
        $data['thumb_img']=input('thumb_img');
        $data['url']=input('url');
        $data['type']=input('type',1);
        $data['category_id']=input('category_id');
        $data['keywords']=input('keywords');
        $data['description']=input('description')?input('description'):smalltext_cut($data['detail'],220,0,'');
        $data['status']=input('status');
        $data['create_time']=time();
        $data['sort']=input('sort',0);
        // var_dump($data);exit;
        $re=db('post')->insert($data);
        return $re;
    }

    public function editPost(){
        $id=input('id');
        $data['title']=input('title');
        $data['detail']=input('detail','','htmlspecialchars');
        $data['detail']=preg_replace('/alt=&quot;.+?&quot;/','alt=&quot;'.$data['title'].'&quot;',$data['detail']);
        $data['detail']=preg_replace('/title=&quot;.+?&quot;/','title=&quot;'.$data['title'].'&quot;',$data['detail']);
        $data['thumb_img']=input('thumb_img');
        $data['url']=input('url');
        $data['type']=input('type',1);
        $data['category_id']=input('category_id');
        $data['keywords']=input('keywords');
        $data['description']=input('description')?input('description'):smalltext_cut($data['detail'],220,0,'');
        $data['status']=input('status');
        $data['sort']=input('sort',0);
        $re=db('post')->where('id',$id)->update($data);
        return $re;
    }

    /**
     * 内容详情
     * @Author   jiayangyang
     * @DateTime 2017-03-29T16:10:21+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function postInfo($id){
        $info=db('post')->field('p.*,c.name')->alias('p')->join('__CATEGORY__ c','p.category_id= c.id')->where('p.id',$id)->find();
        if($info){
            return $info;
        }else{
            return false;
        }
    }




    /**
     * 首页获取推荐或最新文章
     * @Author   jiayangyang
     * @DateTime 2017-04-13T12:07:56+0800
     * @param    [type]                   $map   [description]
     * @param    string                   $limit [description]
     * @param    string                   $order [description]
     * @return   [type]                          [description]
     */
    public function recommend($map,$limit="10",$order="create_time desc"){
        $field="p.id,p.title,p.category_id,p.create_time,c.name";
        $map['p.status']=1;
        $list =db('post')->field($field)->alias('p')->join('__CATEGORY__ c','p.category_id= c.id')->where($map)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
     * 某一级栏目下文章
     * @param  [int] $cate_id [栏目id]
     */
    public function getCateActicle($cate_id,$limit='10',$order="create_time desc,view desc"){
        $list=cache('getCateActicle_'.$cate_id);
        if($list){
            return $list;
        }else{
            $ids=model('category')->getSubIds($cate_id);
            $map['category_id']=array('in',$ids);
            $field="p.id,p.title,p.create_time,p.thumb_img,p.view,p.category_id,c.name";
            $map['p.status']=1;
            $list = db('post')->field($field)->alias('p')->join('__CATEGORY__ c','p.category_id= c.id')->where($map)->order($order)->limit($limit)->select();
            cache('getCateActicle_'.$cate_id,$list,3600);
            return $list;
        }

    }
    /**
     * 相关文章
     * @Author   jiayangyang
     * @DateTime 2017-04-13T12:10:06+0800
     * @return   [type]                   [description]
     */
    public function likeActicle($tag){
        if(is_array($tag)){
            $tag_array=array();
            foreach ($tag as $k => $v) {
                $tag_array[]=$v['id'];
            }
            $re=db('post_tag')->field('p.id,p.title')->alias('pt')->join('__POST__ p','pt.pid= p.id')->where(['tid'=>['in',$tag_array]])->group('pid')->where(['p.status'=>1])->limit(10)->select();
        }else{
            $re=db('post')->field('p.id,p.title')->where(['status'=>1])->limit(10)->select();
        }
        return $re;
    }
}