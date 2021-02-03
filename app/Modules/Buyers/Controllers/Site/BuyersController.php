<?php
namespace App\Modules\Buyers\Controllers\Site;

use Illuminate\Validation\Rule;
use HZ\Illuminate\Mongez\Managers\AdminApiController;

class BuyersController extends AdminApiController
{
    /**
     * Controller info
     *
     * @var array
     */
    protected $controllerInfo = [

        'repository' => 'buyers',
        'listOptions' => [
            'select' => [],
            'filterBy' => [],
            'paginate' => null, // if set null, it will be automated based on repository configuration option
        ],
        'rules' => [
            'all' => [],
            'store' => [],
            'update' => [],
        ],
    ];

    /**
     * Make custom validation for store.
     *
     * @param mixed $request
     *
     * @return array
     */
    protected function storeValidation($request): array
    {
        return [
            'email' => [
                'email',
                'required',
                Rule::unique('buyers', 'email')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'mobile' => [
                'required',
                Rule::unique('buyers', 'mobile')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'fullName' => 'required',
            'password' => 'required|min:8',
            'lastName' => 'required'
        ];
    }

}
