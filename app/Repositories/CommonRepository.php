<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;

class CommonRepository
{
    public function save($table, $data)
    {
        try {
           return DB::table($table)->insert($data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($table, $param, $soft_delete = false)
    {
        try {
            $db = DB::table($table);
            $db->where(array($param['filter']));

            if ($soft_delete) {
                return $db->update(['deleted_at' => getDateTimeNow()]);
            }else {
                return $db->delete();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($table, $param, $data)
    {
        try {
            $db = DB::table($table);
            $db->where(array($param['filter']));

            return $db->update($data);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
