<?php
namespace App\Backend;

use \OCFram\Application;

class BackendApplication extends Application {
    public function __construct() {
        parent::__construct();

        $this->name = 'Backend';
    }

    public function run() {
        if ($this->user->isAuthenticated()) {
            $controler = $this->getController();
        } else {
            $controller = new Modules\Connextion\ConnexionController($this, 'Connexion', 'index');
        }

        $controller->execute();

        $this->httpResponse->setPage($controller->page());
        $this->httpResponse->send();
    }
}