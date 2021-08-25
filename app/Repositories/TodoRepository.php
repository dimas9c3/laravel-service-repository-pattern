<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
    protected $todo;

    public function __construct()
    {
        $this->todo = Todo::query();
    }

    public function getAll($data = null)
    {
        $db         = $this->todo;
        $result     = array();

        // DB::enableQueryLog();
        if (isDataNotEmpty($data['columns'])) {
            $db->select($data['columns']);
        }

        $db->join('users', 'users.id', '=', 'todo.user_id');

        if (isDataNotEmpty($data['filter'])) {
            $db->where(array($data['filter']));
        }

        if (isDataNotEmpty($data['sort'])) {
            foreach ($data['sort'] as $key => $value) {
                $db->orderBy($key, $value);
            }
        }

        $result['total'] = $db->count();

        if (isDataNotEmpty($data['offset'])) {
            $db->offset($data['offset']);
        }

        if (isDataNotEmpty($data['limit'])) {
            $db->limit($data['limit']);
        }

        $data = $db->get();

        // foreach ($data as $i => $dt) {
        //     if (isset($dt['todo_image'])) {
        //         $data[$i]['todo_image'] = asset('storage/'.$dt['todo_image']);
        //     }
        // }

        $result['rows'] = $data;

        return $result;
        // $db->get();
        // dd(DB::getQueryLog());
    }
}
