<?php

namespace Salespoint\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Salespoint\UserBundle\Entity\Firm;
use Symfony\Component\Security\Core\Role\Role;
use Salespoint\SaasBundle\Entity\Subscription;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Salespoint\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class FOSUBUserProvider extends BaseClass
{

    protected $container;

    public function __construct(\FOS\UserBundle\Model\UserManagerInterface $userManager, array $properties, \Doctrine\ORM\EntityManager $em, Container $container)
    {
        parent::__construct($userManager, $properties);
        $this->_em = $em;
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = null;

        $session = $this->container->get('session');
        $token = $this->container->get('security.context')->getToken();
        if (null !== $token) {
            $user = $token->getUser();
        }
        $username = $response->getEmail();

        $service = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';
        $setter_refresh_token = $setter . 'RefreshToken';

        $request = $this->container->get('request');

        if (null !== $user && $user instanceof User) {
            // User already logged in, connect existing account 
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            if (!empty($response->getRefreshToken())) {
                $user->$setter_refresh_token($response->getRefreshToken());
            }

            if ($service == 'google') {
                $user->setGoogleTokenExpires($response->getExpiresIn());
                $user->setGoogleRawToken($response->getRawToken());
                $user->setGoogleAccessCode($request->query->get('code'));
            }


            $this->_em->flush();
            return $user;
        }

        $user = $this->getUserByOAuthUserResponse($response);

        //when the user is registrating
        if (null === $user) {
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            if (!empty($response->getRefreshToken())) {
                $user->$setter_refresh_token($response->getRefreshToken());
            }

            switch ($service) {
                case 'google':
                    $user = $this->setUserFromGoogle($response, $user);
                    $user->setGoogleTokenExpires($response->getExpiresIn());
                    $user->setGoogleRawToken($response->getRawToken());
                    $user->setGoogleAccessCode($request->query->get('code'));
                    break;
                case 'live':
                    $user = $this->setUserFromWindowsLive($response, $user);
                    break;
                default :
                    break;
            }

            $translator = $this->container->get('translator');
            $session->getFlashBag()->add('notice', $translator->trans('user.oauth.success.create'));

            return $user;
        }

        //if user exists - go with the HWIOAuth way
        $user = $this->getUserByOAuthUserResponse($response, true);

        $user->$setter_token($response->getAccessToken());
        if (!empty($response->getRefreshToken())) {
            $user->$setter_refresh_token($response->getRefreshToken());
        }

        if ($service == 'google') {
            $user->setGoogleTokenExpires($response->getExpiresIn());
            $user->setGoogleRawToken($response->getRawToken());
            $user->setGoogleAccessCode($request->query->get('code'));
        }

        $this->_em->flush();

        return $user;
    }

    /**
     * Override parent::loadUserByOAuthUserResponse(). serach user by email.
     * 
     * @param UserResponseInterface $response
     * @return type
     * @throws AccountNotLinkedException
     */
    private function getUserByOAuthUserResponse(UserResponseInterface $response, $exc = false)
    {
        $username = $response->getEmail();

        $user = $this->userManager->findUserBy(array('username' => $username));
        if (null === $user || null === $username) {
            $service = $response->getResourceOwner()->getName();

            $user = $this->userManager->findUserBy(array($service . '_id' => $username));
            if (null === $user) {
                if ($exc) {
                    throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
                }
                else {
                    return null;
                }
            }
        }

        return $user;
    }

    /**
     * Create new account
     * 
     * @param UserResponseInterface $response
     * @param UserInterface $user
     * @return UserInterface
     */
    private function setUserFromGoogle(UserResponseInterface $response, UserInterface $user)
    {
        $data = $response->getResponse();
        $user->setUsername($data['email']);
        $user->setEmail($data['email']);
        $user->setFirstName($data['given_name']);
        $user->setLastName($data['family_name']);
        $user->setLanguage($data['locale']);
        $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $user->setPlainPassword($pass);
        $mailer = $this->container->get('registration.mailer');
        $mailer->sendHWOauthConfirmation($user, $pass);
        $user->setRoles(array(
          new Role('ROLE_NEEDPASSWORD'),
        ));
        $user->setIsSuperAdmin(true);
        $firm = new Firm();
        $firm->setName($data['name']);
        $user->setFirm($firm);
        $this->container->get('sp.user.manager')->setDefaultGroup($user);
        $subscription = $this->_em->getRepository('SalespointSaasBundle:Subscription')->addSubscription($user);
        $user->setSubscription($subscription);
        $user->setEnabled(true);
        $this->userManager->updateUser($user);
        $mailer->sendInsideConfirmation($user);
        $this->container->get('mailchimp.connector.manager')->addSubscriber($user);
        return $user;
    }

    /**
     * 
     * @param UserResponseInterface $response
     * @param UserInterface $user
     * @return UserInterface
     */
    private function setUserFromWindowsLive(UserResponseInterface $response, UserInterface $user)
    {
        $data = $response->getResponse();
        $email = $response->getEmail();
        $user->setUsername($email);
        $user->setEmail($email);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setLanguage(substr($data['locale'], 0, 2));
        $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $user->setPlainPassword($pass);
        $mailer = $this->container->get('registration.mailer');
        $mailer->sendHWOauthConfirmation($user, $pass);
        $user->setRoles(array(
          new Role('ROLE_NEEDPASSWORD'),
        ));
        $user->setIsSuperAdmin(true);
        $firm = new Firm();
        $firm->setName($data['name']);
        $user->setFirm($firm);
        $this->container->get('sp.user.manager')->setDefaultGroup($user);

        $subscription = $this->_em->getRepository('SalespointSaasBundle:Subscription')->addSubscription($user);
        $user->setSubscription($subscription);
        $user->setEnabled(true);
        $this->userManager->updateUser($user);
        $mailer->sendInsideConfirmation($user);
        $this->container->get('mailchimp.connector.manager')->addSubscriber($user);
        return $user;
    }

}
