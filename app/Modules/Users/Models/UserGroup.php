<?php
namespace App\Modules\Users\Models;

use HZ\Illuminate\Mongez\Managers\Database\MongoDB\Model;

class UserGroup extends Model 
{
    
    /**
     * {@inheritDoc}
     */
    protected $collection = 'usersGroups';

    /**
     * Get shared info for the user that will be stored as a sub document of another collection
     * 
     * @return array
     */
    public function sharedInfo(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => $this->permissions
        ];
    }
}