<?php

namespace ConorSmith\GeneratorConsoleDemo;

class Payload
{
    const FAILURE = "FAILURE";
    const PROCESSING = "PROCESSING";
    const SUCCESS = "SUCCESS";

    public static function success($message)
    {
        return new self(self::SUCCESS, $message);
    }

    public static function failure($message)
    {
        return new self(self::FAILURE, $message);
    }

    public static function processing($message)
    {
        return new self(self::PROCESSING, $message);
    }

    private $status;
    private $message;

    private function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
