<?php
namespace Taskforce\logic;
use Taskforce\exceptions\CastomException;
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

    public function __construct(string $currentStatus, int $idUser, int $idCustomer, int $idExecutor = null)
    {
        if ($currentStatus !== self::STATUS_NEW && $currentStatus !== self::STATUS_WORKING) {
            throw new CastomException("Нет доступных действий для этого статуса");
        }
        $this->currentStatus = $currentStatus;
        $this->idUser = $idUser;
        $this->idCustomer = $idCustomer;
        $this->idExecutor = $idExecutor;
    }

    public static function getMapStatuses($taskStatus): string
    {
        $mapStatuses =
        [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_WORKING => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено'
        ];

        return $mapStatuses[$taskStatus];
    }

    public function getMapActions(): array
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

    public function getStatus(): string
    {
        return $this->currentStatus;
    }

    public function getAvailableActions(string $role)
    {
        if ($role !== 'customer' && $role !== 'executor')
        {
            throw new CastomException("Действия может совершать только заказчик или исполнитель");
        }
        if ($role === 'customer') {
            if ($this->currentStatus === self::STATUS_NEW && $this->idUser === $this->idCustomer) {
                return $this->currentAction = self::ACTION_CANCEL;
            }
            if ($this->currentStatus === self::STATUS_WORKING && $this->idUser === $this->idCustomer) {
                return $this->currentAction = self::ACTION_DONE;
            }
        }
        if ($role === 'executor') {
            if ($this->currentStatus === self::STATUS_NEW) {
                return $this->currentAction = self::ACTION_RESPOND;
            }
            if ($this->currentStatus === self::STATUS_WORKING && $this->idUser === $this->idExecutor) {
                return $this->currentAction = self::ACTION_REFUSED;
            }
        }
    }
}
