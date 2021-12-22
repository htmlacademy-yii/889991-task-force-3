<?php
namespace Taskforce\logic;

class DoneAction extends BaseAction
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
        return 'Задание выполнено';
    }

    public function getInteralName()
    {
        return 'done';
    }
}
