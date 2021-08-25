<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TodoService;
use Exception;

class MenuController extends Controller
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
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function get(Request $request)
    {
        $menu = array(
            [
                'id'         => 1,
                'idgroup'    => 1,
                'idmenu'     => 1,
                'idparent'   => 0,
                'text'       => 'Datagrid',
                'url'        => '#',
                'children'   => array(
                    [
                        'id'         => 2,
                        'idgroup'    => 1,
                        'idmenu'     => 1,
                        'idparent'   => 1,
                        'text'       => 'Basic',
                        'url'        => 'todo',
                        'children'   => false
                    ],
                    [
                        'id'         => 4,
                        'idgroup'    => 1,
                        'idmenu'     => 1,
                        'idparent'   => 1,
                        'text'       => 'Pasien Covid Ranap',
                        'url'        => 'todo/pasien',
                        'children'   => false
                    ]
                )
            ],

            [
                'id'         => 3,
                'idgroup'    => 2,
                'idmenu'     => 2,
                'idparent'   => 0,
                'text'       => 'Session logout test',
                'url'        => 'todo/logout',
                'children'   => false
            ]

        );

        return response()->json($menu);
    }
}
