<?php
namespace Taskforce\logic;

class RespondAction extends BaseAction
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
        return 'Откликнуться на задание';
    }

    public function getInteralName()
    {
        return 'respond';
    }
}
