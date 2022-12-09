<?php

class Result {

    public $result;
    public $message;

    public function __construct(bool $result, $message) {
        $this->result = $result;
        $this->message = $message;
    }

    public function setResult(bool $newResult) : void {
        $this->result = $newResult;
    }

    public function setMessage($newMessage) : void {
        $this->message = $newMessage;
    }

}