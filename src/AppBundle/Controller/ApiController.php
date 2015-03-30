<?php
/**
 * Created by PhpStorm.
 * User: mdoutoure
 * Date: 24/02/2015
 * Time: 10:48
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Serializer\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends FOSRestController {
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }
    protected function deserialize($class, Request $request, $format = 'json',$groups="common")
    {
        $serializer = $this->get('serializer');
        $validator = $this->get('validator');
        try {
            $entity = $serializer->deserialize($request->getContent(), $class, $format);
        } catch (RuntimeException $e) {
            throw new HttpException(400, $e->getMessage());
        }
        if (count($errors = $validator->validate($entity,$groups))) {
            return $errors;
        }
        return $entity;
    }
} 