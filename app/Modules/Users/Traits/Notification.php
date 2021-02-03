<?php
namespace App\Modules\Users\Traits;


use App\Modules\Cast\Models\{
    Cast,
    CastNotification
};
use App\Modules\Crew\Models\{
    Crew,
    CrewNotification
};

trait Notification 
{
    /**
     * Notifications Models 
     * 
     * @var array
     */
    public $notificationModels = [
        'crew' => [
            'model' => Crew::class,
            'notificationModel' => CrewNotification::class
        ],
        'cast' => [
            'model' => Cast::class,
            'notificationModel' => CastNotification::class
        ]
    ];

    /**
     * Create Notification
     * 
     * @param string $type
     * @param int $modelId
     * @param array notificationData
     */
    public function createNotification($type, $modelId, $notificationData)
    {
        $targetModel = $this->notificationModels[$type]['model'];
        $targetNotificationModel = $this->notificationModels[$type]['notificationModel'];
        $targetModel = $targetModel::find($modelId);
        $crewNotificationModel = $this->notificationModels[$type]['notificationModel']::where($type .'.id', $modelId)->first();
        if ($crewNotificationModel === null) {
            $crewNotificationModel = new $targetNotificationModel;
            $crewNotificationModel->create([
                'crew' => $targetModel->sharedInfo(),
                'notifications' => [
                    $notificationData
                ]
            ]);
        } else {
            $notifications = $crewNotificationModel->notifications;
            $notifications [] = $notificationData;
            $crewNotificationModel->update([
                'notifications' => $notifications
            ]);        
        }
    }

    /**
     * Get notifications of target user 
     * 
     * @param string $type
     * @param int $crewId
     * @return array
     */
    public function getNotifications($type ,$modelId)
    {
        $targetNotificationModel = $this->notificationModels[$type]['notificationModel'];
        $notifications = [];
        $notifications = (array) $targetNotificationModel::where($type .'.id', $modelId)->first()->notifications;

        return array_reverse($notifications);
    }
}