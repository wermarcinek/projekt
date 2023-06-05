<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Form\Type\NoteType;
use App\Service\NoteServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class NoteController.
 */
#[Route('/note')]
class NoteController extends AbstractController
{
    /**
     * Note service.
     */
    private NoteServiceInterface $noteService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param NoteServiceInterface $noteService Note service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(NoteServiceInterface $noteService, TranslatorInterface $translator)
    {
        $this->noteService = $noteService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'note_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $pagination = $this->noteService->getPaginatedList(
            $request->query->getInt('page', 1),
            $filters
        );

        return $this->render('note/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Note $note Note entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'note_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    public function show(Note $note): Response
    {
        return $this->render('note/show.html.twig', ['note' => $note]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'note_create', methods: 'GET|POST', )]
    public function create(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(
            NoteType::class,
            $note,
            ['action' => $this->generateUrl('note_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->save($note);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Note    $note    Note entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'note_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Note $note): Response
    {
        $form = $this->createForm(
            NoteType::class,
            $note,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('note_edit', ['id' => $note->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->save($note);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/edit.html.twig',
            [
                'form' => $form->createView(),
                'note' => $note,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Note    $note    Note entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'note_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Note $note): Response
    {
        $form = $this->createForm(
            FormType::class,
            $note,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('note_delete', ['id' => $note->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->delete($note);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/delete.html.twig',
            [
                'form' => $form->createView(),
                'note' => $note,
            ]
        );
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{category_id: int, tag_id: int, status_id: int}
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');

        return $filters;
    }
}
