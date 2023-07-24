<?php
namespace ZennoLab\CapMonster\captcha;
use \ZennoLab\CapMonster\CaptchaRequest;

class HCaptchaRequest extends CaptchaRequest {

    public function __construct(
        string $websiteURL,
        string $websiteKey,
        bool $isInvisible=null,
        string $data=null,
        string $userAgent=null,
        string $cookies=null,
        string $proxyType = null,
        string $proxyAddress = null,
        int $proxyPort = null,
        string $proxyLogin = null,
        string $proxyPassword = null
    ) {
        $options = $this->clearInput([
            "websiteURL" => $websiteURL,
            "websiteKey" => $websiteKey,
            "isInvisible" => $isInvisible,
            "data" => $data,
            "userAgent" => $userAgent,
            "cookies" => $cookies,
            "proxyType" => $proxyType,
            "proxyAddress" => $proxyAddress,
            "proxyPort" => $proxyPort,
            "proxyLogin" => $proxyLogin,
            "proxyPassword" => $proxyPassword,
        ]);
        CaptchaRequest::__construct($this->detectProxy($options, "HCaptchaTask", "HCaptchaTaskProxyless"), $options);
    }

}
