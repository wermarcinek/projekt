<?php
/**
 * Task controller.
 */

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 */
#[Route('/task')]
class TaskController extends AbstractController
{
    /**
     * Task service.
     */
    private TaskServiceInterface $taskService;

    /**
     * Constructor.
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'task_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->taskService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('task/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Task $task Task
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'task_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', ['task' => $task]);
    }
}
