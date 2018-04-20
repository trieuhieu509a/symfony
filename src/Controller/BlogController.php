<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * @Route("/blog/{page}", name="blog_list", requirements={"page"="\d+"})
     */
    public function list($page = 1)
    {
        return $this->json(['id', $page]);
    }

    /**
     * @Route(
     *     "/articles/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function show($_locale, $year, $slug)
    {
        return $this->json([$_locale, $year, $slug]);
    }

    /**
     * @Route("/{_locale}", defaults={"_locale"="en"}, requirements={
     *     "_locale"="en|fr"
     * })
     */
    public function homepage($_locale)
    {
        return $this->json(['_locale', $_locale]);
    }

    public function contact($_locale){
        return $this->json(['_locale', $_locale]);
    }
    public function generatingUrl($slug){
        // /blog/my-blog-post
        $url = $this->generateUrl(
            'generating-url',
            array('slug' => 'my-blog-post')
        );
        //throw new \Exception('Something went wrong!');
        //throw $this->createNotFoundException();
        return $this->json(['$url', $url]);
        //return $this->redirectToRoute('contact', ['_locale' => 'es']);
    }

    public function session(Request $request, SessionInterface $session){

        /*echo $request->isXmlHttpRequest(); // is it an Ajax request?
        echo "<br/>";
        echo $request->getPreferredLanguage(array('en', 'fr'));
        echo "<br/>";
        // retrieves GET and POST variables respectively
        echo $request->query->get('page');
        echo $request->request->get('page');
        echo "<br/>";
        // retrieves SERVER variables
        echo $request->server->get('HTTP_HOST');
        echo "<br/>";
        // retrieves an instance of UploadedFile identified by foo
        echo $request->files->get('foo');
        echo "<br/>";
        // retrieves a COOKIE value
        echo $request->cookies->get('PHPSESSID');
        echo "<br/>";
        // retrieves an HTTP request header, with normalized, lowercase keys
        echo $request->headers->get('host');
        echo $request->headers->get('content_type');*/


        // creates a simple Response with a 200 status code (the default)
        $response = new Response('Hello '. 123, Response::HTTP_OK);

    // creates a CSS-response with a 200 status code
        $response = new Response('<style> ... </style>');
        $response->headers->set('Content-Type', 'text/css');



        // stores an attribute for reuse during a later user request
        $session->set('filters', 'bar');

        // gets the attribute set by another controller in another request
        $foobar = $session->get('foobar');

        // uses a default value if the attribute doesn't exist
        $filters = $session->get('filters', array());
        return $this->json(['$filters', $filters]);
        $this->file();
    }

}