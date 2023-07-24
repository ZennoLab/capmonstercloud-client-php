<?php
namespace ZennoLab\CapMonster\captcha; 
use \ZennoLab\CapMonster\CaptchaRequest;

class ComplexImageRequest extends CaptchaRequest
{
    public function __construct(
        string $_class,
        array $metadata,
        array $imageUrls = [],
        array $imagesBase64 = [],
        string $userAgent = null,
        string $websiteURL = null
    )
    {
        $options = $this->clearInput([
            "class" => $_class,
            "imageUrls" => $imageUrls,
            "imagesBase64" => $imagesBase64,
            "metadata" => $metadata,
            "userAgent" => $userAgent,
            "websiteURL" => $websiteURL,
        ]);
        CaptchaRequest::__construct('ComplexImageTask', $options);
    }
}
