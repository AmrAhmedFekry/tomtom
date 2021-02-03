<?php
namespace App\Modules\Buyers\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use HZ\Illuminate\Mongez\Managers\Database\MongoDB\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use App\Modules\Users\Traits\Auth\updatePassword;
use HZ\Illuminate\Mongez\Traits\MongoDB\RecycleBin;
use Illuminate\Notifications\Notifiable;

class Buyer extends Model implements Authenticatable
{
    use AuthenticatableTrait, updatePassword, RecycleBin, Notifiable;


    /**
     * Get the account type
     *
     * @return string
     */
    public function type(): string
    {
        return "buyer";
    }
}
