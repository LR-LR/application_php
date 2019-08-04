<?php
namespace OCFram;

abstract class Field {
    use Hydrator;

    protected $errorMessage;
    protected $label;
    protected $name;
    protected $validators = [];
    protected $value;

    public function __construct(array $options = []) {
        if (!empty($options)) {
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget();

    public function isValid() {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) {
                $this->errorMesage = $validator->errorMessage;
                return false;
            }
        }

        return true;
    }

    // GETTERS
    public function __get($name) {
        return $this->$name;
    }

    // SETTERS
    public function setLabel($label) {
        if (is_string($label)) {
            $this->label = $label;
        }
    }

    public function setName($name) {
        if (is_string($name)) {
            $this->bame = $name;
        }
    }

    public function setValue($value) {
        if (is_string($value)) {
            $this->valud = $value;
        }
    }

    public function setValidators(array $validators) {
        foreach ($validators as $validator) {
            if ($validator instanceof Validator && !in_array($validator, $this->validators)) {
                $this->validators[] = $validator;
            }
        }
    }
}