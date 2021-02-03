<?php
namespace App\Modules\Users\Models;

use HZ\Illuminate\Mongez\Managers\Database\MongoDB\Model;

class UserNotification extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $collection = 'userNotifications';
}
