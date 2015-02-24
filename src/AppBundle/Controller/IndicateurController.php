<?php
/**
 * Created by PhpStorm.
 * User: delphinsagno
 * Date: 22/02/15
 * Time: 08:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Indicateur;
use AppBundle\Form\IndicateurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IndicateurController extends  ApiController {

    /**
     * @Route("/", name="homepage", options={"expose"=true})
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
    /**
     * @ApiDoc(
     *      description= "Cree un nouvel indicateur",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Donnees non valide"
     *      }
     *
     * )
     */
    public function postIndicateurAction(){
        $request = $this->get('request');
        $indicateur = $this->deserialize('AppBundle\Entity\Indicateur',$request);

        if($indicateur instanceof Indicateur === false){
            return $this->view(array('errors'=>$indicateur),400);
        }

        $em = $this->getEntityManager();
        $em->persist($indicateur);
        $em->flush();

        $url = $this->generateUrl('get_indicateur',array(),true);

        $response = new Response();
        $response->setStatusCode(201);
        $response->headers->set('Location', $url);

        return $response;

    }
    /**
     * @ApiDoc(
     *      description= "Liste des indicateurs"
     * )
     * @View
     * @Route(requirements={"_format"="json"})
     *
     */
    public function getIndicateursAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        $indicateurs = $em->getRepository("AppBundle:Indicateur")->findAll();

        return $this->view($indicateurs);
    }

    /**
     * @ApiDoc(
     *       description="Les details d'un indicateur",
     *      statusCodes={
     *           200="Operation reussie"
     *      }
     * )
     *
     * @View()
     * @ParamConverter("indicateur",class="AppBundle:Indicateur",options={"id"="id"})
     */
    public function getIndicateurAction(Indicateur $indicateur)
    {
        return array('indicateur' => $indicateur);
    }
} 