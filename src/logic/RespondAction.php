<?php
namespace Taskforce\logic;

class RespondAction extends BaseAction
{
    public function verificationRights($idUser, $idCustomer, $idExtcutor)
    {
        if ($idUser === $idExtcutor) {
            return true;
        }
        return false;
    }

    public function getTitle()
    {
        return 'Откликнуться на задание';
    }

    public function getInteralName()
    {
        return 'respond';
    }
}
