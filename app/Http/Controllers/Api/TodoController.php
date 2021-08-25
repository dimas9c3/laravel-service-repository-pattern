<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TodoService;
use App\Services\PasienService;
use Exception;

class TodoController extends Controller
{
    /**
     * @var todoService
     */
    protected $todoService;

    /**
     * TodoController Constructor
     *
     * @param TodoService $todoService
     *
     */
    public function __construct(TodoService $todoService, PasienService $pasienService)
    {
        $this->todoService = $todoService;
        $this->pasienService = $pasienService;
    }

    public function get(Request $request)
    {
        $input   = $request->all();
        $result = $this->todoService->getAll($input);

        return response()->json($result);
    }

    public function getPasien(Request $request)
    {
        $input   = $request->all();
        $result = $this->pasienService->getAll($input);

        return response()->json($result);
    }

    public function store(Request $request)
    {
        try {
            $this->todoService->saveTodoData($request);

            return response()->json([
                'status'    => true,
                'message'   => __('general.success_insert', ['object' => 'Todo'])
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => false,
                'message'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->todoService->deleteById($request);

            return response()->json([
                'status'    => true,
                'message'   => __('general.success_delete', ['object' => 'Todo'])
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => false,
                'message'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $this->todoService->updateById($request);

            return response()->json([
                'status'    => true,
                'message'   => __('general.success_update', ['object' => 'Todo'])
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => false,
                'message'   => $e->getMessage()
            ], 500);
        }
    }
}
