<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PasienRepository
{
    protected $pasien;

    public function __construct()
    {
        $this->pasien = DB::connection('sqlsrv');
    }

    public function getAll($data = null)
    {
        $result     = array();

        $db         = $this->pasien->table('REGPAS');

        if (isDataNotEmpty($data['columns'])) {
            $db->select($data['columns']);
        }else {
            $db->select(DB::raw('
               PASIEN.*
            '));
        }

        $db->join('PASIEN', 'PASIEN.NOPASIEN', '=', 'REGPAS.NOPASIEN');
        $db->join('REGRWI', 'REGRWI.NOREG', '=', 'REGPAS.NOREG');
        $db->leftJoin('REGDR', 'REGDR.NOREG', '=', 'REGPAS.NOREG');

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

        $result['rows'] = $db->get();

        return $result;
    }
}
