<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query;

/**
 * Products
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="fk_products_categoryId", columns={"categoryId"}), @ORM\Index(name="fk_products_createdBy", columns={"createdBy"}), @ORM\Index(name="fk_products_modifiedBy", columns={"modifiedBy"}), @ORM\Index(name="idx_products_isActive", columns={"isActive"})})
 * @ORM\Entity
 */
class Products {

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=10, nullable=false)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="productVersion", type="smallint", nullable=true)
     */
    private $productversion = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=true)
     */
    private $isactive = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime", nullable=true)
     */
    private $datecreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModified", type="datetime", nullable=true)
     */
    private $datemodified;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modifiedBy", referencedColumnName="id")
     * })
     */
    private $modifiedby;

    /**
     * @var \AppBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     * })
     */
    private $createdby;

    /**
     * @var \AppBundle\Entity\Categories
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoryId", referencedColumnName="id")
     * })
     */
    private $categoryid;

    /**
     * Used to determine what fields are allows saved from a request
     * @var array
     */
    private $allowedRequestFields = array('id', 'sku', 'name', 'description', 'price', 'quantity', 'isActive', 'productVersion', 'categoryId');

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return Products
     */
    public function setSku($sku) {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku() {
        return $this->sku;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Products
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
     *
     * @return Products
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
     * Set price
     *
     * @param string $price
     *
     * @return Products
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Products
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Set productversion
     *
     * @param integer $productversion
     *
     * @return Products
     */
    public function setProductversion($productversion) {
        $this->productversion = $productversion;

        return $this;
    }

    /**
     * Get productversion
     *
     * @return integer
     */
    public function getProductversion() {
        return $this->productversion;
    }

    /**
     * Set isactive
     *
     * @param boolean $isactive
     *
     * @return Products
     */
    public function setIsactive($isactive) {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return boolean
     */
    public function getIsactive() {
        return $this->isactive;
    }

    /**
     * Set datecreated
     *
     * @param \DateTime $datecreated
     *
     * @return Products
     */
    public function setDatecreated($datecreated) {
        $this->datecreated = $datecreated;

        return $this;
    }

    /**
     * Get datecreated
     *
     * @return \DateTime
     */
    public function getDatecreated() {
        return $this->datecreated;
    }

    /**
     * Set datemodified
     *
     * @param \DateTime $datemodified
     *
     * @return Products
     */
    public function setDatemodified($datemodified) {
        $this->datemodified = $datemodified;

        return $this;
    }

    /**
     * Get datemodified
     *
     * @return \DateTime
     */
    public function getDatemodified() {
        return $this->datemodified;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set modifiedby
     *
     * @param \AppBundle\Entity\Users $modifiedby
     *
     * @return Products
     */
    public function setModifiedby(\AppBundle\Entity\Users $modifiedby = null) {
        $this->modifiedby = $modifiedby;

        return $this;
    }

    /**
     * Get modifiedby
     *
     * @return \AppBundle\Entity\Users
     */
    public function getModifiedby() {
        return $this->modifiedby;
    }

    /**
     * Set createdby
     *
     * @param \AppBundle\Entity\Users $createdby
     *
     * @return Products
     */
    public function setCreatedby(\AppBundle\Entity\Users $createdby = null) {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return \AppBundle\Entity\Users
     */
    public function getCreatedby() {
        return $this->createdby;
    }

    /**
     * Set categoryid
     *
     * @param \AppBundle\Entity\Categories $categoryid
     *
     * @return Products
     */
    public function setCategoryid(\AppBundle\Entity\Categories $categoryid = null) {
        $this->categoryid = $categoryid;

        return $this;
    }

    /**
     * Get categoryid
     *
     * @return \AppBundle\Entity\Categories
     */
    public function getCategoryid() {
        return $this->categoryid;
    }

    /**
     * Used to set data in a product based on the data posted in the Request
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $doctrine
     * @return \AppBundle\Entity\Products
     */
    public function setDataFromRequest(\Symfony\Component\HttpFoundation\Request $request, $doctrine) {
        $requestData = $request->request->all();
        $dataToSave = array();
        foreach ($requestData as $dataKey => $dataValue) {
            $functionName = 'set' . ucfirst(strtolower($dataKey));
            if ($dataKey == 'catregoryId') {
                $category = $doctrine->getRepository('AppBundle:Categories')->find($dataValue);
                $this->setCategoryid($category);
            } elseif (in_array($dataKey, $this->allowedRequestFields) && method_exists(new Products(), $functionName)) {
                $functionName = 'set' . ucfirst(strtolower($dataKey));
                $this->{$functionName}($dataValue);
            }
        }
        return $this;
    }

    /**
     * Used to determine if the current product instance is valid for saving
     * @return boolean
     */
    public function dataValid() {
        //@TODO: Implement products.dataValid function
        //Not implemented
        return TRUE;
    }

}
