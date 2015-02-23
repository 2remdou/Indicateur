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
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class IndicateurController extends  FOSRestController {
    /**
     * @ApiDoc(
     *      description= "Cree un nouvel indicateur",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Erreur lors de la creation"
     *      }
     *
     * )
     * @View
     * @Route(requirements={"_format"="json"})
     *
     */
    public function postIndicateurAction(){

        $indicateur = new Indicateur();
        $request = $this->get('request');
        $form = $this->createForm(new IndicateurType(), $indicateur);
        $form->handleRequest($request);

        if($form->isValid()){
            $statusCode = 201;
            $em = $this->getDoctrine()->getManager();

            $em->persist($indicateur);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            return $response;
        }
        return $this->view($form, 400);

    }

} 