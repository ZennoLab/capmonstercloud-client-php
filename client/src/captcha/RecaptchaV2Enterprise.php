<?php

include_once './client/src/CaptchaRequest.php';


class RecaptchaV2EnterpriseRequest extends CaptchaRequest {

    public function __construct(
        string $websiteURL,
        string $websiteKey,
        string $enterprisePayload = null,
        string $apiDomain = null,
        string $userAgent = null, 
        string $cookies = null,
        string $proxyType = null,
        string $proxyAddress = null,
        int $proxyPort = null,
        string $proxyLogin = null,
        string $proxyPassword = null
    ) {
        $options = $this->clearInput([
            "websiteURL" => $websiteURL,
            "websiteKey" => $websiteKey,
            "enterprisePayload" => $enterprisePayload,
            "apiDomain" => $apiDomain,
            "proxyType" => $proxyType,
            "proxyAddress" => $proxyAddress,
            "proxyPort" => $proxyPort,
            "proxyLogin" => $proxyLogin,
            "proxyPassword" => $proxyPassword,
            "userAgent" => $userAgent,
            "cookies" => $cookies
        ]);
        CaptchaRequest::__construct($this->detectProxy($options, "RecaptchaV2EnterpriseTask", "RecaptchaV2EnterpriseTaskProxyless"), $options);
    }

}