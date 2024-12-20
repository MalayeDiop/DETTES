<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Enums\ArticleRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('api/articles', name: 'api_articles_list', methods: ['GET'])]
    public function listArticles(Request $request, ArticleRepository $articleRepository): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 5);
        
        $criteria = [
            'libelle' => $request->query->get('libelle'),
        ];

        $articlesPaginator = $articleRepository->findArticleBy($criteria, $page, $limit);

        $articles = [];
        foreach ($articlesPaginator as $article) {
            $articles[] = [
                'id' => $article->getId(),
                'ref' => $article->getRef(),
                'libelle' => $article->getLibelle(),
                'qte_stock' => $article->getQteStock(),
                'prix_unitaire' => $article->getPrixUnitaire(),
            ];
        }

        return $this->json($articles);
    }

    #[Route('/api/users/{id}', name: 'api_users_get', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'create_at' => $user->getCreateAt()->format('Y-m-d H:i:s'),
            'is_blocked' => $user->isBlocked(),
        ]);
    }

    #[Route('api/users/search', name: 'api_users_search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $email = $request->query->get('email');
        if (!$email) {
            return $this->json(['error' => 'Email is required'], 400);
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'create_at' => $user->getCreateAt()->format('Y-m-d H:i:s'),
            'is_blocked' => $user->isBlocked(),
        ]);
    }

    #[Route('api/users', name: 'api_users_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation des champs requis
        if (empty($data['email']) || empty($data['password'])) {
            return $this->json(['error' => 'Les champs email et password sont requis'], 400);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $user->setCreateAt(new \DateTimeImmutable());
        $user->setUpdateAt(new \DateTimeImmutable());
        $user->setBlocked(false); // Par défaut, l'utilisateur n'est pas bloqué

        try {
            $this->userRepository->save($user);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erreur lors de la création de l\'utilisateur : ' . $e->getMessage()], 500);
        }

        return $this->json(['message' => 'Utilisateur créé avec succès'], 201);
    }

    #[Route('api/users/edit/{id}', name: 'api_users_edit', methods: ['PATCH'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        // Mise à jour des champs
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['password'])) {
            $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        }
        if (isset($data['is_blocked'])) {
            $user->setBlocked($data['is_blocked']);
        }

        try {
            $this->userRepository->save($user);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erreur lors de la mise à jour de l\'utilisateur : ' . $e->getMessage()], 500);
        }

        return $this->json(['message' => 'Utilisateur mis à jour avec succès']);
    }
}
