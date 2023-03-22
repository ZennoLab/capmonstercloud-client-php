<?php

class Timeouts {

    public static $recaptchaV2Timeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 3,
        "timeout" => 1000 * 180
    ];

    public static $recaptchaV2EnterpriseTimeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 3,
        "timeout" => 1000 * 180
    ];

    public static $recaptchaV3Timeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 3,
        "timeout" => 1000 * 180
    ];

    public static $imageToTextTimeouts = [
        "firstRequestDelay" => 350,
        "requestInterval" => 200,
        "timeout" => 1000 * 10
    ];

    public static $funCaptchaTimeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 1,
        "timeout" => 1000 * 80
    ];

    public static $hCaptchaTimeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 3,
        "timeout" => 1000 * 180
    ];

    public static $geeTestTimeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 1,
        "timeout" => 1000 * 80
    ];

    public static $turnstileTimeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 1,
        "timeout" => 1000 * 80
    ];

    public static $complexImageTimeouts = [
        "firstRequestDelay" => 1000 * 1,
        "requestInterval" => 1000 * 1,
        "timeout" => 1000 * 80
    ];

    public static function detectTimeouts(string $captchaType) : array {
        switch($captchaType) {
            case "FunCaptchaTaskProxyless":
            case "FunCaptchaTask":
                return self::$funCaptchaTimeouts;
            case "GeeTestTaskProxyless":
            case "GeeTestTask":
                return self::$geeTestTimeouts;
            case "HCaptchaTaskProxyless":
            case "HCaptchaTask":
                return self::$hCaptchaTimeouts;
            case "ImageToTextTask":
                return self::$imageToTextTimeouts;
            case "RecaptchaV2EnterpriseTaskProxyless":
            case "RecaptchaV2EnterpriseTask":
                return self::$recaptchaV2EnterpriseTimeouts;
            case "NoCaptchaTaskProxyless":
            case "NoCaptchaTask":
                return self::$recaptchaV2Timeouts;
            case "RecaptchaV3TaskProxyless":
                return self::$recaptchaV3Timeouts;
            case "TurnstileTask":
            case "TurnstileTaskProxyless":
                return self::$turnstileTimeouts;
            case "ComplexImageTask":
                return self::$complexImageTimeouts;
        }
    }

}
