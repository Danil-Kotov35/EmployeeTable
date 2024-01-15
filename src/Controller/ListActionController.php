<?php

namespace App\Controller;

use App\Entity\Employees;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ListActionController extends AbstractController
{
    public function newEmployeesAction(Request $request,EntityManagerInterface $entityManager){   // добавление данных нового сотруцдника
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // с помощью этой функции не даем доступ к контроллеру не авторизированым пользовтелям
        $employees = new Employees();
        $form = $this->createFormBuilder($employees)
            ->add('Name', TextType::class)
            ->add('JobTitle', TextType::class)
            ->add('Salary', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();
        $form ->handleRequest($request); // Handle request - это функция или метод, который отвечает за обработку входящих запросов. Он служит для приема, обработки, маршрутизации и передачи входящих HTTP-запросов
        if ($form->isSubmitted() && $form->isValid()) { // если был отправлен запрос и форма валидна отправляем данные
            $entityManager->persist($employees);
            $entityManager->flush();
            return $this->redirectToRoute('employeeTable');//редирект на страницу с таблицей
        } else {
            return $this->render('/new.html.twig', array('form' => $form->createView(),)); // createView() обычно относится к функции или методу, который создает или обновляет представление базы данных.
        }

 }

 public function UpdateList($id, Request $request,EntityManagerInterface $entityManager){ // обновление данных созданный сотрдуников
     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // с помощью этой функции не даем доступ к контроллеру не авторизированым пользовтелям
     $employeesId = $entityManager -> getRepository(Employees::class)->find($id); // поиск ID сотрудника
     if (!$employeesId) {
         throw $this->createNotFoundException(
             'не найден сотрудник с ID = '.$id
         );
     }
     $form = $this->createFormBuilder($employeesId)
         ->add('Name', TextType::class  )
         ->add('JobTitle', TextType::class)
         ->add('Salary', IntegerType::class)
         ->add('save', SubmitType::class, array('label' => 'Submit'))
         ->getForm();
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $newEmployee = $form->getData();
         $entityManager->persist($newEmployee);
         $entityManager->flush();
         return $this->redirectToRoute('employeeTable'); //редирект на страницу с таблицей
     } else {
         return $this->render('/update.html.twig', array('form' => $form->createView()));// createView() обычно относится к функции или методу, который создает или обновляет представление базы данных.
     }

 }

 public function deleteList(EntityManagerInterface $entityManager,$id){ // удаление данных сотрудника
     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); // с помощью этой функции не даем доступ к контроллеру не авторизированым пользовтелям
     $employeesId = $entityManager -> getRepository(Employees::class)->find($id); // поиск ID сотрудника
     if (!$employeesId) {
         throw $this->createNotFoundException('не найден сотрудник с ID = '.$id);
     }
     $entityManager->remove($employeesId);
     $entityManager->flush();
     return $this->redirectToRoute('employeeTable'); //редирект на страницу с таблицей
 }
}