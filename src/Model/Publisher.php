<?php


namespace M2i\monProjet\Model;


class Publisher
{
    // variables privées
    /**
     * @var string
     */
    private $name;
    /**
     * @var integer
     */
    private $id;

    // getters et setters

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Publisher
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Publisher
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }



}