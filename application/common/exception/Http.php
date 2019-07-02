<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/24 12:04
 */
namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\exception\ValidateException;

class Http extends Handle
{
    public function render(Exception $e)
    {
        // 参数验证错误
        if ($e instanceof ValidateException) {
            return json($e->getError(), 422);
        }
        return parent::render($e);
    }
}