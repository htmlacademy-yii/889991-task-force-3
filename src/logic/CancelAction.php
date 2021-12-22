<?php
namespace Taskforce\logic;

class CancelAction extends BaseAction
{
    public function verificationRights($idUser, $idCustomer, $idExtcutor)
    {
        if ($idUser === $idCustomer) {
            return true;
        }
        return false;
    }

    public function getTitle()
    {
        return 'Отменить задание';
    }

    public function getInteralName()
    {
        return 'cancel';
    }
}
