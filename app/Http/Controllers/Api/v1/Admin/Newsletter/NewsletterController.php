<?php

namespace App\Http\Controllers\Api\v1\Admin\Newsletter;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Newsletter\NewsletterRequest;
use App\Http\Resources\Admin\Newsletter\NewsletterCollection;
use App\Http\Resources\Admin\Newsletter\NewsletterResource;
use App\Models\Newsletter\Newsletter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Newsletter::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Newsletter $newsletter
     * @return NewsletterCollection
     */
    public function index(Request $request, Newsletter $newsletter): NewsletterCollection
    {
        $builder = Newsletter::query();

        $this->with($request, $newsletter, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('fname', 'LIKE', "%$search%");
                $builder->orWhere('lname', 'LIKE', "%$search%");
                $builder->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new NewsletterCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsletterRequest $request
     * @param Newsletter $newsletter
     * @return NewsletterResource|JsonResponse
     */
    public function store(NewsletterRequest $request, Newsletter $newsletter)
    {
        $activity = $request->handle($newsletter);
        if($activity){
            return $this->show($request, $newsletter);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Newsletter $newsletter
     * @return NewsletterResource
     */
    public function show(Request $request, Newsletter $newsletter): NewsletterResource
    {
        $this->with($request, $newsletter);
        $newsletter->load('image');

        return new NewsletterResource($newsletter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsletterRequest $request
     * @param Newsletter $newsletter
     * @return NewsletterResource|JsonResponse
     */
    public function update(NewsletterRequest $request, Newsletter $newsletter)
    {
        $activity = $request->handle($newsletter);
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
     * @param Newsletter $newsletter
     * @return JsonResponse
     */
    public function destroy(Newsletter $newsletter): JsonResponse
    {
        return response()->json([
            'success' => $newsletter->delete(),
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
        $newsletters = $request->input('newsletters');
        if (!empty($newsletters)){
            if ($count = Newsletter::destroy($newsletters)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
