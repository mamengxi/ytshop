<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/2/5
 * Time: 15:38
 */

namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;
use think\Db;
/**
 * 后台首页及公共
 */
class Chart extends Admin
{
    /**
     * 后台登录首页
     */
    public function index()
    {
        //今日订单
        $num['today_num'] = Db::name('orders')->whereTime('pay_time', 'today')->where('order_status','in','5,7')->count();
        $num['yestoday_num'] = Db::name('orders')->whereTime('pay_time', 'yestoday')->where('order_status','in','5,7')->count();
        $num['day_diff_num'] = $num['today_num'] - $num['yestoday_num'];
        $num['day_type'] = $num['day_diff_num'] > 0 ? 1 : ($num['day_diff_num'] = 0 ? 2 : 3);
        $num['day_diff_num'] = abs($num['day_diff_num']);
//        var_dump($num['today_num']);exit;

        //本月订单
        $num['month_num'] = Db::name('orders')->whereTime('pay_time', 'month')->where('order_status','in','5,7')->count();
        $num['month_num_fail'] = Db::name('orders')->whereTime('pay_time', 'month')->where('order_status',['neq',5],['neq',7],'or')->count();

        $num['lastmonth_num'] = Db::name('orders')->whereTime('pay_time', 'last month')->where('order_status','in','5,7')->count();
        $num['lastmonth_num_fail'] = Db::name('orders')->whereTime('pay_time', 'lastmonth')->where('order_status',['neq',5],['neq',7],'or')->count();
        $num['month_diff_num'] = $num['month_num'] - $num['lastmonth_num'];
        $num['month_type'] = $num['month_diff_num'] > 0 ? 1 : ($num['month_diff_num'] = 0 ? 2 : 3);
        $num['month_diff_num'] = abs($num['month_diff_num']);
//        var_dump($num['month_diff_num']);exit;
        //本年订单
        $num['year_num'] = Db::name('orders')->whereTime('pay_time', 'year')->where('order_status','in','5,7')->count();
        $num['lastyear_num'] = Db::name('orders')->whereTime('pay_time', 'last year')->where('order_status','in','5,7')->count();
        $num['year_diff_num'] = $num['year_num'] - $num['lastyear_num'];
        $num['year_type'] = $num['year_diff_num'] > 0 ? 1 : ($num['year_diff_num'] = 0 ? 2 : 3);
        $num['year_diff_num'] = abs($num['year_diff_num']);
        //总订单
        $num['total_num'] = Db::name('orders')->where('order_status','in','5,7')->count();

        //本月总订单量
        $m_month = db('orders')->field("FROM_UNIXTIME(pay_time,'%c') as mon,count(*) as num")->group('mon')->whereTime('pay_time', 'year')->select();
//        foreach($m_month as $k=>$v){
//            var_dump(date('Y-m-d',$v['pay_time']));
//        }
//        print_r($m_month);exit;
        $num['m_num'] = array();
        for ($i = 1; $i < 13; $i++) {
//            $num['m_num'][$i]=$i;
            foreach ($m_month as $v){
                if($v['mon']==$i){
                    $num['m_num'][$i]= $v['num'];
                    break;
                }else{
                    $num['m_num'][$i]= '';
                }
            }
        }
//        print_r($num['m_num']);
//        exit;
//        var_dump($m_month);exit;
        //本月成交订单量
        $ms_month = db('orders')->field("FROM_UNIXTIME(pay_time,'%c') as mon,count(*) as num")->group('mon')->where('order_status','in','5,7')->whereTime('pay_time', 'year')->select();
        $num['ms_num'] = array();
        for ($i = 1; $i < 13; $i++) {
            foreach ($ms_month as $v) {
                if ($v['mon'] == $i) {
                    $num['ms_num'][$i] = $v['num'];
                    break;
                } else {
                    $num['ms_num'][$i] = 0;
                }
            }
        }

//        var_dump($num['ms_num']);exit;
        //本月未成交订单量
        $mf_month = db('orders')->field("FROM_UNIXTIME(pay_time,'%c') as mon,count(*) as num")->group('mon')->where('order_status',['neq',5],['neq',7],'and')->whereTime('pay_time', 'year')->select();
        $num['mf_num'] = array();
        for ($i = 1; $i < 13; $i++) {
            foreach ($mf_month as $v) {
                if ($v['mon'] == $i) {
                    $num['mf_num'][$i] = $v['num'];
                    break;
                } else {
                    $num['mf_num'][$i] = 0;
                }
            }
        }
//        var_dump($num['mf_num']);exit;
        $r_num = Db::name('user')->field("FROM_UNIXTIME(create_time,'%c') as month,count(*) as num")->group('month')->whereTime('create_time', 'year')->select();
        $num['r_num'] = array();
//        print_r($r_num);exit;
        for ($i = 1; $i < 13; $i++) {
            foreach ($r_num as $v) {
                if ($v['month'] == $i) {
                    $num['r_num'][$i] = $v['num'];
                    break;
                } else {
                    $num['r_num'][$i] = 0;
                }
            }
        }

//        var_dump($num['c_rate']);exit;
        //男女比例
        $boy_num = Db::name('user')->field("FROM_UNIXTIME(create_time,'%c') as month,count(*) as num")->group('month')->where(['sex' => 1])->whereTime('create_time', 'year')->select();
        $num['boy_num'] = array();
        for ($i = 1; $i < 13; $i++) {
            foreach ($boy_num as $v) {
                if ($v['month'] == $i) {
                    $num['boy_num'][$i] = $v['num'];
                    break;
                } else {
                    $num['boy_num'][$i] = 0;
                }
            }
        }

        $girl_num = Db::name('user')->field("FROM_UNIXTIME(create_time,'%c') as month,count(*) as num")->group('month')->where(['sex' => 2])->whereTime('create_time', 'year')->select();
        $num['girl_num'] = array();
        for ($i = 1; $i < 13; $i++) {
            foreach ($girl_num as $v) {
                if ($v['month'] == $i) {
                    $num['girl_num'][$i] = $v['num'];
                    break;
                } else {
                    $num['girl_num'][$i] = 0;
                }
            }
        }


        $year_max = db('orders')->max("FROM_UNIXTIME(pay_time,'%Y')");
        $year = array();
        for($i = 5;$i > 0;$i--){
            $year[] = $year_max--;
        }
        $year = array_reverse($year);
        $ymax = max($year);
        $ymin = min($year);
        $year_data = db('orders')->field("FROM_UNIXTIME(pay_time,'%Y') as years,count(*) as num")->group('years')->where('order_status','in','5,7')->select();

        $num['year_data'] = array();
        for ($i = $ymin; $i < ($ymax+1); $i++) {
            foreach ($year_data as $v){
                if($v['years'] == $i){
                    $num['year_data'][$i] = $v['num'];
                    break;
                }else{
                    $num['year_data'][$i] = 0;
                }
            }
//            var_dump($num['year_data']);
        }
//        print_r($num['year_data']);
//        exit;

//        var_dump($num['year_data']);exit;
        $order = [];
        $order['m_num'] = implode(",", $num['m_num']);
        $order['ms_num'] = implode(",", $num['ms_num']);
        $order['mf_num'] = implode(",", $num['mf_num']);

        $user = [];
        $user['r_num'] = implode(",", $num['r_num']);
//        $user['c_rate'] = implode(",", $num['c_rate']);
        $user['boy_num'] = implode(",", $num['boy_num']);
        $user['girl_num'] = implode(",", $num['girl_num']);

        $count = [];
        $count['today_num'] = $num['today_num'];
        $count['day_type'] = $num['day_type'];
        $count['day_diff_num'] = $num['day_diff_num'];
        $count['month_num'] = $num['month_num'];
        $count['month_type'] = $num['month_type'];
        $count['month_diff_num'] = $num['month_diff_num'];
        $count['year_num'] = $num['year_num'];
        $count['year_type'] = $num['year_type'];
        $count['year_diff_num'] = $num['year_diff_num'];
        $count['total_num'] = $num['total_num'];

        $year1 = [];
        $year1 = implode(",",$year);
        $data = [];
        $data = implode(",",$num['year_data']);
//        var_dump($num['year_data']);exit;

//        var_dump($order);exit;
        //订单
        $this->assign('order', $order);
        //会员数据
        $this->assign('user', $user);
        //对比数据
        $this->assign('count', $count);
        //近几年
        $this->assign('year1', $year1);
        //近几年订单数据
        $this->assign('data', $data);
        return view();
    }
}
