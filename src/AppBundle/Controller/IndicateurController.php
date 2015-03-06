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
use AppBundle\Form\UniteType;
use AppBundle\Entity\TypeIndicateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IndicateurController extends  ApiController {

    /*private function processFormUnite(Unite $unite){

        $form = $this->createForm(new UniteType(),$unite);
        $request = $this->get('request');
        $form->submit($request);
        if($form->isValid()){
            $em = $this->getEntityManager();
            $em->persist($unite);
            $em->flush();

            $routeParam = array(
                'id' => $unite->getId(),
                '_format' => $request->get('_format'),
            );
            $response = new Response();
            $response->setStatusCode(Codes::HTTP_CREATED);
            $response->headers->set('Location',$this->generateUrl('get_unite',$routeParam,true));

            return $response;
        }
        return $this->view($form,Codes::HTTP_BAD_REQUEST);
    }*/
    private function processForm($objet,$objetType,array $classDependences=null){

        $form = $this->createForm($objetType,$objet);
        $request = $this->get('request');
        $form->submit($request);
        if($form->isValid()){
            $em = $this->getEntityManager();
            $objet=$form->getData();

           // $objet=$this->manageDependence($objet,$classDependences);

            /*$em->refresh($objet);
            $em->flush();*/

          /*  $routeParam = array(
                'id' => $objet->getId(),
                '_format' => $request->get('_format'),
            );*/
            $response = new Response();
            $response->setStatusCode(Codes::HTTP_CREATED);
//            $response->headers->set('Location',$this->generateUrl('get_unite',$routeParam,true));

//            return $response;
            return $objet;

        }
        return $this->view($form,Codes::HTTP_BAD_REQUEST);
    }

    /**
     * Pour la gestion des relations
     * @param $objet
     * @param array $nameClassDependences liste des dependance
     * @return mixed
     */
    private function manageDependence($objet,array $nameClassDependences=null){
        if($nameClassDependences === null)
            return $objet;
        $em = $this->getEntityManager();
        foreach($nameClassDependences as $nameClassDependence){
            $class=substr($nameClassDependence,strrpos($nameClassDependence,"\\")+1);

            $dependence = call_user_func(array($objet,'get'.$class));
            if($dependence ){
                $libelle=call_user_func(array($dependence,'getLibelle'.$class));
                $objetDependence = $em->getRepository("AppBundle:".$class)
                    ->findOneBy(array("libelle".$class=>$libelle));
                if($objetDependence instanceof $nameClassDependence){
                    call_user_func(array($objet,'set'.$class),$objetDependence);
                }
                return $objet;

            }

        }
        return $objet;
    }

    /**
     * @Route("/", name="homepage", options={"expose"=true})
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
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
    public function getUniteAction($id)
    {
        $em = $this->getEntityManager();
        $unite = $em->getRepository("AppBundle:Unite")->find($id);
        return array('unite' => $unite);
    }

    /**
     * @ApiDoc(
     *      description= "Liste des unites",
     *      statusCodes={
     *         200="Operation reussie",
     *      }
     * )
     * @View()
     *
     */
    public function getUnitesAction()
    {
        $em = $this->getEntityManager();
        $unites = $em->getRepository("AppBundle:Unite")->findAll();
        return array('unites'=>$unites);
    }

    /**
     * {
     *       "unite":
     *       {
     *       "codeUnite": "Ko",
     *       "libelleUnite":"Kilo Octet"
     *       }
     * }
     * @return Response
     *  @ApiDoc(
     *      description= "Cree une nouvelle unite",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Donnees non valide"
     *      }
     *
     * )
     * @View(
     *      template="AppBundle:Post:postUnite.html.twig",
     *      statusCode = Codes::HTTP_BAD_REQUEST,
     *      templateVar="form"
     * )
     */
    public function postUniteAction()
    {
        $unite = new Unite();
        return $this->processForm($unite,new UniteType());
    }
    /**
     * {
     *       "unite":
     *       {
     *       "codeUnite": "Ko",
     *       "libelleUnite":"Kilo Octet"
     *       }
     * }
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
        return $this->processForm($unite,new UniteType());

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
    public function  patchUniteAction(Unite $unite)
    {
        $request = $this->get('request');
        $em = $this->getEntityManager();
        return $this->processForm($unite,new UniteType());

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
<<<<<<< HEAD

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
        $indicateur = $this->deserialize('AppBundle\Entity\Indicateur',$request,$request->getRequestFormat(),array('registration'));
        if($indicateur instanceof Indicateur === false){
            return $this->view(array('errors'=>$indicateur),400);
        }

            $em = $this->getEntityManager();
            $em->persist($indicateur);
            $em->flush();

            $url = $this->generateUrl('get_indicateurs',
                    array(),
                    true).'/'.$indicateur->getId();
            $response = new Response();
            $response->setStatusCode(201);
            $response->headers->set('Location', $url);

            return $response;


    }
=======
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85
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
     *          404="Aucun indicateur"
     *      }
     * )
     *
     * @View()
     */
<<<<<<< HEAD
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
=======
    public function getIndicateurAction($id)
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85
    {
        $em = $this->getEntityManager();
<<<<<<< HEAD
        $newIndicateur = $this->deserialize('AppBundle\Entity\Indicateur',$request);
        $typeIndicateur = $this->deserialize('AppBundle\Entity\TypeIndicateur',$request);
/*        if($newIndicateur instanceof Indicateur === false){
            return $this->view(array('errors'=>$newIndicateur),400);
        }
        $newIndicateur->setTypeIndicateur($typeIndicateur);
        $indicateur->update($newIndicateur);
        $em->flush();*/
        return array('indicateur' => $typeIndicateur);
=======
        $indicateur = $em->getRepository("AppBundle:Indicateur")->find($id);
        if($indicateur===null) {
            return $this->view(array(),Codes::HTTP_NO_CONTENT);
        }
        return array('indicateur' => $indicateur);
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85
    }
    /**
     *
     * {
     *      "libelleIndicateur": "Espace FS",
     *      "indicateur":
     *      {
     *          "typeIndicateur":
     *          {
     *              "libelleTypeIndicateur": "Base de donnees"
     *          }
     *      }
     * }
     * @return Response
     *  @ApiDoc(
     *      description= "Cree un nouvel indicateur",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Donnees non valide"
     *      }
     *
     * )
     * @View(
     *      template="AppBundle:Post:postIndicateur.html.twig",
     *      statusCode = Codes::HTTP_BAD_REQUEST,
     *      templateVar="form"
     * )
     */
    public function postIndicateurAction()
    {
<<<<<<< HEAD
        $request = $this->get('request');

        $detailIndicateur = $this->deserialize("AppBundle\Entity\DetailIndicateur",$request);
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
=======
        $indicateur = new Indicateur();
        return $this->processForm($indicateur,new IndicateurType(),array('AppBundle\Entity\TypeIndicateur'));
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85
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
     * @View
     */
    public function  putIndicateurAction(Indicateur $indicateur)
    {
        $em = $this->getEntityManager();
        $request = $this->get('request');
<<<<<<< HEAD
        $newDetail = $this->deserialize("AppBundle\Entity\DetailIndicateur",$request);
        if($newDetail instanceof DetailIndicateur === false){
            return $this->view(array('errors'=>$newDetail),400);
        }

        $detailIndicateur->update($newDetail);
=======
        $newIndicateur = new Indicateur();
        $newIndicateur= $this->processForm($newIndicateur,new IndicateurType(),array('AppBundle\Entity\TypeIndicateur'));
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85

        $indicateur->setTypeIndicateur($newIndicateur->getTypeIndicateur());
        $em->refresh($indicateur);
            $em->flush();
        $routeParam = array(
            'id' => $indicateur->getId(),
            '_format' => $request->get('_format'),
        );
        $response = new Response();
        $response->setStatusCode(Codes::HTTP_CREATED);
            $response->headers->set('Location',$this->generateUrl('get_indicateur',$routeParam,true));

           return $response;
    }

}
