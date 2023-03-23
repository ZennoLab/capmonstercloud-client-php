<?php

include_once './client/src/captcha/ComplexImage.php';

class ComplexImageRecaptchaRequest extends ComplexImageRequest
{
    public $_class = 'recaptcha';

    public function __construct(
        array $metadata,
        array $imageUrls = [],
        array $imagesBase64 = [],
        string $userAgent = null,
        string $websiteURL = null
    )
    {
        parent::__construct($this->_class, $metadata, $imageUrls, $imagesBase64, $userAgent, $websiteURL);
    }
}
