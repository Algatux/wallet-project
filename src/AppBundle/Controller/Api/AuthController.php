<?php declare(strict_types=1);

namespace AppBundle\Controller\Api;

use AppBundle\Entity\RefreshToken;
use AppBundle\Model\ApiResponses\ApiResponse;
use AppBundle\Repository\RefreshTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/login", name="api_jwt_login" )
     * @Method({"POST"})
     *
     * @throws \Exception
     */
    public function loginAction()
    {
        throw new \Exception('No access here!');
    }

    public function refreshToken()
    {
        /** @var RefreshTokenRepository $repo */
        $repo = $this->entityManager->getRepository(RefreshToken::class);

        try {
            $token = $repo->getExistentValidTokenForUser($this->getUser());
        } catch ( NonUniqueResultException $e ) {
            throw new \LogicException('more than one tokens where found');
        }

        if ( !$token instanceof RefreshToken ) {
            $token = new RefreshToken();
            $token->setToken(Uuid::uuid4()->toString());

            $this->entityManager->persist($token);
            $this->entityManager->flush();
        }

        return new ApiResponse($token);
    }
}
