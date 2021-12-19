<?php
namespace Taskforce\logic;

class CancelAction extends BaseAction
{
    public function verificationRights($idUser, $idCustomer, $idExtcutor)
    {
        if ($this->$idUser === $this->$idCustomer) {
            return true;
        }
        return false;
    }

    public function getTitle($mapActions)
    {
        return 'Отменить задание';
    }

    public function getInteralName()
    {
        return 'cancel';
    }
}
