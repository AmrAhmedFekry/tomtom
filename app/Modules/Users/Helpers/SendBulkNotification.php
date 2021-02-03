<?php
namespace App\Modules\Users\Helpers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBulkNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Notification data
     *
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $targets)
    {
        //
        $this->targets = $targets;
        $this->data = $data;
    }

    /**
     * Send bulk notification.
     *
     * @return $this
     */
    public function handle()
    {
        foreach($this->targets as $target) {
            foreach($target['userModels'] as $user) {
                $notification = new Notifications($user, $target['userNotificationModel']);
                $notification->send($this->data);
            }
        }
    }

}
