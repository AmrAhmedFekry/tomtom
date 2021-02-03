<?php
namespace App\Modules\Users\Helpers;

use App\Modules\Cast\Models\CastNotificationReply;
use App\Modules\Crew\Models\CrewNotificationReply;
use App\Modules\Messages\Models\MessageReply;
use HZ\Illuminate\Mongez\Traits\RepositoryTrait;
class Notifications
{
    use RepositoryTrait;
    /**
     * Target User model
     *
     * @var NotificationModel
     */
    private $userModel;

    /**
     * Target Notification model
     *
     * @var NotificationModel
     */
    private $notificationModel;

    /**
     * Constructor
     *
     * @param  App\Modules\Cast|Crew\Models\Crew|Cast Model
     * @param  App\Modules\Cast|Crew\Models\Notification $notificationModel
     */
    public function __construct($userModel ,$notificationModel)
    {
        $this->user = $userModel;
        $this->notificationModel = new $notificationModel;
    }

    /**
     * Get user notifications list
     *
     * @return  mixed
     */
    public function list()
    {
        return $this->notificationModel::where('for.id', $this->user->id)->orderBy('seen')->orderBy('id', 'DESC')->get()->map(function($notification){
            $notification->createdAtHuman = \Carbon\Carbon::createFromTimeStamp(strtotime($notification->createdAt))->diffForHumans();
            return $notification->info();
        });
    }

    /**
     * Add new notification to user
     *
     * @param  array $notificationData
     * @return void
     */
    public function send($notificationData)
    {
        $notificationInfo = [
            'seen' => false,
            'type' => $notificationData['type'],
            'title' => $notificationData['title'],
            'description' => $notificationData['description'],
            'extra' => $notificationData['extra'],
            'notificationType'  => array_key_exists('type', $notificationData) ?$notificationData['type'] : 'text',
            'for' => $this->user->sharedInfo(),
            'messageId' => array_key_exists('messageId', $notificationData) ?$notificationData['messageId'] : 0
        ];

        $notificationModel = $this->notificationModel->create($notificationInfo);

        $this->user->notificationsCount = $this->user->notificationsCount + 1 ;

        $this->user->save();

        $notificationModel->save();
        // return $notificationModel->id;
    }

    /**
     * Mark the given notification id as seen
     *
     * @param   int $notificationId
     * @return  void
     */
    public function markAsSeen(int $notificationId)
    {
        $notification = $this->notificationModel::find($notificationId);

        $notification->seen = true;

        $this->user->notificationsCount--;

        $notification->save();

        $this->user->save();

    }

    /**
     * Remove the given notification id
     *
     * @param int $id
     * @return void
     */
    public function remove(int $id)
    {
        $this->user->notificationsCount--;

        $this->user->save();
        $this->notificationModel::where('id', (int) $id)->delete();
    }

    /**
     * Remove all notifications
     *
     * @return void
     */
    public function removeAll()
    {
        $this->user->notificationsCount = 0;

        $this->user->save();
        $this->notificationModel::where('for.id', (int) $this->user->id)->delete();
    }

    /**
     * Notification Reply
     *
     * @param object $user
     * @param int $notificationId
     * @param mixed $answer
     * @param string $type
     *
     * @return void
     */
    public function reply(int $notificationId, $answer, $type)
    {
        $message = $this->notificationModel::find($notificationId);

        $this->markAsSeen($notificationId);
        $message->selectedAnswer = $answer;
        $message->save();

        $this->messages->increaseTotalRepliesNumber($message->messageId, $answer, $type);
        $replyModel = new MessageReply;

        $replyModel->create([
            'userInfo' => $this->user->sharedInfo(),
            'notification' => $message->sharedInfo(),
            'answer'   => $answer,
            'type' => $type,
            'messageId' => $message->id
        ]);
    }
}
