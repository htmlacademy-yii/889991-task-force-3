<?php
namespace Taskforce\logic;

class RefusedAction extends BaseAction
{
    public function verificationRights($idUser, $idCustomer, $idExtcutor)
    {
        if ($this->$idUser === $this->$idExtcutor) {
            return true;
        }
        return false;
    }

    public function getTitle($mapActions)
    {
        return 'Отказаться от задания';
    }

    public function getInteralName()
    {
        return 'refused';
    }
}
