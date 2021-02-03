<?php
namespace App\Modules\Users\Resources;
use App\Modules\Users\Resources\UsersGroup;
use HZ\Illuminate\Mongez\Managers\Resources\JsonResourceManager;

class User extends JsonResourceManager
{
    /**
     * {@inheritDoc}
     */
    const DATA = ['id', 'name', 'email', 'totalNotifications'];

    /**
     * {@inheritDoc}
     */
    const ASSETS = [];

    /**
     * {@inheritDoc}
     */
    const WHEN_AVAILABLE = [];

    /**
     * {@inheritDoc}
     */
    const RESOURCES = [
       'group' => UsersGroup::class
    ];

    /**
     * {@inheritDoc}
     */
    const COLLECTABLE = [];
}
