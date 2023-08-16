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
        string $proxyPassword = null,
        string $cloudflareTaskType = null,
        string $htmlPageBase64 = null,
        string $userAgent = null,
        string $pageAction = null,
        string $data = null,
        string $pageData = null
    ) {
        $options = $this->clearInput([
            "websiteURL" => $websiteURL,
            "websiteKey" => $websiteKey,
            "proxyType" => $proxyType,
            "proxyAddress" => $proxyAddress,
            "proxyPort" => $proxyPort,
            "proxyLogin" => $proxyLogin,
            "proxyPassword" => $proxyPassword,
            "cloudflareTaskType" => $cloudflareTaskType,
            "htmlPageBase64" => $htmlPageBase64,
            "userAgent" => $userAgent,
            "pageAction" => $pageAction,
            "data" => $data,
            "pageData" => $pageData
        ]);
        CaptchaRequest::__construct($this->detectProxy($options, "TurnstileTask", "TurnstileTaskProxyless"), $options);
    }

}
