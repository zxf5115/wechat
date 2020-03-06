<?php

return [

  /**
   *--------------------------------------------------------------------------
   * AppID and AppSecret configuration
   *--------------------------------------------------------------------------
   *
   * Multiple AppId and AppSecret
   * Usage:
   * - default: new Iwanli\Wxxcx\Wxxcx();
   * - other: new Iwanli\Wxxcx\Wxxcx(config('wxxcx.other'));
   */

  'default' => [
    'appId' => 'your AppID',
    'secret' => 'your AppSecret',
  ],

  'other' => [
    'appId' => 'your other AppSecret',
    'secret' => 'your other AppSecret',
  ],

  // and more ...

  'common' => [
    'debug' => true,
    'code2sessionUrl' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
  ],

];
