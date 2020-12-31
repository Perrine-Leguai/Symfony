<?php
//ATTENTION ! SANS ORM, CA N'EST PLUS UNE ENTITE MAIS UNE CLASSE !
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PasswordUpdateRepository;
use Symfony\Component\Validator\Constraints as Assert;


/**
 */
class PasswordUpdate
{
    
    private $id;

    
    private $oldPwd;

    /**
     * @Assert\Length(min=8, minMessage="Votre mdp doit faire au moins 8 caractères")
     *
     * @var [string]
     */
    private $newPwd;

    /**
     * @Assert\EqualTo(propertyPath="newPwd", message="Les mots de passe ne sont pas identiques")
     *
     * @var [string]
     */
    private $confirmPwd;

    public function getOldPwd(): ?string
    {
        return $this->oldPwd;
    }

    public function setOldPwd(string $oldPwd): self
    {
        $this->oldPwd = $oldPwd;

        return $this;
    }

    public function getNewPwd(): ?string
    {
        return $this->newPwd;
    }

    public function setNewPwd(string $newPwd): self
    {
        $this->newPwd = $newPwd;

        return $this;
    }

    public function getConfirmPwd(): ?string
    {
        return $this->confirmPwd;
    }

    public function setConfirmPwd(string $confirmPwd): self
    {
        $this->confirmPwd = $confirmPwd;

        return $this;
    }
}
