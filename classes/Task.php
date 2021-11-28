<?php

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_WORKING = 'working';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_DONE = 'done';
    const ACTION_REFUSED = 'refused';

    private $id;
    private $role;

    public $currentStatus;
    public $currentAction;

    public function __construct($id, $role)
    {
        $this->id = $id;
        $this->role = $role;
    }

    public function getMapStatuses()
    {
        $mapStatuses =
        [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_WORKING => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено'
        ];

        return $mapStatuses;
    }

    public function getMapActions()
    {
        $mapActions =
        [
            self::ACTION_CANCEL => 'Отменить задание',
            self::ACTION_RESPOND => 'Откликнуться на задание',
            self::ACTION_DONE => 'Задание выполнено',
            self::ACTION_REFUSED => 'Отказаться от задания'
        ];
        return $mapActions;
    }

    public function getStatus()
    {
        return $this->currentStatus;
    }

    public function getAvailableActions()
    {
        if ($this->role === 'customer') {
            if ($this->currentStatus === STATUS_NEW) {
                return self::ACTION_CANCEL;
            }
            if ($this->currentStatus === STATUS_WORKING) {
                return self::ACTION_DONE;
            }
            return null;
        }
        if ($this->role === 'executor') {
            if ($this->currentStatus === STATUS_NEW) {
                return self::ACTION_RESPOND;
            }
            if ($this->currentStatus === STATUS_WORKING) {
                return self::ACTION_REFUSED;
            }
            return null;
        }

    }

}
