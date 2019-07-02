<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/16
 * Time: 11:36
 */
namespace app\common\validate;
use think\Validate;
class User extends Validate
{

    protected $rule=[
        'phone' =>'require|unique:user|max:11',
        'id_card' =>'require|unique:user',
        'email' =>'require|unique:user',

    ];
    protected $message=[
        'phone.require' =>'手机号码不能为空',
        'phone.unique' =>'手机号已被使用',
        'phone.max' =>'手机号码必须11位',
        'id_card.require' =>'身份证号不能为空',
        'id_card.unique' =>'身份证号已被使用',
        'email.require' =>'邮箱不能为空',
        'email.unique' =>'该邮箱已被使用'
    ];

    protected $scene =[
        'quickreister'=>['phone'],
    ];
}