<?php
namespace Heiner\Heiner\Domain\Model;


/***
 *
 * This file is part of the "personenundfirmen" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Heiner Giehl <heiner.giehl@tu-dortmund.de>, HeinerGiehl
 *
 ***/
/**
 * Person
 */
class Person extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * anrede
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $anrede = '';

    /**
     * vorname
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $vorname = '';

    /**
     * nachname
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $nachname = '';

    /**
     * email
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $email = '';

    /**
     * telefon
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $telefon = '';

    /**
     * handy
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $handy = '';

    /**
     * firma
     * 
     * @var \Heiner\Heiner\Domain\Model\Company
     */
    protected $firma = null;

    /**
     * Returns the anrede
     * 
     * @return string $anrede
     */
    public function getAnrede()
    {
        return $this->anrede;
    }

    /**
     * Sets the anrede
     * 
     * @param string $anrede
     * @return void
     */
    public function setAnrede($anrede)
    {
        $this->anrede = $anrede;
    }

    /**
     * Returns the vorname
     * 
     * @return string $vorname
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * Sets the vorname
     * 
     * @param string $vorname
     * @return void
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    /**
     * Returns the nachname
     * 
     * @return string $nachname
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * Sets the nachname
     * 
     * @param string $nachname
     * @return void
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;
    }

    /**
     * Returns the email
     * 
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the telefon
     * 
     * @return string $telefon
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Sets the telefon
     * 
     * @param string $telefon
     * @return void
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;
    }

    /**
     * Returns the handy
     * 
     * @return string $handy
     */
    public function getHandy()
    {
        return $this->handy;
    }

    /**
     * Sets the handy
     * 
     * @param string $handy
     * @return void
     */
    public function setHandy($handy)
    {
        $this->handy = $handy;
    }

    /**
     * Returns the firma
     * 
     * @return \Heiner\Heiner\Domain\Model\Company $firma
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Sets the firma
     * 
     * @param \Heiner\Heiner\Domain\Model\Company $firma
     * @return void
     */
    public function setFirma(\Heiner\Heiner\Domain\Model\Company $firma)
    {
        $this->firma = $firma;
    }

    /**
     * get uid of the firma
     * 
    
     * @return  string $uid
     */
    public function getUid(){
        return $this->uid;
    }
}
