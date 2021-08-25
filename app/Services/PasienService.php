<?php

namespace App\Services;

use App\Repositories\PasienRepository;
use Exception;
use InvalidArgumentException;

class PasienService
{
    protected $PasienRepository;

    public function __construct(PasienRepository $PasienRepository)
    {
        $this->PasienRepository = $PasienRepository;
    }

    public function getAll($data)
    {
        $param = buildParamModel();

        if ($data['filter_nama_pasien'] ?? null) {
            $param['filter'] = array_merge(
                $param['filter'],
                ['PASIEN.NAMAPASIEN', 'LIKE', "%{$data['filter_nama_pasien']}%"]
            );
        }

        if ($data['filter_no_pasien'] ?? null) {
            $param['filter'] = array_merge(
                $param['filter'],
                ['PASIEN.NOPASIEN', 'LIKE', "%{$data['filter_no_pasien']}%"]
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
            return $this->PasienRepository->getAll($param);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
