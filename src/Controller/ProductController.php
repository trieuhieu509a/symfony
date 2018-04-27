<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);

        // look for a single Product by its primary key (usually "id")
        $product = $repository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        // look for a single Product by name
        $product = $repository->findOneBy(['name' => 'Keyboard']);
        // or find by name and price
        $product = $repository->findOneBy([
            'name' => 'Keyboard',
            'price' => 19.99,
        ]);

        // look for multiple Product objects matching the name, ordered by price
        $products = $repository->findBy(
            ['name' => 'Keyboard'],
            ['price' => 'ASC']
        );

        // look for *all* Product objects
        $products = $repository->findAll();

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/product1/{id}", name="product_show1")
     */
    public function showAction1(Product $product)
    {
        // use the Product!
        // ...
    }

    /**
     * @Route("/product/edit/{id}")
     */
    public function updateAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);


        //eleting an Object
        //$entityManager->remove($product);
        //$entityManager->flush();


        // from inside a controller
        $minPrice = 10;

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllGreaterThanPrice($minPrice);
    }

    /**
     * @Route("/router")
     */
    public function getContainer()
    {
        $request = Request::createFromGlobals();

        // the URI being requested (e.g. /about) minus any query parameters
        $request->getPathInfo();

        // retrieves $_GET and $_POST variables respectively
        $request->query->get('id');
        $request->request->get('category', 'default category');

        // retrieves $_SERVER variables
        $request->server->get('HTTP_HOST');

        // retrieves an instance of UploadedFile identified by "attachment"
        $request->files->get('attachment');

        // retrieves a $_COOKIE value
        $request->cookies->get('PHPSESSID');

        // retrieves an HTTP request header, with normalized, lowercase keys
        $request->headers->get('host');
        $request->headers->get('content_type');

        $request->getMethod();    // e.g. GET, POST, PUT, DELETE or HEAD
        $request->getLanguages(); // an array of languages the client accepts

        return $this->json([$request->getLanguages(), $request->isSecure()]);
    }

    /**
     * @Route("/respone")
     */
    public function respone()
    {
        $response = new Response();

        $response->setContent('<html><body><h1>Hello world!</h1></body></html>');
        $response->setStatusCode(Response::HTTP_OK);

        // sets a HTTP response header
        $response->headers->set('Content-Type', 'text/html');

        // prints the HTTP headers followed by the content
        $response->send();
        return $response;
    }
}
