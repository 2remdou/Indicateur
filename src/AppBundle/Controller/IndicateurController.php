<?php
/**
 * Created by PhpStorm.
 * User: Toure
 * Date: 22/02/15
 * Time: 08:04
 */
namespace AppBundle\Controller;
use AppBundle\Entity\Hote;
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
    private function wrapper($nameClass){
        $request = $this->get('request');
        $objet=$this->deserialize($nameClass,$request);
        return $objet;

    }
    private function save($objet,$route){
        $request = $this->get('request');
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
        /*try{
            $em->persist($objet);
            $em->flush();
        }catch (\Exception $e){
            $error = array(
                "type" => "info",
                "message"  => "J'ai encore cassé l'application, veuillez contacter l'Admin"
            );
            return $this->view(array('errors'=>$error),Codes::HTTP_BAD_REQUEST);
        }*/


        $routeParam = array(
            'id' => $objet->getId(),
            '_format' => $request->get('_format'),
        );
        $response = new Response();
        $response->setStatusCode(Codes::HTTP_CREATED);
        if($route){
            $response->headers->set('Location',$this->generateUrl($route,$routeParam,true));
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
     * 	"codeUnite": "To",
     * 	"libelleUnite": "Tera Octet"
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
        $request = $this->get('request');
        $unite = $this->deserialize('AppBundle\Entity\Unite',$request,'json',array('create','common'));
        if($unite instanceof Unite ===false){
            return $this->view(array('errors'=>$unite),Codes::HTTP_BAD_REQUEST);
        }
        return $this->save($unite,'get_unite') ;
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
        $newUnite = $this->deserialize('AppBundle\Entity\Unite',$request,'json',array('common'));
        if($newUnite instanceof Unite ===false){
            return $this->view(array('errors'=>$newUnite),Codes::HTTP_BAD_REQUEST);
        }
        $unite->update($newUnite);
        return $this->save($unite,'get_unite');
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
     * @param $id
     * @return array
     * @ApiDoc(
     *      description="Detail d'un hote",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @View()
     */
    public function getHoteAction($id)
    {
        $em = $this->getEntityManager();
        $hote = $em->getRepository("AppBundle:Hote")->find($id);
        return $this->view($hote);
    }
    /**
     * @ApiDoc(
     *      description= "Liste des hotes",
     *      statusCodes={
     *         200="Operation reussie",
     *      }
     * )
     * @View()
     *
     */
    public function getHotesAction()
    {
        $em = $this->getEntityManager();
        $hotes = $em->getRepository("AppBundle:Hote")->findAll();
        return $this->view($hotes);
    }
    /**
     * {
     * 	"adresseHote": "10.10.0.16",
     * 	"libelleHote": "Serveur de developpement"
     * }
     * @return Response
     *  @ApiDoc(
     *      description= "Cree un nouvel hote",
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
    public function postHoteAction()
    {
        $request = $this->get('request');
        $hote = $this->deserialize('AppBundle\Entity\Hote',$request,'json',array('create','common'));
        if($hote instanceof Hote ===false){
            return $this->view(array('errors'=>$hote),Codes::HTTP_BAD_REQUEST);
        }
        return $this->save($hote,'get_unite') ;
    }
    /**
     * @param Hote $hote
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier une unite",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @ParamConverter("hote",class="AppBundle:Hote")
     */
    public function  putHoteAction(Hote $hote)
    {
        $request = $this->get('request');
        $newHote = $this->deserialize('AppBundle\Entity\Hote',$request,'json',array('common'));
        if($newHote instanceof Hote ===false){
            return $this->view(array('errors'=>$newHote),Codes::HTTP_BAD_REQUEST);
        }
        $hote->update($newHote);
        return $this->save($hote,'get_unite');
    }
    /**
     * @param Hote $hote
     * @ApiDoc(
     *      description="Supprime un hote",
     *      statusCodes={
     *       204="Suppression reussie"
     *      }
     * )
     * @ParamConverter("hote",class="AppBundle:Hote")
     * @View(statusCode=204)
     */
    public function deleteHoteAction(Hote $hote)
    {
        $em = $this->getEntityManager();
        $em->remove($hote);
        $em->flush();
    }


    /**
     * @param TypeIndicateur $typeIndicateur
     * @return array
     * @ApiDoc(
     *      description="Detail d'un type indicateur",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @Get("type-indicateur/{$id}")
     * @View()
     */
    public function getTypeIndicateurAction($id)
    {
        $em = $this->getEntityManager();
        $typeIndicateur = $em->getRepository("AppBundle:TypeIndicateur")->find($id);
        return $this->view($typeIndicateur);
    }
    /**
     * @ApiDoc(
     *      description= "Liste type indicateur",
     *      statusCodes={
     *         200="Operation reussie",
     *      }
     * )
     * @Get("type-indicateurs")
     * @View()
     *
     */
    public function getTypeIndicateursAction()
    {
        $em = $this->getEntityManager();
        $typeIndicateurs = $em->getRepository("AppBundle:TypeIndicateur")->findAll();
        return $this->view($typeIndicateurs);
    }
    /**
     * {
     * 	"libelleTypeIndicateur": "Base de donnees",
     * }
     * }
     * @return Response
     *  @ApiDoc(
     *      description= "Cree un nouvel type indicateur",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Donnees non valide"
     *      }
     *
     * )
     * @View()
     * @Post("type-indicateurs")
     */
    public function postTypeIndicateurAction()
    {
        $request = $this->get('request');
        $typeIndicateur = $this->deserialize('AppBundle\Entity\TypeIndicateur',$request,'json',array('create','common'));
        if($typeIndicateur instanceof TypeIndicateur ===false){
            return $this->view(array('errors'=>$typeIndicateur),Codes::HTTP_BAD_REQUEST);
        }
        return $this->save($typeIndicateur,'get_type_indicateur') ;
    }
    /**
     * {
     *       "unite":
     *       {
     *       "codeUnite": "Ko",
     *       "libelleUnite":"Kilo Octet"
     *       }
     * }
     * @param TypeIndicateur $typeIndicateur
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier un type indicateur",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @Put("type-indicateurs/{typeIndicateur}")
     * @ParamConverter("typeIndicateur",class="AppBundle:TypeIndicateur")
     *
     */
    public function  putTypeIndicateurAction(TypeIndicateur $typeIndicateur)
    {
        $request = $this->get('request');
        $newTypeIndicateur = $this->deserialize('AppBundle\Entity\TypeIndicateur',$request,'json',array('common'));
        if($newTypeIndicateur instanceof TypeIndicateur ===false){
            return $this->view(array('errors'=>$newTypeIndicateur),Codes::HTTP_BAD_REQUEST);
        }
        $typeIndicateur->update($newTypeIndicateur);
        return $this->save($typeIndicateur,'get_type_indicateur');
    }
    /**
     * @param TypeIndicateur $typeIndicateur
     * @ApiDoc(
     *      description="Supprime un type indicateur",
     *      statusCodes={
     *       204="Suppression reussie"
     *      }
     * )
     * @ParamConverter("typeIndicateur",class="AppBundle:TypeIndicateur")
     * @View(statusCode=204)
     * @Delete("type-indicateurs/{typeIndicateur}")
     */
    public function deleteTypeIndicateurAction(TypeIndicateur $typeIndicateur)
    {
        $em = $this->getEntityManager();
        $em->remove($typeIndicateur);
        $em->flush();
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
        $indicateurs = $em->getRepository("AppBundle:Indicateur")->all();
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
    public function getIndicateurAction($id)
    {
        $em = $this->getEntityManager();
        $indicateur = $em->getRepository("AppBundle:Indicateur")->find($id);
        if($indicateur===null) {
            return $this->view(array(),Codes::HTTP_NO_CONTENT);
        }
        return $this->view($indicateur);
    }
    /**
     *
     * http://10.10.201.29/indicateur/app_dev.php/type-indicateurs/3/indicateurs
     *{
     *	"libelleIndicateur": "/",
     *	"hotes":
     *	[
     *		{
     *			"id": 1
     *		},
     *		{
     *			"id":2
     *		},
     *		{
     *			"id":3
     *		}
     *
     *	]
     *}
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
     * @Post("type-indicateurs/{typeIndicateur}/unites/{unite}/indicateurs")
     * @ParamConverter("typeIndicateur",class="AppBundle:TypeIndicateur")
     * @ParamConverter("unite",class="AppBundle:Unite")
     */
    public function postIndicateurAction(TypeIndicateur $typeIndicateur,Unite $unite)
    {
        $request = $this->get('request');
        $em = $this->getEntityManager();
        $indicateur = $this->deserialize('AppBundle\Entity\Indicateur',$request,'json',array('common'));
        if($indicateur instanceof Indicateur ===false){
            return $this->view(array('errors'=>$indicateur),Codes::HTTP_BAD_REQUEST);
        }
        $indicateur->setTypeIndicateur($typeIndicateur);
        $indicateur->setUnite($unite);
        foreach($indicateur->getHotes() as $hote){
            $indicateur->removeHote($hote);
            $indicateur->addHote($em->getRepository("AppBundle:Hote")->find($hote->getId()));
        }
        return $this->save($indicateur,'get_indicateur');

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
     * @Put("indicateurs/{indicateur}")
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @View()
     */
    public function  putIndicateurAction(Indicateur $indicateur)
    {
        $request = $this->get('request');
        $newIndicateur = $this->deserialize('AppBundle\Entity\Indicateur',$request,'json',array('common'));
        if($newIndicateur instanceof Indicateur ===false){
            return $this->view(array('errors'=>$newIndicateur),Codes::HTTP_BAD_REQUEST);
        }
        $em = $this->getEntityManager();
        $newIndicateur->setTypeIndicateur($em->getRepository("AppBundle:TypeIndicateur")->find($newIndicateur->getTypeIndicateur()->getId()));
        $newIndicateur->setUnite($em->getRepository("AppBundle:Unite")->find($newIndicateur->getUnite()->getId()));
        foreach($newIndicateur->getHotes() as $hote){
            $newIndicateur->removeHote($hote);
            $newIndicateur->addHote($em->getRepository("AppBundle:Hote")->find($hote->getId()));
        }
        $indicateur->update($newIndicateur);
        return $this->save($indicateur,'get_indicateur');
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
     * @Get("details/{id}")
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
        return $this->view($details);
    }

    /**
     *  @ApiDoc(
     *      description="Tous les details d'un  indicateur",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @Get("indicateurs/{indicateur}/details")
     */
    public function getDetailByIndicateursAction(Indicateur $indicateur)
    {
        $em = $this->getEntityManager();
        $details = $em->getRepository("AppBundle:DetailIndicateur")->findByIndicateur($indicateur->getId());
        return $this->view($details);
    }

    /**
     *  @ApiDoc(
     *      description="Tous les details d'une  unite",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @ParamConverter("unite",class="AppBundle:Unite")
     * @Get("unites/{unite}/details")
     */
    public function getDetailByUnitesAction(Unite $unite)
    {
        $em = $this->getEntityManager();
        $details = $em->getRepository("AppBundle:DetailIndicateur")->findByUnite($unite->getId());
        return $this->view($details);
    }

    /**
     *  @ApiDoc(
     *      description="Tous les details correspondant à une unite et à un indicateur",
     *      statusCodes={
     *          200="Operation reussie",
     *  }
     * )
     * @ParamConverter("unite",class="AppBundle:Unite")
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @Get("unites/{unite}/indicateurs/{indicateur}/details")
     */
    public function getDetailByUniteAndByIndicateurAction(Unite $unite,Indicateur $indicateur)
    {
        $em = $this->getEntityManager();
        $details = $em->getRepository("AppBundle:DetailIndicateur")->findByUniteAndIndicateur($unite->getId(),$indicateur->getId());
        return $this->view($details);
    }



    /**
     * http://10.10.201.29/indicateur/app_dev.php/unites/2/indicateurs/1/details
     *
     *{
     *	"dateDetail": "2014-12-13 12:42:48",
     *	"valeur": 100
     *}
     * @ApiDoc(
     *      description= "Cree un detail d'un indicateur",
     *      statusCodes={
     *          200="Creation reussie",
     *          400="Donnees non valide"
     *      }
     *
     * )
     * @Post("indicateurs/{indicateur}/details")
     * @ParamConverter("indicateur",class="AppBundle:Indicateur")
     * @View()
     */
    public function postDetailIndicateurAction(Indicateur $indicateur)
    {
        $request = $this->get('request');
        $detail = $this->deserialize('AppBundle\Entity\DetailIndicateur',$request,'json',array('create','common'));
        if($detail instanceof DetailIndicateur ===false){
            return $this->view(array('errors'=>$detail),Codes::HTTP_BAD_REQUEST);
        }
        $detail->setIndicateur($indicateur);
        return $this->save($detail,'get_indicateur') ;

        return $this->processForm($detail,new DetailIndicateurType(),'get_detail_indicateur');
    }
    /**
     * @param DetailIndicateur $detailIndicateur
     * @return array|\FOS\RestBundle\View\View
     * @ApiDoc(
     *           description="Modifier un detail",
     *           statusCodes={
     *               200="Modification reussie",
     *               400="Donnees invalide"
     *           }
     *   )
     * @Put("details/{detailIndicateur}")
     * @ParamConverter("detail",class="AppBundle:DetailIndicateur")
     * @View()
     */
    public function putDetailIndicateurAction(DetailIndicateur $detail)
    {
        $request = $this->get('request');
        $newDetail = $this->deserialize('AppBundle\Entity\DetailIndicateur',$request,'json',array('common'));
        if($newDetail instanceof DetailIndicateur ===false){
            return $this->view(array('errors'=>$newDetail),Codes::HTTP_BAD_REQUEST);
        }
        $em = $this->getEntityManager();
        $newDetail->setIndicateur($em->getRepository("AppBundle:Indicateur")->find($newDetail->getIndicateur()->getId()));
        $detail->update($newDetail);
        return $this->save($detail,'get_indicateur');
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