<?php

namespace App\Controller;

use App\Entity\Employees;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EmployeeTableController extends AbstractController
{
    public function employeeTable(EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // с помощью этой функции не даем доступ к контроллеру не авторизированым пользовтелям
        $employeesList = $entityManager ->getRepository(Employees::class)->findAll();//поиск всех объектов
        return $this->render('/display.html.twig', array('data' => $employeesList));
    }

}