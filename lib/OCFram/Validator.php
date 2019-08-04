<?php
namespace OCFram;

abstract class Validator {
    protected $errorMessage;

    public function __construct($errorMessage) {
        $this->setErrorMessage($errorMessage);
    }

    abstract public function isValid($value);

    // GETTER
    public function __get($name) {
        return $this->$name;
    }

    // SETTER
    public function setErrorMessage($errorMessage) {
        if (is_string($errorMessage)) {
            $this->errorMessage = $errorMessage;
        }
    }
}