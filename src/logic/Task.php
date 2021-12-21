<?php
namespace Taskforce\logic;

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

    private $idUser;
    private $idCustomer;
    private $idExecutor;

    public $currentStatus;
    public $currentAction;

    public function __construct($idUser, $idCustomer, $idExecutor = null)
    {
        $this->idUser = $idUser;
        $this->idCustomer = $idCustomer;
        $this->idExecutor = $idExecutor;
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

    public function getAvailableActions($role)
    {
        if ($role === 'customer') {
            if ($this->currentStatus === self::STATUS_NEW) {
                return new CancelAction($this->idUser, $this->idCustomer, $this->idExecutor);
            }
            if ($this->currentStatus === self::STATUS_WORKING) {
                return new DoneAction($this->idUser, $this->idCustomer, $this->idExecutor);
            }
            return null;
        }
        if ($role === 'executor') {
            if ($this->currentStatus === self::STATUS_NEW) {
                return new RespondAction($this->idUser, $this->idCustomer, $this->idExecutor);
            }
            if ($this->currentStatus === self::STATUS_WORKING) {
                return new RefusedAction($this->idUser, $this->idCustomer, $this->idExecutor);
            }
            return null;
        }
    }
}
