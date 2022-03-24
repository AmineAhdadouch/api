<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
//    /**
//     * @Route("/api/product", name="app_product")
//     */
//    public function index(): Response
//    {
//       return $this->json([
//           'name' =>'pc',
//           'description' =>'pc_gamer',
//           'prix'=>1500]);
//    }
    /**
     * @Route("/api/product/new",name="app_product", methods={"POST"})
     */
    public function create(Request $request,EntityManagerInterface $em):Response
    {
        $product=new Product();
        $parametres=json_decode($request->getContent(),true);
        $product->setName($parametres['name']);
        $product->setDescription($parametres['description']);
        $product->setPrix($parametres['prix']);
        $em->persist($product);
        $em->flush();
        return $this->json('success');
    }
    /**
     * @Route("/api/product/update/{id}",name="product.update", methods={"PUT"})
     */
    public function Update(Request $request,EntityManagerInterface $em,$id,ProductRepository $repository):Response
    {
        $product=$repository->find($id);
        $parametres=json_decode($request->getContent(),true);
        $product->setName($parametres['name']);
        $product->setDescription($parametres['description']);
        $product->setPrix($parametres['prix']);
        $em->flush();
        return $this->json('success');
    }
    /**
     * @Route("/api/product/delete/{id}", name="product.delete")
     */
    public function delete(Request $request,ProductRepository $repo,$id): Response
    {
        $product=$repo->find($id);
        $repo->remove($product);
        return $this->json('success');
    }
    /**
     * @Route("/api/productshow", name="product.show")
     */
    public function product(ManagerRegistry $doctrine): Response
    {
        $product = $doctrine->getRepository(Product::class)->findAll();
        return $this->json($product);

    }



}
