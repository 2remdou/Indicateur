<?php
/**
 * Created by PhpStorm.
 * User: delphinsagno
 * Date: 22/02/15
 * Time: 20:15
 */

namespace AppBundle\Model;


interface IndicateurInterface {

    /**
     * @return mixed
     */
    public function add();

    public function update();

    public function all();
} 