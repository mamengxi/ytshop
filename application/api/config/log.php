<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/24 16:04
 */

return [
    // 日志记录方式，支持 file socket 或者自定义驱动类
    'type' => 'File',
    //日志保存目录
    'path' => '',
    //单个日志文件的大小限制，超过后会自动记录到第二个文件
    'file_size'     =>2097152,
    // 日志记录级别
    'apart_level' => ['error','sql','info'],
];