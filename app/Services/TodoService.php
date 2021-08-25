<?php

namespace App\Services;

use App\Repositories\TodoRepository;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class TodoService
{
    protected $TodoRepository;
    protected $CommomRepository;

    public function __construct(TodoRepository $TodoRepository, CommonRepository $CommomRepository)
    {
        $this->TodoRepository = $TodoRepository;
        $this->CommomRepository = $CommomRepository;
    }

    public function getAll($data)
    {
        $param = buildParamModel();

        $param['columns'] = array_merge(
            $param['columns'],
            ['todo.id', 'todo_name', 'name', 'todo_image']
        );

        if ($data['filter_todo_name'] ?? null) {
            $param['filter'] = array_merge(
                $param['filter'],
                ['todo_name', 'LIKE', "%{$data['filter_todo_name']}%"]
            );
        }

        if ($data['todo_id'] ?? null) {
            $param['filter'] = array_merge(
                $param['filter'],
                ['todo.id', '=', $data['todo_id']]
            );
        }

        if ($data['sort'] ?? null) {
            $param['sort'] = array_merge(
                $param['sort'],
                [$data['sort'] => $data['order']]
            );
        }

        if ($data['rows'] ?? null) {
            $param['limit'] = $data['rows'];
        }

        if ($data['page'] ?? null) {
            $param['offset'] = (int)$data['rows'] * ((int)$data['page'] - 1);
        }

        try {
            return $this->TodoRepository->getAll($param);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function saveTodoData($request)
    {
        $data = $request->only([
            'todo_name'
        ]);

        $validator = Validator::make($request->all(), [
            'todo_name'     => 'required',
            'todo_image'    => 'mimes:jpg,jpeg,png,gif,svg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        if (isDataNotEmpty($request->file('todo_image'))) {
            $file = uploadImage($request->file('todo_image'), public_path('storage/upload/image/todo/'));

            $data['todo_image'] = asset('storage/upload/image/todo/'.$file);
        }

        $data['user_id'] = 1;
        $data['created_at'] = getDateTimeNow();
        $data['updated_at'] = getDateTimeNow();

        DB::beginTransaction();

        try {
            $save =  $this->CommomRepository->save('todo', $data);

            DB::commit();

            return $save;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function deleteById($request)
    {
        $param = buildParamModel();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $param['filter'] = array_merge($param['filter'], ['id', '=', "{$request->id}"]);
            $delete =  $this->CommomRepository->delete('todo', $param, true);

            DB::commit();

            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function updateById($request)
    {
        $param = buildParamModel();

        $data = $request->only([
            'todo_name'
        ]);

        $validator = Validator::make($request->all(), [
            'todo_name'     => 'required',
            'todo_image'    => 'mimes:jpg,jpeg,png,gif,svg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        if (isDataNotEmpty($request->file('todo_image'))) {
            $file = uploadImage($request->file('todo_image'), public_path('storage/upload/image/todo/'));

            $data['todo_image'] = asset('storage/upload/image/todo/'.$file);
        }

        $data['updated_at'] = getDateTimeNow();

        DB::beginTransaction();

        try {
            $param['filter'] = array_merge($param['filter'], ['id', '=', "{$request->id}"]);
            $update =  $this->CommomRepository->update('todo', $param, $data);

            DB::commit();

            return $update;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
