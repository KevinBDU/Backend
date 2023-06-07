<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TaskController extends AbstractController
{
    /**
     * @Route("/tasks/listing", name="tasks_listing")
     */
    public function taskListing()
    {

        $repository = $this->getDoctrine()->getRepository(Task::class);

        $tasks = $repository->findall();

        dump($tasks);

        return $this->render('tasks/listing.html.twig', array('task' => $tasks));
    }

    /**
     * @Route("/tasks/create", name="task_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createTask(Request $request)
    {
        $task = new Task();

        $now = new \DateTime('now');

        $task->setCreatedDateTask($now);

        $form = $this->createForm(TaskType::class, $task, array());

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $task->setNameTask($form['nameTask']->getData());
            $task->setCategory($form['category']->getData());
            $task->setDescriptionTask($form['descriptionTask']->getData());
            $task->setPriorityTask($form['priorityTask']->getData());
            $task->setDueDateTask($form['dueDateTask']->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('tasks_listing');
        }
        return $this->render('tasks/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/tasks/edit/{id}", name="task_edit")
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editTask($id, Request $request)
    {
        $task = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findOneBy(array('idTask' => $id));

        $form = $this->createForm(TaskType::class, $task, array());

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task->setNameTask($form['nameTask']->getData());
            $task->setCategory($form['category']->getData());
            $task->setDescriptionTask($form['descriptionTask']->getData());
            $task->setPriorityTask($form['priorityTask']->getData());
            $task->setDueDateTask($form['dueDateTask']->getData());

            $em->flush();
            return $this->redirectToRoute('tasks_listing');
        }

        return $this->render('tasks/edit.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/tasks/delete/{id}", name="task_delete")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTask($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($this->getDoctrine()
            ->getRepository(Task::class)
            ->findOneBy(array('idTask' => $id)));
        $em->flush();
        return $this->redirectToRoute('tasks_listing');
    }
}
