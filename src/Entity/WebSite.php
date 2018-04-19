<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WebSiteRepository")
 */
class WebSite {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="advanced", type="boolean", nullable=false)
     */
    private $advanced;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wordpress", type="boolean", nullable=false)
     */
    private $wordpress;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;
    
    /**
     * @var string
     *
     * @ORM\Column(name="filePath", type="string", length=255, nullable=true)
     */
    private $filePath;

    /**
     *
     * @ORM\OneToOne(targetEntity="App\Entity\SslResult",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $ssl;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User",cascade={"persist"},inversedBy="webSites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function __construct() {
        $this->enabled = true;
        $this->wordpress = false;
        $this->advanced = false;
    }

    /**
     * Get id
     *
     * @return guid 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return WebSite
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl() {
        return parse_url($this->url);
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return WebSite
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return string 
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return WebSite
     */
    public function setPays($pays) {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays() {
        return $this->pays;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return WebSite
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return WebSite
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    function getAdvanced() {
        return $this->advanced;
    }

    function getWordpress() {
        return $this->wordpress;
    }

    function setAdvanced($advanced) {
        $this->advanced = $advanced;
    }

    function setWordpress($wordpress) {
        $this->wordpress = $wordpress;
    }

    /**
     * Set auteur
     *
     * @param App\Entity\User $client
     * @return Article
     */
    public function setClient($client) {
        $this->client = $client;
        return $this;
    }

    /**
     * Get auteur
     *
     * @return \App\Entity\User 
     */
    public function getClient() {
        return $this->client;
    }

    function isOnline() {
        $ip4 = false;
        $ip6 = false;
        if ($this->getIp4()) {
            exec("ping -c 1 " . $this->getIp4() . " | head -n 2 | tail -n 1 | awk '{print $7}'", $ip4);
//             $ip4 = "ping -c 1 " . $this->getIp4();
            $ip4 = $ip4[0];
        }
        if ($this->getIp6()) {
//            $ip6 = "ping6 -c 1 " . $this->getIp6();
            exec("ping -c 1 " . $this->getIp4() . " | head -n 2 | tail -n 1 | awk '{print $7}'", $ip6);
            $ip6 = $ip6[0];
        }

        return [$ip4, $ip6];
    }

    function getIp4() {
        $ip = dns_get_record($this->getUrl()["host"], DNS_A);
        if ($ip) {
            return $ip[0]['ip'];
        } else {
            return false;
        }
    }

    function getIp6() {

        $ip = dns_get_record($this->getUrl()["host"], DNS_A6);
        if ($ip) {
            return $ip[0]['ip'];
        } else {
            return false;
        }
    }

    function getDNNByReverse() {

        return gethostbyaddr($this->getIp4());
    }

    function getHeaders() {

        $head = get_headers($this->getbaseUrl());
        if ($head) {
            return $head;
        } else {
            return false;
        }
    }

    function getStatutCode() {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->getbaseUrl());
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0");
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($head) {
            return $httpCode;
        } else {
            return false;
        }
    }

    function getResponseTime() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getbaseUrl());
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0");
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        curl_close($ch);
        if ($head) {
            return $httpCode;
        } else {
            return false;
        }
    }

    function isWordpress() {
        return true;
    }

    function getScreenShot($force=FALSE) {
        $p = "/var/www/html/kawaii-website-checker/public/media/image-" . $this->getId() . ".jpg";
        $cmd = "timeout 10 /var/www/html/kawaii-website-checker/vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64 -q --width 1920 --height 1080  -f jpg " . $this->getbaseUrl() . " " . $p;

        if (file_exists($p)) {
            $stats = stat($p);
            if ($stats[9] > (time() - (86400 * 2)) or $force) {
                unlink($p);
                exec($cmd);
            }
        } else {
            exec($cmd);
        }

        return "https://symphonie-of-code.fr/kawaii-website-checker/public/media/image-" . $this->getId() . ".jpg";
    }

    function readableAdvancedFile() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getbaseUrl() . '/' . $this->id . ".php");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        $content = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($content) {
            return [$httpCode, $content];
        } else {
            return false;
        }
        return file_exists();
//        return $this->getUrl()["scheme"] ."://". $this->getUrl()["host"] .'/'. $this->id.".php";
    }

    function getbaseUrl() {
        return $this->getUrl()["scheme"] . "://" . $this->getUrl()["host"];
    }

    function getSsl() {
        return $this->ssl;
    }

    function setSsl($ssl) {
        $this->ssl = $ssl;
        return $this;
    }
    function getFilePath() {
        return $this->filePath;
    }

    function setFilePath($filePath) {
        $this->filePath = $filePath;
    }


}
