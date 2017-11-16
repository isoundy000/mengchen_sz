<?php

namespace App\Http\Requests;

trait AuthorizationMap
{
    protected $view = [
        'home' => [
            'ifShown' => true,
        ],
        'statement' => [
            'ifShown' => true,
            'summary' => [
                'ifShown' => true,
            ],
        ],
        'gm' => [
            'ifShown' => true,
            'room' => [
                'ifShown' => true,
            ],
            'record' => [
                'ifShown' => true,
            ],
        ],
        'player' => [
            'ifShown' => true,
            'list' => [
                'ifShown' => true,
            ],
        ],
        'stock' => [
            'ifShown' => true,
            'apply-request' => [
                'ifShown' => true,
            ],
            'apply-list' => [
                'ifShown' => true,
            ],
            'apply-history' => [
                'ifShown' => true,
            ],
        ],
        'agent' => [
            'ifShown' => true,
            'create' => [
                'ifShown' => true,
            ],
            'list' => [
                'ifShown' => true,
            ],
        ],
        'top-up' => [
            'ifShown' => true,
            'admin' => [
                'ifShown' => true,
            ],
            'agent' => [
                'ifShown' => true,
            ],
            'player' => [
                'ifShown' => true,
            ],
        ],
        'system' => [
            'ifShown' => true,
            'log' => [
                'ifShown' => true,
            ],
        ],
    ];

    //新建立的组的默认可访问的view
    protected $initGroupView = [
        'home' => [
            'ifShown' => true,
        ],
    ];

    protected $api = [
        //TODO 思考何种数据格式可以合理的对uri和方法做权限控制
    ];
}