<?php

namespace App\Http\Controllers\Api\v1\Admin\User\Expert;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\User\RatingCollection;
use App\Models\User\Rating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatingController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Rating $rating
     * @return RatingCollection
     */
    public function index(Request $request, Rating $rating): RatingCollection
    {
        $builder = Rating::query();

        $this->with($request, $rating, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('name', 'LIKE', "%$search%");
                $builder->orWhere('description', 'LIKE', "%$search%");
            });
        }

        $status = $request->get('status');
        if(!empty($status)){
            $status = strtolower($status);
            $builder->where('status', '=', $status);
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new RatingCollection($models, $perPage > 0);
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param Rating $rating
     * @param string $status
     * @return JsonResponse
     */
    public function changeStatus(Rating $rating, string $status): JsonResponse
    {
        switch ($status){
            case Rating::STATUS_REFUSED:
            case Rating::STATUS_VALIDATED:
                $rating->status = $status;
                return response()->json([
                    'success' => $rating->save()
                ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Rating $rating
     * @return JsonResponse
     */
    public function destroy(Rating $rating): JsonResponse
    {
        return response()->json([
            'success' => $rating->delete(),
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
        $ratings = $request->input('orders');
        if (!empty($ratings)){
            if ($count = Rating::destroy($ratings)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
