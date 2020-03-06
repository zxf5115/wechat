<?php
namespace zxf5115\Wechat\Common;

use GuzzleHttp\Client;
use zxf5115\Wechat\Common\Code;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-07
 *
 * 公共类
 */
class Common
{

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-08
   * ------------------------------------------
   * Http的post请求
   * ------------------------------------------
   *
   * 对外部接口api进行post调用方式封装
   *
   * @param string $url [请求地址]
   * @param array $params [请求参数]
   * @return 接口数据|错误
   */
  public static function httpPostRequest($url, $params = [])
  {
    return self::callWithoutApi('post', $url, ['form_params' => $params]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2019-11-03
   *
   * 对外部接口api进行get调用方式封装
   *
   * @param    [string]     $url    [请求地址]
   * @param    [array]      $params [请求参数]
   *
   * @return   [接口数据|错误]
   */
  public static function httpGetRequest($url, $params = [])
  {
    return self::callWithoutApi('get', $url, $params);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2019-11-03
   *
   * 对外部接口api进行文件调用方式封装
   *
   * @param    [string]     $url    [请求地址]
   * @param    [array]      $params [请求参数]
   *
   * @return   [接口数据|错误]
   */
  public static function httpFileRequest($url, $params = [])
  {
    return self::callWithoutApi('post', $url, ['multipart' => $params]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-01-07
   *
   * 调用外部接口保存数据
   *
   * @param    [string]     $url  [请求地址]
   * @param    [string]     $path [保存数据路径]
   *
   * @return   [接口数据|错误]
   */
  public static function httpSaveRequest($url, $path = '')
  {
    return self::callWithoutApi('get', $url, ['save_to' => $path]);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2019-11-03
   *
   * 封装api接口调用
   *
   * @param    [string]     $method [请求方式]
   * @param    [string]     $url    [请求地址]
   * @param    [array]      $params [请求参数]
   *
   * @return   [接口数据|错误]
   */
  private static function callWithoutApi($method, $url, $params)
  {
    try
    {
      # 创建 GuzzleHttp 请求对象
      $client = new Client([
        'timeout' => 10.0,
      ]);

      $res = $client->request($method, $url, $params);

      $body = $res->getBody();

      $remainingBytes = $body->getContents();

      return json_decode($remainingBytes, true);
    }
    catch (\Exception $e)
    {
      # 返回错误，根据需求处理
      return self::trace($e);
    }
  }







  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-03-05
   * ------------------------------------------
   * 设置成功信息
   * ------------------------------------------
   *
   * 对操作成功进行信息返回
   *
   * @param string $data 返回数据
   * @param int $code 错误代码
   * @return 成功返回信息
   */
  public static function success($data = '', $code = Code::SUCCESS)
  {
    $response = [
      'status'  => $code,
      'data'    => $data,
      'message' => Code::$message[$code],
    ];

    return $response;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-03-05
   * ------------------------------------------
   * 设置失败信息
   * ------------------------------------------
   *
   * 对操作失败进行信息返回
   *
   * @param int $code 错误代码
   * @return 失败返回信息
   */
  public static function error($code = Code::ERROR)
  {
    $response = [
      'status'  => $code,
      'message' => $message,
    ];

    return $response;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2019-11-03
   *
   * 本地环境下进行日志输出
   *
   * @param    [object]     $exception    [异常对象]
   *
   * @return   [false|错误]
   */
  public static function trace(\Exception $exception)
  {
    if(config('wechat.common.debug'))
    {
      dd($exception->getMessage());
    }
    else
    {
      return '系统错误';
    }
  }
}
