<?php
namespace ZennoLab\CapMonster\captcha;
use \ZennoLab\CapMonster\CaptchaRequest;

class ImageToTextRequest extends CaptchaRequest {

    public function __construct(string $body, string $CapMonsterModule=null, int $recognizingThreshold=null, bool $Case=null, int $numeric=null, bool $math=null) {
        $options = [
            "body" => $body,
            "CapMonsterModule" => $CapMonsterModule,
            "recognizingThreshold" => $recognizingThreshold,
            "Case" => $Case,
            "numeric" => $numeric,
            "math" => $math 
        ];
        CaptchaRequest::__construct("ImageToTextTask", $options);
    }

}
