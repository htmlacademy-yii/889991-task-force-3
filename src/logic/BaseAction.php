<?php
namespace Taskforce\logic;

abstract class BaseAction
{
    public $idUser;
    public $idCustomer;
    public $idExtcutor;

    public function __construct($idUser, $idCustomer, $idExtcutor)
    {
        $this->idUser = $idUser;
        $this->idCustomer = $idCustomer;
        $this->idExtcutor = $idExtcutor;
    }

    abstract public function verificationRights($idUser, $idCustomer, $idExtcutor);

    abstract public function getTitle();

    abstract public function getInteralName();

}
