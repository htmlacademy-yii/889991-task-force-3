<?php
namespace Taskforce\logic;

class RefusedAction extends BaseAction
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
        return 'Отказаться от задания';
    }

    public function getInteralName()
    {
        return 'refused';
    }
}
