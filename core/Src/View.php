<?php

namespace Src;

use Exception;

class View
{
   private string $view = '';
   private array $data = [];
   private string $root = '';
   private string $layout = '/layouts/main.php';

   public function __construct(string $view = '', array $data = [])
   {
       $this->root = $this->getRoot();
       $this->view = $view;
       $this->data = $data;
   }

   //Ïîëíûé ïóòü äî äèğåêòîğèè ñ ïğåäñòàâëåíèÿìè
   private function getRoot(): string
   {
       global $app;
       $root = $app->settings->getRootPath();
       $path = $app->settings->getViewsPath();

       return $_SERVER['DOCUMENT_ROOT'] . $root . $path;
   }

   //Ïóòü äî îñíîâíîãî ôàéëà ñ øàáëîíîì ñàéòà
   private function getPathToMain(): string
   {
       return $this->root . $this->layout;
   }

   //Ïóòü äî òåêóùåãî øàáëîíà
   private function getPathToView(string $view = ''): string
   {
       $view = str_replace('.', '/', $view);
       return $this->getRoot() . "/$view.php";
   }

   public function render(string $view = '', array $data = []): string
   {
       $path = $this->getPathToView($view);

       if (file_exists($this->getPathToMain()) && file_exists($path)) {

           //Èìïîğòèğóåò ïåğåìåííûå èç ìàññèâà â òåêóùóş òàáëèöó ñèìâîëîâ
           extract($data, EXTR_PREFIX_SAME, '');

           //Âêëş÷åíèå áóôåğèçàöèè âûâîäà
           ob_start();
           require $path;
           //Ïîìåùàåì áóôåğ â ïåğåìåííóş è î÷èùàåì åãî
           $content = ob_get_clean();

           //Âîçâğàùàåì ñîáğàííóş ñòğàíèöó
           return require($this->getPathToMain());
       }
       throw new Exception('Error render');
   }

   public function __toString(): string
   {
       return $this->render($this->view, $this->data);
   }

}