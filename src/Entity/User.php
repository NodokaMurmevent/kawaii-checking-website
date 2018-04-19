<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Ambta\DoctrineEncryptBundle\Configuration\Encrypted;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email déjà pris")
 * @UniqueEntity(fields="username", message="Nom d'utilisateur déjà pris")
 */
class User implements UserInterface, \Serializable {

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $id;

    /**
     * @var string
     * @Encrypted
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $fullName;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=false, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @Encrypted
     * @Assert\Email() 
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    private $EmailAuthEnabled;

    /**
     * @var array
     *
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string",nullable=true)
     */
    protected $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string",nullable=true)
     */
    protected $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="mastodon", type="string",nullable=true)
     */
    protected $mastodon;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $trusted;

    /**
     * @var string
     * @Encrypted
     * @ORM\Column(name="secretkey", type="string",nullable=true)
     */
    protected $secretkey;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $authCode;
//    /**
//     * @var ArrayCollection
//     * 
//     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="auteur")
//     */
//    protected $BlogArticles;
//    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\WebSite", mappedBy="client")
     */
    protected $webSites;

    public function __construct() {
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): string {
        return $this->id;
    }

    public function setFullName(string $fullName): void {
        $this->fullName = $fullName;
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * Retourne les rôles de l'user
     */
    public function getRoles(): array {
        $roles = $this->roles;

        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void {
        $this->roles = $roles;
    }

    /**
     * Retour le salt qui a servi à coder le mot de passe
     *
     * {@inheritdoc}
     */
    public function getSalt() {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void {
        // Nous n'avons pas besoin de cette methode car nous n'utilions pas de plainPassword
        // Mais elle est obligatoire car comprise dans l'interface UserInterface
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void {
        list (
                $this->id,
                $this->username,
                $this->password
                ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return User
     */
    public function setFacebook($facebook) {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook() {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter) {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter() {
        return $this->twitter;
    }

    /**
     * Set mastodon
     *
     * @param string $mastodon
     *
     * @return User
     */
    public function setMastodon($mastodon) {
        $this->mastodon = $mastodon;

        return $this;
    }

    /**
     * Get mastodon
     *
     * @return string
     */
    public function getMastodon() {
        return $this->mastodon;
    }

    public function setSecretKey($secretkey) {
        $this->secretkey = $secretkey;
    }

    public function getSecretKey() {
        return $this->secretkey;
    }

    /**
     * @return string
     */
    public function __toString() {
        return sprintf('%s', $this->getFullName());
    }

    /**
     * Add page
     *
     * @param \App\Entity\WebSite $webSite
     *
     * @return User
     */
    public function addWebSite(\App\Entity\WebSite $webSite) {
        $this->webSites[] = $webSite;

        return $this;
    }

    /**
     * Remove page
     *
     * @param \App\Entity\WebSite $webSite
     */
    public function removeWebSite(\App\Entity\WebSite $webSite) {
        $this->webSites->removeElement($webSite);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWebSites() {
        return $this->webSites;
    }

    public function isEmailAuthEnabled() {
        return $this->EmailAuthEnabled; // This can also be a persisted field
    }

    public function getEmailAuthCode() {
        return $this->authCode;
    }

    public function setEmailAuthCode($authCode) {
        $this->authCode = $authCode;
    }

    public function addTrustedComputer($token, \DateTime $validUntil) {
        $this->trusted[$token] = $validUntil->format("r");
    }

    public function isTrustedComputer($token) {
        if (isset($this->trusted[$token])) {
            $now = new \DateTime();
            $validUntil = new \DateTime($this->trusted[$token]);
            return $now < $validUntil;
        }
        return false;
    }

}
