<?php
namespace OCFram;

class Page extends ApplicationComponent {
    protected $contentFile;
    protected $vars = [];

    public function addVar($var, $value) {
        if (!is_string($var) || is_numeric($var) || empty($var)) {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaîne de caractères non nulle');
        } else {
            $this->vars[$var] = $value;
        }
    }

    public function getGeneratedPage() {
        if (!file_exists($this->contentFile)) {
            throw new \RuntimeException('La vue specifiée n\'existe pas');
        } else {
            $user = $this->app->user;

            extract($this->vars);

            ob_start();
            require $this->contentFile;
            $content = ob_get_clean();

            ob_start();
            require __DIR__ . '/../../App/' . $this->app->name . '/Templates/layout.php';
            return ob_get_clean();
        }
    }

    public function setContentFile($contentFile) {
        if (!is_string($contentFile) || empty($contentFile)) {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        } else {
            $this->contentFile = $contentFile;
        }
    }
}