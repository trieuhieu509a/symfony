<?php
namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\TaskType;

class DefaultController extends Controller
{
    public function form(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));



//        $form = $this->createFormBuilder($task)
//            ->add('task', TextType::class)
//            ->add('dueDate', DateType::class, array('widget' => 'single_text'))
//            ->add('save', SubmitType::class, array('label' => 'Create Task'))
//            ->getForm();

        //$task = ...;
        $form = $this->createForm(TaskType::class, $task);

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
