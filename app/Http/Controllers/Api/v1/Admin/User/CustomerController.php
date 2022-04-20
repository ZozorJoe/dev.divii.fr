<?php

namespace App\Http\Controllers\Api\v1\Admin\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\User\CustomerRequest;
use App\Http\Resources\Admin\User\CustomerCollection;
use App\Http\Resources\Admin\User\CustomerResource;
use App\Models\User;
use App\Models\User\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends ApiController
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

        $builder->where('users.channel', '=', User::CHANNEL_REGISTRATION);

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
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return CustomerResource|JsonResponse
     */
    public function store(CustomerRequest $request, Customer $customer)
    {
        $activity = $request->handle($customer);
        if($activity){
            return $this->show($request, $customer);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Customer $customer
     * @return CustomerResource
     */
    public function show(Request $request, Customer $customer): CustomerResource
    {
        $this->with($request, $customer);

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return CustomerResource|JsonResponse
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $activity = $request->handle($customer);
        if($activity){
            return $this->show($request, $activity);
        }

        return response()->json([
            'success' => false,
        ]);
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
        $customers = $request->input('customers');
        if (!empty($customers)){
            if ($count = Customer::destroy($customers)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
