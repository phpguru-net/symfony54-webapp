<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }


    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        // create new post with title
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            // handle file upload
            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachment'];
            if ($file) {
                $filename = sprintf("%s.%s",md5(uniqid()),$file->guessClientExtension());
                $uploads_dir = $this->getParameter('uploads_dir');
                // move tmp file to upload folder or somewhere
                $file->move(
                    $uploads_dir,
                    $filename
                );
                $post->setImage($filename);
            }

            // entity manager to persist data into database
            $entityManger = $doctrine->getManager();
            $entityManger->persist($post);
            $entityManger->flush();

            // // Set a flash message
            $this->addFlash(
                'success',
                "New post with id ={$post->getId()} created !"
            );
            return $this->redirect($this->generateUrl('post.index'));
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // /**
    //  * @Route("/show/{id}", name="show")
    //  */
    // public function show(string $id, PostRepository $postRepository): Response
    // {
    //     $post = $postRepository->find($id);
    //     return $this->render('post/show.html.twig', [
    //         'post' => $post
    //     ]);
    // }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Post $post, ManagerRegistry $doctrine): Response
    {
        $entityManger = $doctrine->getManager();
        $id = $post->getId();

        $entityManger->remove($post);
        $entityManger->flush();

        // Set a flash message
        $this->addFlash(
            'danger',
            "Post with id ={$id} removed !"
        );

        return $this->redirect($this->generateUrl('post.index'));
    }
}
