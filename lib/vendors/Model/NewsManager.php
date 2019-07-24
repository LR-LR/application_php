<?php
namespace Model;

use \Entity\News;
use \OCFram\Manager;

abstract class NewsManager extends Manager {
    /**
     * Méthode retournant une liste de news demandée
     * @param int $debut La première news à sélectionner
     * @param int $limite la dernière news à sélectionner
     * @return array La liste des news. Chaque entrée est une instance de News.
     */
    abstract public function getList($debut = -1, $limite = -1);

    /**
     * Méthode retournant une news précise.
     * @param int $id L'identifiant de la new à récupérer
     * @return News La news demandée
     */
    abstract public function getUnique($id);
}