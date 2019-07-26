<?php
namespace Model;

class NewsManagerPDO extends NewsManager {
    protected function add(News $news) {
        $requete = $this->dao->prepare('INSERT INTO news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');

        $requete->execute([
            'titre' => $news->titre,
            'auteur' => $news->auteur,
            'contenu' => $news->contenu,
        ]);
    }

    protected function modify(News $news) {
        $requete = $this->dao->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id ) :id');

        $requete->bindValue(':titre', $news->titre);
        $requete->bindValue(':auteur', $news->auteur);
        $requete->bindValue(':contenu', $news->contenu);
        $requete->bindValue(':id', $news->id, \PDO::PARAM_INT);

        $requete->execute();
    }

    public function delete($id) {
        $this->dao->exec('DELETE FROME news WHERE id = ' . (int) $id);
    }

    public function count() {
        return $this->dao->query('SELECT COUNT(*) FROM news');
    }

    public function getList($debut = -1, $limite = -1) {
        $sql = 'SELECT * FROM news ORDER id DESC';

        if ($debut != -1 || $limite != -1) {
            $sql .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        $listeNews = $requete->fetchAll();

        foreach ($listeNews as $news) {
            $news->setDateAjout(new \DateTime($news->dateAjout));
            $news->setDateModif(new \DateTime($news->dateModif));
        }

        $requete->closeCursor();

        return $listeNews;
    }

    public function getUnique($id) {
        $requete = $this->dao->prepare('SELECT * FROM news WHERE id = :id');
        $requete->bidValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        if ($news = $requete->fetch()) {
            $news->setDateAjout(new \DateTime($news->dateAjout));
            $news->setDateModif(new \DateTime($news->dateModif));

            return $news;
        } else {
            return null;
        }
    }
}