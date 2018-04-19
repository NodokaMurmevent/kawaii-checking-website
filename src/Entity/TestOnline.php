<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestOnlineRepository")
 */
class TestOnline
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\WebSite",inversedBy="TestResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $webSite; 
    
    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     * @ORM\JoinColumn(nullable=false)
     */
    private $result;
    
    function getId() {
        return $this->id;
    }

    function getWebSite() {
        return $this->webSite;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setWebSite($webSite) {
        $this->webSite = $webSite;
    }

    function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }

    function getResult() {
        return $this->result;
    }

    function setResult($result) {
        $this->result = $result;
    }


}
