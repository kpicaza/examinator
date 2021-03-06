<?php

namespace Kpicaza\ExamBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExamController extends FOSRestController
{

    /**
     * 
     * @ApiDoc(
     *   description = "Get blog post.",
     *   statusCodes = {
     *     200 = "Return a JSON object with a blog post.",
     *     403 = "Authentication failure, user doesn’t have permission or API token is invalid or outdated.",
     *     400 = "Filtering data error, Returns array with the error causes"
     *   }
     * )
     * 
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param string     $id      Company id. Alphanumeric value. It must be a valid one (obtained by our system, for example, through the GET companies.json call).

     *
     * @return array
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getExamAction($id)
    {
        // $user = $this->getUser();
        $post = $this
            ->container
            ->get('app_rest_api.exam.handler')
            ->get($id)
        ;

        $view = $this->view($post);
        return $this->handleView($view);
    }

    /**
     * 
     * @ApiDoc(
     *   resource = true,
     *   description = "Get a filtered list of blog posts.",
     *   statusCodes = {
     *     200 = "Return a JSON object with a list of blog posts.",
     *     403 = "Authentication failure, user doesn’t have permission or API token is invalid or outdated.",
     *     400 = "Filtering data error, Returns array with the error causes"
     *   }
     * )
     * 
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @Annotations\QueryParam(name="limit", default="9", requirements="\d+", description="Maximum number of returned Companies up to 50.")
     * @Annotations\QueryParam(name="offset", default="0", requirements="\d+", description=" Number of ignored entries before the first result, ordered by creation date")
     * @Annotations\QueryParam(name="since", nullable=true, description="Filter results by created/updated datetime.")
     * @Annotations\QueryParam(name="keywords", nullable=true, description="Filter results by created/updated datetime.")
     * 
     * @return array
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getExamsAction(ParamFetcherInterface $paramFetcher)
    {
        // $user = $this->getUser(); findByForRest

        $posts = $this
            ->container
            ->get('app_rest_api.exam.handler')
            ->getList($paramFetcher->all())
        ;

        $view = $this->view($posts);
        return $this->handleView($view);
    }

}
