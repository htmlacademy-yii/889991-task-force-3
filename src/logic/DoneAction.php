<?php
namespace Taskforce\logic;

class DoneAction extends BaseAction
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
        return 'Задание выполнено';
    }

    public function getInteralName()
    {
        return 'done';
    }
}
