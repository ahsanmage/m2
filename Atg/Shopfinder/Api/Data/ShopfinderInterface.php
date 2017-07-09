<?php

namespace Atg\Shopfinder\Api\Data;
 
interface ShopfinderInterface
{
    /**
     * @return int
     */
    public function getId();
 
    /**
     * @param int $id
     * @return void
     */
    public function setId($id);
 
    /**
     * @return string
     */
    public function getName();
 
    /**
     * @param string $name
     * @return void
     */
    public function setName($name);
    
    /**
     * @return string
     */
    public function getStatus();
 
    /**
     * @param string $status
     * @return void
     */
    public function setStatus($status);
    
    /**
     * @return string
     */
    public function getImage();
 
    /**
     * @param string $image
     * @return void
     */
    public function setImage($image);
}