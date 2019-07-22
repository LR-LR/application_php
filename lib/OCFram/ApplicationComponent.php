<?php
namespace OCFram;

class ApplicationComponent {
    protected $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function __get($name) {
        return $this->$name;
    }
}