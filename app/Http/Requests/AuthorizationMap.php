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
            'room' => [
                'ifShown' => true,
            ],
            'online-players' => [
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
            'marquee' => [
                'ifShown' => true,
            ],
        ],
        'activities' => [
            'ifShown' => true,
            'activities-list' => [
                'ifShown' => true,
            ],
            'rewards-list' => [
                'ifShown' => true,
            ],
            'goods-list' => [
                'ifShown' => true,
            ],
            'tasks-list' => [
                'ifShown' => true,
            ],
            'user-goods' => [
                'ifShown' => true,
            ],
            'player-task' => [
                'ifShown' => true,
            ],
            'statement' => [
                'ifShown' => true,
            ],
            'red-packet-log' => [
                'ifShown' => true,
            ],
            'log-activity-reward' => [
                'ifShown' => true,
            ],
        ],
        'community' => [
            'ifShown' => true,
            'list' => [
                'ifShown' => true,
            ],
            'valid-card' => [
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
            'bills' => [
                'ifShown' => true,
            ],
            'valid-card' => [
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
        'permission' => [
            'ifShown' => true,
            'member' => [
                'ifShown' => true,
            ],
            'group' => [
                'ifShown' => true,
            ],
        ],
        'rules' => [
            'ifShown' => true,
            'wx-top-up' => [
                'ifShown' => true,
            ],
            'rebate' => [
                'ifShown' => true,
            ],
        ],
        'order' => [
            'ifShown' => true,
            'wechat' => [
                'ifShown' => true,
            ],
            'withdrawals' => [
                'ifShown' => true,
            ],
            'rebates' => [
                'ifShown' => true,
            ],
            'search' => [
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