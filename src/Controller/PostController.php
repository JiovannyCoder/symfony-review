<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'post.')]

class PostController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        
        return $this->render('post/index.html.twig', [
            'title' => 'post',
            'posts' => $posts
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'title' => 'post',
            'post' => $post
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine) 
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();
            
            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/create.html.twig', [
            'title' => 'Create post',
            'form'=> $form->createView()
        ]);
    }
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, ManagerRegistry $doctrine, Post $post) 
    {
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $em = $doctrine->getManager();
            $em->flush();
            
            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/create.html.twig', [
            'title' => 'Create post',
            'form'=> $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine ,Post $post): Response
    {
        $em = $doctrine->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash(type: 'success', message: 'Post removed successfully');
        return $this->redirectToRoute('post.index');
    }
}
