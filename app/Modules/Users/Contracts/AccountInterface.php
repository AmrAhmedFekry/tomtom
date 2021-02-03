<?php
namespace App\Modules\Users\Contracts;

interface AccountInterface 
{
    /**
     * Get account type
     * 
     * @return string
     */
    public function type(): string;
}