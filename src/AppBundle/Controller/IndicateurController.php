<?php
/**
 * Created by PhpStorm.
 * User: delphinsagno
 * Date: 22/02/15
 * Time: 08:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Indicateur;
use AppBundle\Entity\Unite;
use AppBundle\Form\IndicateurType;
use AppBundle\Entity\DetailIndicateur;
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
     * @return Response
     *  @ApiDoc(
     *      description= "Cree une nouvelle unite",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Donnees non valide"
     *      }
     *
     * )
     * @View()
     */
    public function postUniteAction()
    {
        $request = $this->get('request');
        $unite = $this->deserialize('AppBundle\Entity\Unite',$request);
        if($unite instanceof Unite === false){
            return $this->view(array('errors'=>$unite),400);
        }
        $em = $this->getEntityManager();
        $em->persist($unite);
        $em->flush();
        $url = $this->generateUrl('get_unites',
            array(),
            true).'/'.$unite->getId();
        $response = new Response();
        $response->setStatusCode(201);
        $response->headers->set('Location',$url);

        return $response;
    }

    /**
     * @param Unite $unite
     * @return array
     * @ApiDoc(
     *      description="Detail d'une unite",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @View()
     */
    public function getUniteAction(Unite $unite)
    {
        return array('unite' => $unite);
    }

    /**
     * @ApiDoc(
     *      description= "Liste des unites",
     *      statusCodes={
     *         200="Operation reussie",
     *      }
     * )
     * @View
     *
     */
    public function getUnitesAction()
    {
        $em = $this->getEntityManager();
        $unites = $em->getRepository("AppBundle:Unite")->findAll();
        return array('unites'=>$unites);
    }

    /**
     * @param Unite $unite
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier une unite",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @ParamConverter("unite",class="AppBundle:Unite")
     */
    public function  putUniteAction(Unite $unite)
    {
        $request = $this->get('request');
        $em = $this->getEntityManager();
        $newUnite = $this->deserialize('\AppBundle\Entity\Unite',$request);
        if($newUnite instanceof Unite === false){
            return $this->view(array('errors'=>$newUnite),400);
        }
        $unite->update($newUnite);
        $em->flush();

        return array('indicateur' => $unite);

    }
    /**
     * @param Unite $unite
     * @ApiDoc(
     *      description="Supprime une unite",
     *      statusCodes={
     *       204="Suppression reussie"
     *      }
     * )
     * @ParamConverter("unite",class="AppBundle:Unite")
     * @View(statusCode=204)
     */
    public function deleteUniteAction(Unite $unite)
    {
        $em = $this->getEntityManager();
        $em->remove($unite);
        $em->flush();

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
     * @View()
     */
    public function postIndicateurAction(){
        $request = $this->get('request');
        $indicateur = $this->deserialize('AppBundle\Entity\Indicateur',$request);
        $typeIndicateur = $this->deserialize('AppBundle\Entity\TypeIndicateur',$request);
        if($indicateur instanceof Indicateur === false){
            return $this->view(array('errors'=>$indicateur),400);
        }

            $em = $this->getEntityManager();
            $em->persist($indicateur);
            $em->flush();

            $url = $this->generateUrl('get_indicateurs',
                    array(),
                    true).'/'.$indicateur->getId();
            $response = new Response($typeIndicateur->getLibelleTypeIndicateur());
            $response->setStatusCode(201);
            $response->headers->set('Location', $url);

//            return $response;
          return $typeIndicateur;

    }
    /**
     * @ApiDoc(
     *      description= "Liste des indicateurs",
     *      statusCodes={
     *         200="Operation reussie",
     *      }
     * )
     * @View
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
     *       description="Les informations d'un indicateur",
     *      statusCodes={
     *          200="Operation reussie",
     *          400="Donnees invalide",
     *          403="Forbidden"
     *      }
     * )
     *
     * @View()
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     */
    public function getIndicateurAction(Indicateur $indicateur)
    {
        return array('indicateur' => $indicateur);
    }

    /**
     * @param Indicateur $indicateur
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
    *           description="Modifier un indicateur",
    *           statusCodes={
    *               200="Modification reussie",
    *               400="Donnees invalide"
    *           }
    *   )
    * @ParamConverter("indicateur",class="AppBundle:Indicateur")
    */
    public function  putIndicateurAction(Indicateur $indicateur)
    {
        $request = $this->get('request');
        $em = $this->getEntityManager();
        $newIndicateur = $this->deserialize('\AppBundle\Entity\Indicateur',$request);
        if($newIndicateur instanceof Indicateur === false){
            return $this->view(array('errors'=>$newIndicateur),400);
        }
        $indicateur->update($newIndicateur);
        $em->flush();

        return array('indicateur' => $indicateur);

    }

    /**
     * @param Indicateur $indicateur
     * @ApiDoc(
     *      description="Supprime un indicateur",
     *      statusCodes={
                204="Suppression reussie"
     *      }
     * )
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @View(statusCode=204)
     */
    public function deleteIndicateurAction(Indicateur $indicateur)
    {
        $em = $this->getEntityManager();
        $em->remove($indicateur);
        $em->flush();

    }

    /**
     * @param DetailIndicateur $detailIndicateur
     * @return array
     *  @ApiDoc(
     *      description="Detail d'un indicateur",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @ParamConverter("detailIndicateur",class="AppBundle:DetailIndicateur")
     * @View()
     */
    public function getDetailIndicateurAction(DetailIndicateur $detailIndicateur)
    {
        return array('detailIndicateur' => $detailIndicateur);
    }

    /**
     *  @ApiDoc(
     *      description="Tous les details de tous les indicateurs",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )

     */
    public function getDetailIndicateursAction()
    {
        $em = $this->getEntityManager();
        $details = $em->getRepository("AppBundle:DetailIndicateur")->findAll();
        $this->view($details,200);

    }

    /**
     * @ApiDoc(
     *      description= "Cree un detail d'un indicateur",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Donnees non valide"
     *      }
     *
     * )
     * @View()
     */
    public function postDetailIndicateurAction()
    {
        $request = $this->get('request');

        $detailIndicateur = $this->deserialize("\AppBundle\Entity\DetailIndicateur",$request);
        if($detailIndicateur instanceof DetailIndicateur === false){
            return $this->view(array('errors'=>$detailIndicateur),400);
        }

        $em = $this->getEntityManager();
        $em->persist($detailIndicateur);
        $em->flush();

        $url = $this->generateUrl('get_detail_indicateurs',
            array(),
            true).'/'.$detailIndicateur->getId();

        $response = new Response();
        $response->setStatusCode(201);
        $response->headers->set('Location',$url);
    }

    /**
     * @param DetailIndicateur $detailIndicateur
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier le detail d'un indicateur",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @ParamConverter("detailIndicateur",class="AppBundle:DetailIndicateur")
     * @View()
     */
    public function putDetailIndicateur(DetailIndicateur $detailIndicateur)
    {
        $request = $this->get('request');
        $newDetail = $this->deserialize("\AppBundle\Entity\DetailIndicateur",$request);
        if($newDetail instanceof DetailIndicateur === false){
            return $this->view(array('errors'=>$newDetail),400);
        }

        $detailIndicateur->update($newDetail);

        $this->getEntityManager()->flush();
        return array('detailIndicateur' => $detailIndicateur);
    }

    /**
     * @param DetailIndicateur $detailIndicateur
     * @ApiDoc(
     *      description="Supprime le detail d'un indicateur",
     *      statusCodes={
     *          204="Suppression reussie"
     *      }
     * )
     * @ParamConverter("detailIndicateur",class="AppBundle:DetailIndicateur")
     * @View(statusCode=204)
     */
    public function deleteDetailIndicateurAction(DetailIndicateur $detailIndicateur)
    {
        $em = $this->getEntityManager();
        $em->remove($detailIndicateur);
        $em->flush();
    }

    /**
     * @param Indicateur $indicateur
     * @return array
     * @ApiDoc(
     *      description= "Les details d'un indicateur",
     *      statusCodes={
     *         200="Operation reussie",
     *      }
     * )
     * @View()
     *
     */
    public function getInfoindicateurAction(Indicateur $indicateur)
    {
        $em = $this->getEntityManager();
        $details = $em->getRepository("AppBundle:DetailIndicateur")->findByIndicateur($indicateur->getId());
        return array('detailIndicateur' => $details);
    }
} 