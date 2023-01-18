<?php

include_once './client/src/CaptchaRequest.php';


class TurnstileRequest extends CaptchaRequest {

    public function __construct(
        string $websiteURL,
        string $websiteKey,
        string $proxyType = null,
        string $proxyAddress = null,
        int $proxyPort = null,
        string $proxyLogin = null,
        string $proxyPassword = null
    ) {
        $options = $this->clearInput([
            "websiteURL" => $websiteURL,
            "websiteKey" => $websiteKey,
            "proxyType" => $proxyType,
            "proxyAddress" => $proxyAddress,
            "proxyPort" => $proxyPort,
            "proxyLogin" => $proxyLogin,
            "proxyPassword" => $proxyPassword
        ]);
        CaptchaRequest::__construct($this->detectProxy($options, "TurnstileTask", "TurnstileTaskProxyless"), $options);
    }

}