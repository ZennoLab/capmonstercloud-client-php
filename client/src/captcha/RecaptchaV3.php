<?php

include_once './client/src/CaptchaRequest.php';


class RecaptchaV3Request extends CaptchaRequest {

    public function __construct(string $websiteURL, string $websiteKey, float $minScore=null, string $pageAction=null) {
        $options = [
            "websiteURL" => $websiteURL, 
            "websiteKey" => $websiteKey,
            "minScore" => $minScore,
            "pageAction" => $pageAction
        ];
        CaptchaRequest::__construct("RecaptchaV3TaskProxyless", $options);
    }

}