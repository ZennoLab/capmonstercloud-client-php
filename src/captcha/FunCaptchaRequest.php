<?php
namespace ZennoLab\CapMonster\captcha;
use \ZennoLab\CapMonster\CaptchaRequest;

class FunCaptchaRequest extends CaptchaRequest {

    public function __construct(
        string $websiteURL,
        string $websitePublicKey,
        string $userAgent,
        string $funcaptchaApiJSSubdomain=null,
        string $data=null,
        string $cookies=null,
        string $proxyType = null,
        string $proxyAddress = null,
        int $proxyPort = null,
        string $proxyLogin = null,
        string $proxyPassword = null
    ) {
        $options = $this->clearInput([
            "websiteURL" => $websiteURL,
            "websitePublicKey" => $websitePublicKey,
            "userAgent" => $userAgent,
            "funcaptchaApiJSSubdomain" => $funcaptchaApiJSSubdomain,
            "data" => $data,
            "cookies" => $cookies,
            "proxyType" => $proxyType,
            "proxyAddress" => $proxyAddress,
            "proxyPort" => $proxyPort,
            "proxyLogin" => $proxyLogin,
            "proxyPassword" => $proxyPassword,
        ]);
        CaptchaRequest::__construct($this->detectProxy($options, "FunCaptchaTask", "FunCaptchaTaskProxyless"), $options);
    }

}
