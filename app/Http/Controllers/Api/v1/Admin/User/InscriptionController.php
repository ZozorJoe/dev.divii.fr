<?php

namespace App\Http\Controllers\Api\v1\Admin\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\User\CustomerCollection;
use App\Models\User;
use App\Models\User\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InscriptionController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Customer $customer
     * @return CustomerCollection
     */
    public function index(Request $request, Customer $customer): CustomerCollection
    {
        $builder = Customer::query();

        $builder->latest();

        $builder->where('users.channel', '=', User::CHANNEL_LAUNCH);

        $this->with($request, $customer, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('first_name', 'LIKE', "%$search%");
                $builder->orWhere('last_name', 'LIKE', "%$search%");
                $builder->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new CustomerCollection($models, $perPage > 0);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return JsonResponse
     */
    public function destroy(Customer $customer): JsonResponse
    {
        return response()->json([
            'success' => $customer->delete(),
        ]);
    }

    /**
     * Mass delete the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function massDelete(Request $request): JsonResponse
    {
        $inscriptions = $request->input('inscriptions');
        if (!empty($inscriptions)){
            if ($count = Customer::destroy($inscriptions)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
