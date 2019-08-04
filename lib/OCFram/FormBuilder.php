<?php
namespace OCFram;

abstract class FormBuilder {
    protected $form;

    public function __construct(Entity $entity) {
        $this->setForm(new Form($entity));
    }

    abstract public function build();

    // GETTERS
    public function __get($name) {
        return $this->$name;
    }

    // SETTERS
    public function setForm(Form $form) {
        $this->form = $form;
    }
}