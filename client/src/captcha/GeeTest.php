<?php

include_once './client/src/CaptchaRequest.php';

class GeeTestRequest extends CaptchaRequest {

    public function __construct(
        string $websiteURL,
        string $gt,
        string $challenge = null,
        string $geetestApiServerSubdomain = null,
        string $geetestGetLib = null,
        int $version = 3,
        array $initParameters = [],
        string $userAgent = null,
        string $proxyType = null,
        string $proxyAddress = null,
        int $proxyPort = null,
        string $proxyLogin = null,
        string $proxyPassword = null
    ) {
        $options = $this->clearInput([
            "websiteURL" => $websiteURL,
            "gt" => $gt,
            "challenge" => $challenge,
            "geetestApiServerSubdomain" => $geetestApiServerSubdomain,
            "geetestGetLib" => $geetestGetLib,
            "version" => $version,
            "initParameters" => $initParameters,
            "userAgent" => $userAgent,
            "proxyType" => $proxyType,
            "proxyAddress" => $proxyAddress,
            "proxyPort" => $proxyPort,
            "proxyLogin" => $proxyLogin,
            "proxyPassword" => $proxyPassword,
        ]);
        CaptchaRequest::__construct($this->detectProxy($options, "GeeTestTask", "GeeTestTaskProxyless"), $options);
    }

}
