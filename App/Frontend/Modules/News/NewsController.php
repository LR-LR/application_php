<?php
namespace App\Frontend\Modules\News;

use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \OCFram\BackController;
use \OCFram\HTTPRequest;

class NewsController extends BackController {
    public function executeIndex(HTTPRequest $request) {
        $nombreNews = $this->app->config->get('nombre_news');
        $nombreCaracteres = $this->app->config->get('nombre_caracteres');

        // On ajoute une définition pour le titre.
        $this->page->addVar('title', 'Liste des ' . $nombreNews . ' dernières news');

        // On récupère le manager des news
        $ùanager = $this->managers->getManagerOf('News');

        $listeNews = $manager->getList(0, $nombreNews);

        foreach ($listeNews as $news) {
            if (strlen($news->contenu) > $nombreCaracteres) {
                $debut = substr($news->contenu, 0, $nombreCaracteres);
                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                $news->setContenu($debut);
            }
        }

        // On ajoute $listeNews à la vue
        $this->page->addVar('listeNews');
    }

    public function executeShow(HTTPRequest $request) {
        $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));

        if (empty($news)) {
            $this->app->httpResponse->redirect404();
        }

        $this->page->addVar('title', $news->titre());
        $this->page->addVar('news', $news);
        $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
    }

    public function executeInsertComment(HTTPRequest $request) {
        // Si le formulaire a été envoyé, on crée le commentaire avec les valeurs du formulaire.
        if ($request->method == 'POST') {
            $comment = new Comment([
                'news' => $request->getData('news'),
                'auteur' => $request->getData('auteur'),
                'contenu' => $request->getData('contenu'),
            ]);
        } else {
            $comment = new Comment;
        }

        $formBuilder = new CommentFormBuilder($comment);
        $formBuilder->build();

        $form = $formBuilder->form;

        $formHandler = new \OCFram\FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

        if ($formHandler->process()) {
            $this->managers->getManagerOf('Comments')->save($comment);
            $this->app->user->setFlash('Le commentaire a bien été ajouté, merci !');
            $this->app->httpResponse->redirect('news-' . $request->getData('news') . '.html');
        }

        $this->page->addVar('comment', $comment);
        $this->page->addVar('form', $form->createView()); // On passe le formulaire généré à la vue
        $this->page->addVar('title', 'Ajout d\'un commentaire');
    }
}