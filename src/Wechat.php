<?php
namespace zxf5115\Wechat;

use zxf5115\Wechat\Common\Code;
use zxf5115\Wechat\Common\WXBizDataCrypt;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 核心类
 */
class Wechat extends Common
{
  private $appId;
  private $secret;
  private $code2sessionUrl;
  private $sessionKey;


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-07
   *
   * 初始化对象
   *
   * @param  array  $config [请求参数]
   */
  public function __construct($config = [])
  {
    $this->code2sessionUrl = config('wechat.common.code2sessionUrl', '');

    $this->appId  = $config ? $config['appId'] : config('wechat.default.appId', '');
    $this->secret = $config ? $config['secret'] : config('wechat.default.secret', '');
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-07
   *
   * 获取登录信息
   *
   * @param    string     $code 登录请求
   * @return   登录信息
   */
  public function getLoginInfo($code)
  {
    return $this->getCode2Session($code);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-03-06
   * ------------------------------------------
   * 获取用户信息
   * ------------------------------------------
   *
   * 根据微信小程序登录信息获取用户信息
   *
   * @param [type] $encryptedData [description]
   * @param [type] $iv [description]
   * @param [type] $sessionKey [description]
   * @return [type]
   */
  public function getUserInfo($encryptedData, $iv, $sessionKey = null)
  {
    if (empty($sessionKey))
    {
      $sessionKey = $this->sessionKey;
    }

    $pc = new WXBizDataCrypt($this->appId, $sessionKey);

    $decodeData = "";

    $errCode = $pc->decryptData($encryptedData, $iv, $decodeData);

    if ($errCode !=0 )
    {
      return [
        'code' => 10001,
        'message' => 'encryptedData 解密失败'
      ];
    }

    return $decodeData;
  }

  /**
   * Created by vicleos
   * 根据 code 获取 session_key 等相关信息
   * @throws \Exception
   */


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-08
   * ------------------------------------------
   * 获取微信用户信息
   * ------------------------------------------
   *
   * 调用微信接口通过code获取用户信息
   *
   * @param  [string] $code [微信小程序中的code]
   * @return [用户信息]
   */
  private function getCode2Session($code)
  {
    try
    {
      // 对请求URL地址进行数据组装
      $code2sessionUrl = sprintf($this->code2sessionUrl, $this->appId, $this->secret, $code);

      // 调用微信接口获取数据
      $response = self::httpGetRequest($code2sessionUrl);

      if(!isset($response['session_key']))
      {
        return self::error(Code::WX_SESSION_ERROR);
      }

      $this->sessionKey = $response['session_key'];

      return $response;
    }
    catch(\Exception $e)
    {
      self::local($e);
    }
  }

}
