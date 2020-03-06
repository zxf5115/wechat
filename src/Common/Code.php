<?php
namespace zxf5115\Wechat\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-08
 *
 * 错误类
 */
class Code
{
  // 基础
  const SUCCESS = 200;   # 成功
  const ERROR   = 10001; # 错误
  const FAILURE = 10002; # 失败
  const EMPTY   = 10003; # 空



  // 自定义微信
  const WX_SESSION_ERROR = 40001;








  // 微信自身
  const ILLEGAL_AES_KEY     = -41001;
  const ILLEGAL_IV          = -41002;
  const ILLEGAL_BUFFER      = -41003;
  const DECODE_BASE64_ERROR = -41004;




  public static $message = [
    self::SUCCESS => '成功',
    self::ERROR   => '错误',
    self::FAILURE => '失败',
    self::EMPTY   => '空',


    self::WX_SESSION_KEY_ERROR = '获取session_key失败',
  ];

}

/**
 * error code 说明.
 * <ul>
 *    <li>-41001: encodingAesKey 非法</li>
 *    <li>-41003: aes 解密失败</li>
 *    <li>-41004: 解密后得到的buffer非法</li>
 *    <li>-41005: base64加密失败</li>
 *    <li>-41016: base64解密失败</li>
 * </ul>
 */

