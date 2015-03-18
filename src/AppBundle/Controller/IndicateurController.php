<?php
/**
 * Created by PhpStorm.
 * User: Toure
 * Date: 22/02/15
 * Time: 08:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Indicateur;
use AppBundle\Entity\Unite;
use AppBundle\Form\DetailIndicateurType;
use AppBundle\Form\IndicateurType;
use AppBundle\Entity\DetailIndicateur;
use AppBundle\Form\UniteType;
use AppBundle\Entity\TypeIndicateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IndicateurController extends  ApiController {

    private function processForm($objet,$objetType,$nameRoute=null){

        $form = $this->createForm($objetType,$objet);
        $request = $this->get('request');
        $form->submit($request);
        if($form->isValid()){
            $em = $this->getEntityManager();
            $em->persist($objet);
            $em->flush();

            $routeParam = array(
                'id' => $objet->getId(),
                '_format' => $request->get('_format'),
            );
            $response = new Response();
            $response->setStatusCode(Codes::HTTP_CREATED);
            if($nameRoute){

                $response->headers->set('Location',$this->generateUrl($nameRoute,$routeParam,true));
            }

            return $response;

        }
        return $this->view($form,Codes::HTTP_BAD_REQUEST);
    }
    private function wrapper($nameClass,$nameRoute){
        $request = $this->get('request');
        $objet=$this->deserialize($nameClass,$request);
        if($objet instanceof $nameClass ===false){
            return $this->view(array('errors'=>$objet),Codes::HTTP_BAD_REQUEST);
        }
        $method = $request->getMethod();
        if($method==="POST"){
            $statusCode = Codes::HTTP_CREATED;
        }
        else{
            $statusCode = Codes::HTTP_OK;
        }
        $em = $this->getEntityManager();
        $em->persist($objet);
        $em->flush();

        $routeParam = array(
            'id' => $objet->getId(),
            '_format' => $request->get('_format'),
        );
        $response = new Response();
        $response->setStatusCode(Codes::HTTP_CREATED);
        if($nameRoute){

            $response->headers->set('Location',$this->generateUrl($nameRoute,$routeParam,true));
        }
        return $this->view($response,$statusCode);


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
        return $this->view($unite);
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
        return $this->view($unites);
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
        return $this->wrapper('AppBundle\Entity\Unite','get_unite');

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
        return $this->processForm($unite,new UniteType(),'get_unite');

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
        return $this->processForm($unite,new UniteType(),'get_unite');

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
<<<<<<< HEAD
        return array('indicateur' => $indicateur);
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85
=======
        return $this->view($indicateur);
>>>>>>> 39efe10935051156a5133700d0369162b865a507
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
     * @Post("indicateurs/{typeIndicateur}")
     * @ParamConverter("typeIndicateur",class="AppBundle:TypeIndicateur")
     */
    public function postIndicateurAction(TypeIndicateur $typeIndicateur)
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
<<<<<<< HEAD
        return $this->processForm($indicateur,new IndicateurType(),array('AppBundle\Entity\TypeIndicateur'));
>>>>>>> 5f2827c1e2ae703d65f3535886744be7aae4ee85
=======
        $indicateur->setTypeIndicateur($typeIndicateur);
        return $this->processForm($indicateur,new IndicateurType(),'get_indicateur');
>>>>>>> 5cc51e559f7d061feabada8ac011b5fb73db728a
    }
    /**
     * @param TypeIndicateur $typeIndicateur
     * @param Indicateur $indicateur
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier un indicateur",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @Put("indicateurs/{typeIndicateur}/{indicateur}")
     * @ParamConverter("typeIndicateur",class="AppBundle:TypeIndicateur")
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @View()
     */
    public function  putIndicateurAction(TypeIndicateur $typeIndicateur,Indicateur $indicateur)
    {
        $em = $this->getEntityManager();
<<<<<<< HEAD
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
=======
        if($typeIndicateur !== $indicateur->getTypeIndicateur())
        {
            $indicateur->setTypeIndicateur($typeIndicateur);
        }
>>>>>>> 5cc51e559f7d061feabada8ac011b5fb73db728a

        return $this->processForm($indicateur,new IndicateurType(),'get_indicateur');
    }
    /**
     * @param Indicateur $indicateur
     * @ApiDoc(
     *      description="Supprime un indicateur",
     *      statusCodes={
     *               204="Suppression reussie"
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
     * @Get("details/{$id}")
     * @View()
     */
    public function getDetailIndicateurAction($id)
    {
        $em = $this->getEntityManager();
        $detail = $em->getRepository("AppBundle:DetailIndicateur")->find($id);
        return $this->view($detail);
    }

    /**
     *  @ApiDoc(
     *      description="Tous les details de tous les indicateurs",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @Get("details")
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
     * @Post("details/{unite}/{indicateur}")
     * @ParamConverter("unite",class="AppBundle:Unite")
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @View()
     */
    public function postDetailIndicateurAction(Unite $unite,Indicateur $indicateur)
    {
        $detail = new DetailIndicateur();
        $detail->setIndicateur($indicateur);
        $detail->setUnite($unite);
        return $this->processForm($detail,new DetailIndicateurType(),'get_detail_indicateur');
    }
    /**
     * @param Unite $unite
     * @param Indicateur $indicateur
     * @param DetailIndicateur $detailIndicateur
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier un indicateur",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @Put("details/{unite}/{indicateur}/{detailIndicateur}")
     * @ParamConverter("unite",class="AppBundle:Unite")
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @ParamConverter("detailIndicateur",class="AppBundle:DetailIndicateur")
     * @View()
     */
    public function putDetailIndicateurAction(Unite $unite,Indicateur $indicateur,DetailIndicateur $detailIndicateur)
    {
        if($detailIndicateur->getIndicateur() !== $indicateur)
            $detailIndicateur->setIndicateur($indicateur);
        if($detailIndicateur->getUnite() !== $unite)
            $detailIndicateur->setUnite($unite);

        return $this->processForm($detailIndicateur,new DetailIndicateurType(),'get_detail_indicateur');
    }
    /**
     * @param Unite $unite
     * @param Indicateur $indicateur
     * @param DetailIndicateur $detailIndicateur
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier un indicateur",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @Patch("details/{unite}/{indicateur}/{detailIndicateur}")
     * @ParamConverter("unite",class="AppBundle:Unite")
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @ParamConverter("detailIndicateur",class="AppBundle:DetailIndicateur")
     * @View()
     */
    public function patchDetailIndicateurAction(Unite $unite,Indicateur $indicateur,DetailIndicateur $detailIndicateur)
    {
        if($detailIndicateur->getIndicateur() !== $indicateur)
            $detailIndicateur->setIndicateur($indicateur);
        if($detailIndicateur->getUnite() !== $unite)
            $detailIndicateur->setUnite($unite);

        return $this->processForm($detailIndicateur,new DetailIndicateurType(),'get_detail_indicateur');
    }
    /**
     * @param DetailIndicateur $detailIndicateur
     * @ApiDoc(
     *      description="Supprime un detail",
     *      statusCodes={
     *               204="Suppression reussie"
     *      }
     * )
     * @ParamConverter("detailIndicateur",class="AppBundle:DetailIndicateur")
     * @View(statusCode=204)
     * @Delete("details/{detailIndicateur}")
     */
    public function deleteDetailIndicateurAction(DetailIndicateur $detailIndicateur)
    {
        $em = $this->getEntityManager();
        $em->remove($detailIndicateur);
        $em->flush();
    }
}
