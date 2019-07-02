<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 *  XML 转 数组
 * @param  [type] $xml [description]
 * @return [type]      [description]
 */
function xml2array($xml){
    if(!$xml) return false;
    libxml_disable_entity_loader(true);
    $array = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array;
}

//生成订单编号
function makeOrdel($head='ASS'){
    return $head.date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}
/**
 * (记录日志)请注意服务器是否开通fopen配置
 * @param type $msg
 * @param type $file_name
 */
function log_result($msg,$name="log") {
    if(is_array($msg)){
        $msg=json_encode($msg);
    }
    //$fp = fopen(RUNTIME_PATH . "Logs/" . date('Ymd') . $file_name . ".txt", "a");
    $fp = fopen("./uploads/".$name.".txt", "a");
    flock($fp, LOCK_EX);
    fwrite($fp, "执行时间：" . strftime("%Y-%m-%d %H:%M:%S", time()) . "\r\n" . $msg . "\n\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}
// 获取真实ip
function getRealIp(){
    $ip=false;
    if (isset($_SERVER["HTTP_X_REAL_IP"]) && !empty($_SERVER["HTTP_X_REAL_IP"])) {
        $ip = $_SERVER["HTTP_X_REAL_IP"];
    }elseif (isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) && !empty($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])) {
        $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
    }elseif (isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) && !empty($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])) {
        $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
    }elseif (isset($HTTP_SERVER_VARS["REMOTE_ADDR"]) && !empty($HTTP_SERVER_VARS["REMOTE_ADDR"])) {
        $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
    }elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }elseif (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    }elseif (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

/*
 *  格式化用户输入的金额  防止多个小数
 */
function formatMoney($money){
    return number_format($money,2,'.','')*100;
}

function unFormatMoney($money){
    return number_format($money/100,2,'.','');
}
//格式化时间
function formatTimestamp($time){
    $time =intval($time);
    $t = time() - $time;
    $mon = (int) ($t / (86400 * 30));
    if ($mon >= 1) {
        return $mon.'个月前';
    }
    $day = (int) ($t / 86400);
    if ($day >= 1) {
        return $day . '天前';
    }
    $h = (int) ($t / 3600);
    if ($h >= 1) {
        return $h . '小时前';
    }
    $min = (int) ($t / 60);
    if ($min >= 1) {
        return $min . '分钟前';
    }
    return '刚刚';
}
/**
 * 正则验证
 * @param    [string]                   $type    [类型]
 * @param    [string]                   $string  [字符串]
 * @param    [string]                   $pattern [自定义正则]
 * @return   [bool]                              [true/false]
 */
function regex($type,$string,$pattern=''){
    switch ($type) {
        case 'num'://数字
            $pattern = '/^[0-9]+$/';
            break;
        case 'phone'://手机号码
            $pattern = '/^1[3456789]\d{9}$/';
            break;
        case 'password'://密码可以全数字或全字母 特殊字符~!@#$%^&*.
            $pattern = '/^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,22}$/';
            break;
        case 'username'://用户名
            $pattern = '/^[a-zA-Z0-9_]{3,16}$/';
            break;
        case 'email'://用户名
            $pattern = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
            break;
        case 'chinese'://中文
            $pattern='/^[\x{4e00}-\x{9fa5}]+$/u';
            break;
        case 'id_card'://15或18位身份证
            $re=checkIdCard($string);
            return $re;
            break;
        case 'bank_card'://银行卡16或19位
            $pattern='/^(\d{16}|\d{19})$/';
            break;
        case 'money'://金额  正数2位小数
            $pattern = '/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/';
            break;
        default:
            break;
    }
    // var_dump($pattern,$string);exit;
    if (preg_match($pattern, $string)) {
        return true;
    }else{
        return false;
    }
}

/**
 * 15或18位身份证验证
 * @Author   JYY
 * @DateTime 2017-09-26T11:52:27+0800
 * @param    [type]                   $idcard [身份证号码]
 */
function checkIdCard($idcard){
    if(empty($idcard)){
        return false;
    }
    //长度验证
    if(!preg_match('/^\d{17}(\d|x)$/i',$idcard) and!preg_match('/^\d{15}$/i',$idcard))  {
        return false;
    }
    // 15位身份证验证生日，转换为18位
    if (strlen($idcard)== 15){
        $idcard = substr($idcard,0,6)."19".substr($idcard,6,9);//15to18
        $Bit18 = getVerifyBit($idcard);//算出第18位校验码
        $idcard = $idcard.$Bit18;
    }
    //身份证编码规范验证
    $idcard_base = substr($idcard,0,17);
    if(strtoupper(substr($idcard,17,1)) != getVerifyBit($idcard_base))  {
        return false;
    }
    return true;
}

// 计算身份证校验码，根据国家标准GB 11643-1999
function getVerifyBit($idcard_base){
    if(strlen($idcard_base) != 17)  {
        return false;
    }
    //加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //校验码对应值
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4','3', '2');
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++)  {
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];
    return $verify_number;
}

function createToken($data){
    if(!is_array($data) || !$data) return;
    $data['time'] =time();
    $data['random'] = rand(1000,9999);
    $authcode = urlencode(authcode(serialize($data),'ENCODE',config('api_authcode_key')));
    return $authcode;
}
function checkToken($token){
    if(!$token) return ['code'=>12345678,'msg'=>'没有登录'];
    $token=str_replace('%252', '%2', $token);
    $token_arr = unserialize(authcode(urldecode($token), 'DECODE', config('api_authcode_key')));
    //   ["uid"]=> int(1) ["username"]=> string(11) "17779531233" ["time"]=> int(1517216382) ["random"]=> int(3195)
    if($token_arr){
        return ['code'=>200,'uid'=>$token_arr['uid']];
    }else{
        echo json_encode(['msg'=>'签名错误！','code'=>123456],true);exit;
    }
}
/**   替换手机号码中间4位数
 * @param $phone
 */
function safePhone($phone){
    if(!$phone) return;
    $number = substr($phone,0,3)."****".substr($phone,7,4);
    return $number;
}

/**
 * 对字符进行强加密
 * @param string $str 待加密字符串
 */
function strongmd5($str) {
    return sha1(md5($str).config('user_auth_key'));
}

/**
 * 菜单树
 * @param    array                    $data  [数组]
 * @param    integer                  $pid   [获取栏目id]
 * @param    string                   $html  [前缀]
 * @param    integer                  $level [级别]
 */
function getSort($data,$pid=0,$html="|-----",$level=1,$le=0){
    $temp = array();
    foreach ($data as $k => $v) {
        if($v['pid'] == $pid){
            $str = str_repeat($html, $le);
            $nbsp = str_repeat('|-----', $le);
            $v['html'] = $nbsp.$str;
            $v['level'] = $le;
            $temp[] = $v;
            if($le<$level-1){
                $temp = array_merge($temp,getSort($data,$v['id'],$html,$level,$le+1));
            }
        }
    }
    return $temp;
}

/**
 * @descreption 字符串加密
 * @param $string 需加密的字符
 * @param $operation ENCODE 加密 DECODE 解密
 * @param $key 网站加密key，防止破解
 * @param $expiry 有效期
 * @return string
 */
function authcode($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key ? $key : config('HOME_ENCODE_KEY'));
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * GET 请求
 * @param string $url
 */
function http_get($url){
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        return false;
    }
}

/**
 * POST 请求
 * @param string $url
 * @param array $param
 * @param boolean $post_file 是否文件上传
 * @return string content
 */
function http_post($url,$param,$post_file=false){
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    if (is_string($param) || $post_file) {
        $strPOST = $param;
    } else {
        $aPOST = array();
        foreach($param as $key=>$val){
            $aPOST[] = $key."=".urlencode($val);
        }
        $strPOST =  join("&", $aPOST);
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST,true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        return false;
    }
}

/**
 * 获取文件扩展名
 * @param string $file 文件地址
 */
function get_extension($file) {
    $info = pathinfo($file);
    return $info['extension'];
}
/**
 * 生成随机文件名函数
 */
function randomname($length) {
    $hash = '';
    $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $max = strlen($chars) - 1;
    mt_srand((double) microtime() * 1000000);
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 保存远程图片
 * @param    [string]                   $url      [远程图片路径]
 * @param    [string]                   $save_dir [保存文件夹]
 * @return   [string]                             [保存后的图片路径]
 */
function getImage($url,$save_dir='file'){
    $url=str_replace('https://', 'http://', $url);
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
    $content = curl_exec($ch);
    $img_type=get_extension($url)?get_extension($url):'jpg';
    $save_name=randomname(32).'.'.$img_type;
    $savePath='./uploads/'.$save_dir.'/'.date('Ymd',time()).'/';
    if(!file_exists($savePath)){
        mkdir($savePath,0777,true);
    }
    $re=file_put_contents($savePath.$save_name,$content);
    return trim($savePath.$save_name,'.');
}

/*
截取简介，过滤HTML标签、空格、换行、回车
*/
//字符截取函数
function smalltext_cut($string,$length,$rephtml=0,$dot='...',$pagechar='utf8'){

    //保留转译后的HTML字符
    $rep_str1 = array('&nbsp;','&amp;','&quot;','&lt;','&gt;','&#039;','&ldquo;','&rdquo;','&middot;','&mdash;');
    $rep_str2 = array(' ','&','"','<','>',"'","“","”","·","—");

    if($rephtml==0)
    {
        $string = htmlspecialchars_decode($string);
        $string = strip_tags($string);
        // $string = str_replace($rep_str1 , $rep_str2, $string);
    }
    $string = preg_replace("/\s/", " ", $string);
    $string = preg_replace("/^ +| +$/", '', $string);
    $string = preg_replace("/ {2,}/is", "  ", $string);

    $strlen = strlen($string);
    if($strlen<=$length)
    {
        return $string;
    }

    $strcut = '';
    if($pagechar == 'utf8') {

        $n = $tn = $noc = 0;
        while($n < $strlen) {
            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
            } elseif(224 <= $t && $t < 239) {   // 239 中文逗号 ASCII编码
                $tn = 3; $n += 3; $noc += 2;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
            } else {
                $n++;
            }

            if($noc >= $length) { break; $isdot = 1; }

        }
        if($noc > $length) { $n -= $tn; }
        $strcut = substr($string, 0, $n);
        if ($n < $strlen) {
            $strcut = $strcut.$dot;
        }

    } else {
        for($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }

    if($rephtml==0)
    {
        $string = str_replace($rep_str2, $rep_str1, $string);
    }

    return $strcut;
}

function get_exp_num($oid){
    $info = db('orderGoods')->field('expenses,goods_num')->where('order_id',$oid)->find();
    return $info;
}

function count_time($time,$st,$et,$expenses,$rate,$money,$num){
    $nowTime = time();
    $money = unFormatMoney($money);
    $day = ceil(($nowTime - $time)/(24*60*60));
    $diff = $st - $day;
    $diff1 = $et - $day;
//    $diff2= $day - $et;
    $expense1 = $expenses*$num;
    $expense2 = ($expenses + ($day-$et)*$rate)*$num;
    if($day>0 && $day<=$st){
        return "已租".$day."天还剩".($diff)."天开始计费";
    }else if($day>$st && $day<=$et){
        if($expense1>$money) {
            return "停止计费(租赁期价超于成品价)";
        }else{
            return "已租" . $day . "天还剩" . ($diff1) . "天另外计费";
        }
    }else if($day>$et) {
        if($expense2>$money){
            return "停止计费(租赁期价超于成品价)";
        }else {
            return "已租" . $day . "天（正按百分率计费）";
        }
    }
}

function count_expenses($time,$st,$et,$expenses,$rate,$money,$num){
    $nowTime = time();
    $money = unFormatMoney($money);
    $day = ceil(($nowTime - $time)/(24*60*60));
    $expense = 0;
    $expense1 = $expenses*$num;
    $expense2 = ($expenses + ($day-$et)*$rate)*$num;
    if($day>0 && $day<=$st){
        $real_expense = $expense;
        return $real_expense;
    }else if($day>$st && $day<=$et){
        if($expense1>$money){
            $real_expense = $money;
            return $real_expense;
        }else{
            $real_expense = $expense1;
            return round($real_expense,2);
        }
    }else if($day>$et){
        if($expense2>$money){
            $real_expense = $money;
            return $real_expense;
        }else {
            $real_expense = $expense2;
            return round($real_expense,2);
        }
    }
}

function Retreat_expenses($time,$st,$et,$expenses,$rate,$money,$num){
    $nowTime = time();
    $day = ceil(($nowTime - $time)/(24*60*60));
    $money = unFormatMoney($money);
    $expense = 0;
    $expense1 = $expenses*$num;
    $expense2 = ($expenses + ($day-$et)*$rate)*$num;
    if($day>0 && $day<=$st){
        $real_expense = $expense;
        $rt_expenses = $money - $real_expense;
        return $rt_expenses;
    }else if($day>$st && $day<=$et){
        if($expense1>$money){
            return 0;
        }else{
            $real_expense = $expense1;
            $rt_expenses = $money - $real_expense;
            return round($rt_expenses,2);
        }
    }else if($day>$et){
        if($expense2>$money){
            return 0;
        }else {
            $real_expense = $expense2;
            $rt_expenses = $money - $real_expense;
            return round($rt_expenses,2);
        }
    }
}

function count_day($starttime)
{
    $endtime = time();
    $timediff = $endtime-$starttime;
    $days = intval($timediff/86400);
    if ($days<=21){
        return 1;
    }else{
        return 0;
    }
}

/**
 * 删除文件夹下所有文件
 * @Author   JYY
 * @DateTime 2017-07-06T16:11:58+0800
 * @param    [type]                   $dir [文件夹位置]
 */
function deleteDir($dir){
    $handle = opendir($dir);
    while (($item = readdir($handle)) !== false) {
        if ($item != '.' and $item != '..') {
            if (is_dir($dir . '/' . $item)) {
                deleteDir($dir . '/' . $item);
            } else {
                if (!unlink($dir . '/' . $item))
                    die('error!');
            }
        }
    }
    closedir($handle);
    return rmdir($dir);
}

//小图变大图
function thumb_to_big($string){
    $start=strpos($string,'_thumb');
    $string=substr_replace($string,'',$start,6);
    return $string;
}


//base图片转换为图片路径
function base64_to_img($img,$path='uploads/user/head/'){
    $path.=date(Ymd).'/';
    if(!is_dir($path)){
        $res=mkdir($path,0777,true); 
        if(!$res){
            return false;
        }
    }
    $url=explode(',', $img);
    $img_type=explode('/', $url[0]);
    $img_type=substr($img_type[1],0,strpos($img_type[1],';'));

    $img_name=randomname(12).'.'.$img_type;
    file_put_contents('./'.$path.$img_name, base64_decode($url[1]));
    return '/'.$path.$img_name; 
}
/***
 *  Author : Insist
 * @param 传入需要格式化的时间戳
 * @return 返回判断后的大概日期
 */
function mdate($time =null){
    $text = '';
    $time = $time === null || $time > time()? time():intval($time);
    $t=time()- $time;       //时间差(秒)
    $y = date('Y',$time) -date('Y',time());         //  是否跨年
    switch ($t){
        case $t ==10:
            $text = '刚刚';
            break;
        case $t <60:
            $text = $t.'秒前';
            break;
        case $t < 60 * 60:
            $text = floor($t / 60) . '分钟前'; //一小时内
            break;
        case $t < 60 * 60 * 24:
            $text = floor($t / (60 * 60)) . '小时前'; // 一天内
            break;
        case $t < 60 * 60 * 24 * 3:
            $text = floor($time/(60*60*24)) ==1 ?'昨天 ' . date('H:i', $time) : '前天 ' . date('H:i', $time) ; //昨天和前天
            break;
        case $t < 60 * 60 * 24 * 30:
            $text = date('m月d日', $time); //一个月内
            break;
        case $t < 60 * 60 * 24 * 365&&$y==0:
            $text = date('m月d日', $time); //一年内
            break;
        default:
            $text = date('Y年m月d日', $time); //一年以前
            break;
    }
    return $text;
}

//消息推送
//function message_push($type,$uid,$id){
//    $nickname = db('user')->where('id',$uid)->value('nickname');
//    $tid = db('mom_push')->where('id',$id)->value('uid');
//    $content = db('mom_comment')->where(['uid'=>$uid,'push_id'=>$id])->value('content');
//    $data1['to_uid'] = $tid;
//    $data1['push_id'] = $id;
//    $data1['content'] = $nickname.'赞了你的发布';
//    $data1['type'] = 1;
//    $data1['create_time'] = mdate(time());
//    $data1['uid'] = $this->uid;
//    if($type == 1){
//        $data1['content'] = $nickname.'赞了你的发布';
//    }elseif($type == 2){
//        $data1['content'] = $nickname.'转发了你的发布';
//    }else{
//        $data1['content'] = $content;
//    }
//    db('message')->insert($data1);
//}
 function insertAction($order_id,$desc,$note,$user_id=0)
 {
     $orderAction['order_id']=$order_id;
     $orderAction['action_user']=$user_id;
     $orderAction['log_time']=time();
     $orderAction['status_desc']=$desc;
     $orderAction['action_note']=$note;
     db('orderAction')->insert($orderAction);
 }