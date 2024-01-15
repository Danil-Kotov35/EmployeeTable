<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
 public function redirectHome(Request $request){
         return $this->redirectToRoute('app_login');
 }
    public function home(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // с помощью этой функции не даем доступ к контроллеру не авторизированым пользовтелям
        return $this-> render('/home.html.twig');
 }
}