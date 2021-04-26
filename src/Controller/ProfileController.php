<?php


namespace App\Controller;


use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{

    /**
     * @Route("/profile", name="profile")
     * @param InertiaInterface $inertia
     * @return Response
     */
    public function profile(InertiaInterface $inertia): Response
    {
        $user = $this->getUser();
        return $inertia->render('Profile', ['prop' => $user]);
    }

    /**
     * @param InertiaInterface $inertia
     * @return Response
     * @Route("/editEmail", name="page_edit_email")
     */
    public function PageEditEmail(InertiaInterface $inertia): Response
    {
        $user = $this->getUser();
        return $inertia->render('EditEmail',['prop'=>$user]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param EmailVerifier $emailVerifier
     * @return RedirectResponse
     * @Route("/confirmEditEmail", name="edit_email")
     */
    public function editEmail(Request $request, EntityManagerInterface $em,EmailVerifier $emailVerifier): RedirectResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);
        //dd($data);
        $user = $this->getUser();

        $user->setEmail($data['email']);
        $user->setIsVerified(false);
        $em->persist($user);
        $em->flush();

        $emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('mailer@willersurthur.fr', 'verification Bot'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
        return $this->redirectToRoute('profile');

    }

    /**
     * @param InertiaInterface $inertia
     * @return Response
     * @Route("/editPassword", name="page_edit_password")
     */
    public function PageEditPassword(InertiaInterface $inertia): Response
    {
        $user = $this->getUser();
        return $inertia->render('EditPassword',['prop'=>$user]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $em
     * @param MailerInterface $mailer
     * @return RedirectResponse
     * @throws TransportExceptionInterface
     * @Route("/confirmEditPassword", name="edit_password")
     */
    public function editPassword(Request $request,UserPasswordEncoderInterface $passwordEncoder,
                                 EntityManagerInterface $em,MailerInterface $mailer): RedirectResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);
        //dd($data);
        $user = $this->getUser();
        $encodedPassword = $passwordEncoder->encodePassword(
            $user,
            $data['passwordOne']
        );
        $user->setPassword($encodedPassword);
        $em->persist($user);
        $em->flush();

        $email = (new TemplatedEmail())
            ->from(new Address('resetPassword@willersurthur.com', 'reset Bot'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/emailReset.html.twig');

        $mailer->send($email);

        return $this->redirectToRoute('profile');
    }


}