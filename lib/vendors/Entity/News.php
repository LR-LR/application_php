<?php
namespace Entity;

use \OCFram\Entity;

class News extends Entity {
    protected $auteur;
    protected $titre;
    protected $contenu;
    protected $dateAjout;
    protected $dateModif;

    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;

    public function isValid() {
        return !(empty($this->auteur) || empty($this->titre) || empty($this->contenu));
    }

    // GETTERS
    public function __get($name) {
        return $this->$name;
    }

    // SETTERS
    public function setAuteur($auteur) {
        if (!is_string($auteur) || empty($auteur)) {
            $this->erreurs[] = self::AUTEUR_INVAIDE;
        } else {
            $this->auteur = $auteur;
        }
    }

    public function setTitre($titre) {
        if (!is_string($titre) || empty($titre)) {
            $this->erreurs[] = self::TITRE_INVALIDE;
        } else {
            $this->titre = $titre;
        }
    }

    public function setContenu($contenu) {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        } else {
            $this->contenu = $contenu;
        }
    }

    public function setDateAjout(\DateTime $dateAjout) {
        $this->dateAjout = $dateAjout;
    }

    public function setDateModif(\DateTime $dateModif) {
        $this->dateModif = $dateModif;
    }
}