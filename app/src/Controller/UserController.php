<?php
/**
 * User Controller.
 */

namespace App\Controller;

use App\Service\UserDataServiceInterface;
use Form\Type\ChangeEmailType;
use Form\Type\ChangePasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserController.
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * User service.
     */
    private UserDataServiceInterface $userService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * UserController constructor.
     *
     * @param UserDataServiceInterface $userService the user service
     * @param TranslatorInterface      $translator  the translator
     */
    public function __construct(UserDataServiceInterface $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    /**
     * Edit password route.
     *
     * @param Request $request the request object
     *
     * @return Response the response
     *
     * @Route("/change_password", name="change_password", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_USER")
     */
    #[Route('/change_password', name: 'change_password', methods: 'GET|POST')]
    #[IsGranted('ROLE_USER')]
    public function editPassword(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(
            ChangePasswordType::class,
            null,
            [
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();
            $this->addFlash(
                'success',
                $this->translator->trans('message.password_edited_successfully')
            );
            $this->userService->changePassword($user, $newPassword);

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'user/panel_password.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * Edit email route.
     *
     * @param Request $request the request object
     *
     * @return Response the response
     *
     * @Route("/change_email", name="change_email", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_USER")
     */
    #[Route('/change_email', name: 'change_email', methods: 'GET|POST')]
    #[IsGranted('ROLE_USER')]
    public function editEmail(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(
            ChangeEmailType::class,
            null,
            [
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newEmail = $form->get('newEmail')->getData();

            $this->addFlash(
                'success',
                $this->translator->trans('message.email_edited_successfully')
            );

            $this->userService->changeEmail($user, $newEmail);

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'user/email.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }
}
