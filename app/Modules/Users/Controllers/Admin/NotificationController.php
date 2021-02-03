<?php
namespace App\Modules\Users\Controllers\Admin;

use App\Modules\Users\Models\UserNotification;
use App\Modules\Users\Helpers\Notifications;
use HZ\Illuminate\Mongez\Managers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class NotificationController extends ApiController
{


    /**
     * Notification Model
     *
     * @var App\Modules\Users\Models\UserNotification
     */
    protected $notificationModel = UserNotification::class;

    /**
     * Mark as seen
     *
     * @param int $id
     * @return void
     */
    public function markAsSeen($id)
    {
        $notificationCenter = new Notifications(user(), $this->notificationModel);
        $notificationCenter->markAsSeen($id);
        return $this->success([
            'notificationsCount' => count($notificationCenter->list(user()->id)),
        ]);
    }


    /**
     * List of notifications
     *
     * @param int $id
     * @return void
     */
    public function list()
    {
        $notificationCenter = new Notifications(user(), $this->notificationModel);
        return $this->success([
            'notifications' => $notificationCenter->list()
        ]);
    }

    /**
     * Remove a notification
     *
     * @param int $id
     * @return void
     */
    public function remove($id)
    {
        $notificationCenter = new Notifications(user(), $this->notificationModel);
        $notificationCenter->remove($id);
        return $this->success([
            'notificationsCount' => count($notificationCenter->list(user()->id))
        ]);
    }

    /**
     * Remove all notifications
     *
     * @param int $id
     * @return void
     */
    public function removeAll()
    {
        $notificationCenter = new Notifications(user(), $this->notificationModel);
        $notificationCenter->removeAll((int) user()->id);
        return $this->success();
    }
}
