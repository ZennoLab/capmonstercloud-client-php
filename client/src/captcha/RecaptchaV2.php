<?php

include_once './client/src/CaptchaRequest.php';


class RecaptchaV2Request extends CaptchaRequest {

    public function __construct(
            string $websiteURL, 
            string $websiteKey, 
            string $recaptchaDataSValue = null, 
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
            "proxyType" => $proxyType,
            "proxyAddress" => $proxyAddress,
            "proxyPort" => $proxyPort,
            "proxyLogin" => $proxyLogin,
            "proxyPassword" => $proxyPassword,
            "recaptchaDataSValue" => $recaptchaDataSValue, 
            "userAgent" => $userAgent,
            "cookies" => $cookies
        ]);
        CaptchaRequest::__construct($this->detectProxy($options, "NoCaptchaTask", "NoCaptchaTaskProxyless"), $options);
    }

}