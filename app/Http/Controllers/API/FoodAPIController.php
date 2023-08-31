<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFoodAPIRequest;
use App\Http\Requests\API\UpdateFoodAPIRequest;
use App\Models\Food;
use App\Repositories\FoodRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class FoodAPIController
 */
class FoodAPIController extends AppBaseController
{
    private FoodRepository $foodRepository;

    public function __construct(FoodRepository $foodRepo)
    {
        $this->foodRepository = $foodRepo;
    }

    /**
     * Display a listing of the Food.
     * GET|HEAD /food
     */
    public function index(Request $request): JsonResponse
    {
        $food = $this->foodRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $result = [];
        foreach ($food->toArray() as $item) {
            $result[] = [
                ...$item,
                'price' => floatval($item['price'])
            ];
        }
        return $this->sendResponse( $result, 'Food retrieved successfully');
    }

    /**
     * Store a newly created Food in storage.
     * POST /food
     */
    public function store(CreateFoodAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $food = $this->foodRepository->create($input);

        return $this->sendResponse($food->toArray(), 'Food saved successfully');
    }

    /**
     * Display the specified Food.
     * GET|HEAD /food/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Food $food */
        $food = $this->foodRepository->find($id);

        if (empty($food)) {
            return $this->sendError('Food not found');
        }

        return $this->sendResponse($food->toArray(), 'Food retrieved successfully');
    }

    /**
     * Update the specified Food in storage.
     * PUT/PATCH /food/{id}
     */
    public function update($id, UpdateFoodAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Food $food */
        $food = $this->foodRepository->find($id);

        if (empty($food)) {
            return $this->sendError('Food not found');
        }

        $food = $this->foodRepository->update($input, $id);

        return $this->sendResponse($food->toArray(), 'Food updated successfully');
    }

    /**
     * Remove the specified Food from storage.
     * DELETE /food/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Food $food */
        $food = $this->foodRepository->find($id);

        if (empty($food)) {
            return $this->sendError('Food not found');
        }

        $food->delete();

        return $this->sendSuccess('Food deleted successfully');
    }
}
