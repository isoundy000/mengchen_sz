<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//auth()->loginUsingId(1);
//Route::get('calc', function (\App\Services\Game\ValidCardConsumedService $orderRebate){
//    var_dump($orderRebate->getAgentTopUpLogs());
//    var_dump(cache()->get(config('custom.game_server_cache_valid_card_agent_log')));
//    var_dump(\Carbon\Carbon::parse('1996-10-18')->age);
//});

Route::get('/', 'HomeController@index');
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//开发调试功能接口
Route::prefix('dev')->group(function () {
    Route::get('list-session', 'DevToolsController@listSession');
    Route::get('hashed-pass/{pass}', 'DevToolsController@hashedPass');
    Route::post('base64-decode', 'DevToolsController@base64Decode');
    Route::get('exception', 'DevToolsController@showException');
    Route::any('reply', 'DevToolsController@reply');   //返回post内容，for 文聪
});

//公共接口
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('info', 'InfoController@info');
    Route::get('content-header-h1', 'InfoController@getContentHeaderH1');

    Route::get('game/room/type-map', 'Admin\Game\RoomController@getRoomTypeMap');  //房间类型映射关系
    Route::get('game/player', 'PlayerController@searchPlayer');     //根据玩家id查找玩家
});

//微信订单
Route::group([
    'prefix' => 'api/wechat',
], function () {
    Route::group([
        'middleware' => ['auth'],
    ], function () {
        //微信订单
        Route::get('order', 'WeChatPaymentController@index'); //管理员查看
        Route::get('order/agent', 'WeChatPaymentController@agentOrder'); //代理商查看列表
        Route::get('order/agent/{order}', 'WeChatPaymentController@getAgentOrder'); //代理商查看
        Route::post('order', 'WeChatPaymentController@store');

        Route::get('order/search/{orderNo?}', 'WeChatPaymentController@search'); // 微信订单查询
    });

    Route::any('order/notification', 'WeChatPaymentController@getNotification'); //通知
});

//管理员接口
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin/api',
    'namespace' => 'Admin',
], function () {
    Route::put('self/password', 'AdminController@updatePass');

//    Route::get('home/summary', 'HomeController@summaryReport');

    Route::get('game/players', 'Game\PlayerController@show');

    Route::get('statement/summary', 'Game\StatementSummaryController@show');
    Route::get('statement/summary/excel', 'Game\StatementSummaryController@exportData2Excel');
    Route::get('statement/real-time', 'Game\StatementSummaryController@showRealTimeData');
    Route::get('statement/online-players', 'OnlinePlayerController@getOnlinePlayersChartData');
    Route::get('statement/room', 'Game\RoomStatementController@getRoomStatement');
    Route::get('statement/room/excel', 'Game\RoomStatementController@exportRoomStatement');

    Route::get('gm/records', 'Game\RecordController@search');
    Route::get('gm/record-info/{recId}', 'Game\RecordController@getRecordInfo')->where('recId', '[0-9]+');
    Route::get('gm/room/type', 'Game\RoomController@getRoomType');
    Route::post('gm/room', 'Game\RoomController@create');
    Route::get('gm/room/open', 'Game\RoomController@showOpenRoom');
    Route::get('gm/room/history', 'Game\RoomController@showRoomHistory');
    //跑马灯
    Route::get('gm/marquee','Game\MarqueeController@index');
    Route::post('gm/marquee','Game\MarqueeController@store');
    Route::put('gm/marquee/{id}','Game\MarqueeController@update')->where('id','[0-9]+');
    Route::delete('gm/marquee/{id}','Game\MarqueeController@destroy')->where('id','[0-9]+');

    Route::get('activities/list', 'Game\ActivitiesController@getActivitiesList');
    Route::put('activities/list', 'Game\ActivitiesController@editActivitiesList');
    Route::delete('activities/list/{aid}', 'Game\ActivitiesController@deleteActivitiesList')->where('aid', '[0-9]+');
    Route::post('activities/list', 'Game\ActivitiesController@addActivitiesList');
    Route::get('activities/reward-map', 'Game\ActivitiesRewardController@getActivitiesRewardMap');
    Route::get('activities/reward', 'Game\ActivitiesRewardController@getActivitiesRewardList');
    Route::put('activities/reward', 'Game\ActivitiesRewardController@editReward');
    Route::delete('activities/reward/{pid}', 'Game\ActivitiesRewardController@deleteReward')->where('pid', '[0-9]+');
    Route::post('activities/reward', 'Game\ActivitiesRewardController@addReward');
    Route::get('activities/goods-type', 'Game\ActivitiesGoodsController@getGoodsList');
    Route::put('activities/goods-type', 'Game\ActivitiesGoodsController@editGoodsType');
    Route::delete('activities/goods-type/{goodsId}', 'Game\ActivitiesGoodsController@deleteGoodsType')->where('goodsId', '[0-9]+');
    Route::post('activities/goods-type', 'Game\ActivitiesGoodsController@addGoodsType');
    Route::get('activities/goods-type-map', 'Game\ActivitiesGoodsController@getGoodsTypeMap');
    Route::get('activities/task', 'Game\ActivitiesTaskController@getTaskList');
    Route::put('activities/task', 'Game\ActivitiesTaskController@editTask');
    Route::delete('activities/task/{taskId}', 'Game\ActivitiesTaskController@deleteTask')->where('taskId', '[0-9]+');
    Route::post('activities/task', 'Game\ActivitiesTaskController@addTask');
    Route::get('activities/task-type-map', 'Game\ActivitiesTaskController@getTaskTypeMap');
    Route::get('activities/task-map', 'Game\ActivitiesTaskController@getTaskMap');
    Route::get('activities/user-goods', 'Game\ActivitiesUserGoodsController@getUserGoodsList');
    Route::put('activities/user-goods', 'Game\ActivitiesUserGoodsController@editUserGoods');
    Route::delete('activities/user-goods', 'Game\ActivitiesUserGoodsController@deleteUserGoods');
    Route::post('activities/user-goods', 'Game\ActivitiesUserGoodsController@addUserGoods');
    Route::put('activities/user-goods/reset', 'Game\ActivitiesUserGoodsController@resetUserGoods');
    Route::get('activities/tasks-player', 'Game\ActivitiesTasksPlayerController@getTasksPlayerList');
    Route::put('activities/tasks-player', 'Game\ActivitiesTasksPlayerController@editTasksPlayer');
    Route::delete('activities/tasks-player', 'Game\ActivitiesTasksPlayerController@deleteTasksPlayer');
    Route::post('activities/tasks-player', 'Game\ActivitiesTasksPlayerController@addTasksPlayer');
    Route::put('activities/tasks-player/reset', 'Game\ActivitiesTasksPlayerController@resetTasksPlayer');
    Route::get('activities/red-packet-log', 'Game\ActivitiesRedPacketLogController@getRedPacketLog');
    Route::put('activities/red-packet-log/status/{redPacketLog}', 'Game\ActivitiesRedPacketLogController@changeStatus')->where('redPacketLog', '[0-9]+');
    Route::get('activities/statement', 'Game\ActivitiesStatementController@getStatement');
    Route::get('activities/log-activity-reward', 'Game\ActivitiesRewardLogController@show');

    Route::get('community', 'CommunityController@showCommunityList');
    Route::post('community', 'CommunityController@createCommunity');
    Route::put('community/{community}', 'CommunityController@updateCommunity');
    Route::delete('community/{community}', 'CommunityController@deleteCommunity')->where('community', '[0-9]+');
    Route::post('community/audit/{community}', 'CommunityController@auditCommunityApplication')->where('community', '[0-9]+');
    Route::get('community/valid-card-consumed', 'CommunityController@getCommunityValidCardConsumedLog');
    Route::get('community/game-group/id-name-map', 'CommunityController@getGameGroupIdNameMap');

    Route::post('stock', 'StockController@apply');
    Route::get('stock/list', 'StockController@applyList');
    Route::get('stock/history', 'StockController@applyHistory');
    Route::post('stock/approval/{entry}', 'StockController@approve')->where('entry', '[0-9]+');
    Route::post('stock/decline/{entry}', 'StockController@decline')->where('entry', '[0-9]+');

    Route::get('agent', 'AgentController@showAll');
    Route::post('agent', 'AgentController@create');
    Route::delete('agent/{user}', 'AgentController@destroy')->where('user', '[0-9]+');
    Route::put('agent/{user}', 'AgentController@update')->where('user', '[0-9]+');
    Route::put('agent/pass/{user}', 'AgentController@updatePass')->where('user', '[0-9]+');
    Route::get('agent/bills', 'AgentController@getItemSoldRecords');
    Route::get('agent/card/valid-consumed-list', 'AgentController@getAgentValidCardConsumedRecord');

    Route::get('top-up/admin', 'TopUpController@admin2AgentHistory');
    Route::get('top-up/agent', 'TopUpController@agent2AgentHistory');
    Route::get('top-up/player', 'TopUpController@agent2PlayerHistory');
    Route::post('top-up/agent/{receiver}/{type}/{amount}', 'TopUpController@topUp2Agent')->where('amount', '-?[0-9]+');
    Route::post('top-up/player/{player}/{type}/{amount}', 'TopUpController@topUp2Player')->where('amount', '-?[0-9]+');

    Route::get('group/authorization/view/{group}', 'AuthorizationController@showViewAccess')->where('group', '[0-9]+');
    Route::put('group/authorization/view/{group}', 'AuthorizationController@setupViewAccess')->where('group', '[0-9]+');
    Route::get('group', 'GroupController@show');
    Route::post('group', 'GroupController@create');
    Route::put('group/{group}', 'GroupController@edit')->where('group', '[0-9]+');
    Route::delete('group/{group}', 'GroupController@destroy')->where('group', '[0-9]+');
    Route::get('group/map', 'GroupController@showMap');
    Route::get('role', 'RoleController@show');
    Route::post('role', 'RoleController@create');
    Route::put('role/{role}', 'RoleController@edit')->where('role', '[0-9]+');
    Route::delete('role/{role}', 'RoleController@destroy')->where('role', '[0-9]+');

    Route::get('system/log', 'SystemController@showLog');

    //微信充值规则
    Route::get('wx-top-up-rules', 'WxTopUpRuleController@index');
    Route::post('wx-top-up-rules', 'WxTopUpRuleController@store');
    Route::put('wx-top-up-rules/{rule}', 'WxTopUpRuleController@update');
    Route::delete('wx-top-up-rules/{rule}', 'WxTopUpRuleController@destroy');
    //返利规则
    Route::get('rebate-rules', 'RebateRuleController@index');
    Route::post('rebate-rules', 'RebateRuleController@store');
    Route::put('rebate-rules/{rule}', 'RebateRuleController@update');
    Route::delete('rebate-rules/{rule}', 'RebateRuleController@destroy');

    //提现审核
    Route::get('withdrawals', 'WithdrawalController@index');
    Route::post('withdrawals/audit/{withdrawal}', 'WithdrawalController@audit');

    //查看代理商返利
    Route::get('rebates/user/{user?}', 'RebateController@showUserRebate');
    Route::get('rebates/user/statistics/{user}', 'RebateController@statistics');

});

//管理员视图路由
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {
    Route::get('home', 'ViewController@home');

    Route::get('player/list', 'ViewController@playerList');

    Route::get('statement/summary', 'ViewController@statementSummary');
    Route::get('statement/online-players', 'ViewController@statementOnlinePlayers');
    Route::get('statement/room', 'ViewController@statementRoom');

    Route::get('gm/record', 'ViewController@gmRecord');
    Route::get('gm/room', 'ViewController@gmRoom');
    Route::get('gm/marquee', 'ViewController@gmMarquee');

    Route::get('activities/activities-list', 'ViewController@activitiesActivitiesList');
    Route::get('activities/rewards-list', 'ViewController@activitiesRewardsList');
    Route::get('activities/goods-list', 'ViewController@activitiesGoodsList');
    Route::get('activities/tasks-list', 'ViewController@activitiesTasksList');
    Route::get('activities/user-goods', 'ViewController@activitiesUserGoods');
    Route::get('activities/player-task', 'ViewController@activitiesPlayerTask');
    Route::get('activities/statement', 'ViewController@activitiesStatement');
    Route::get('activities/red-packet-log', 'ViewController@activitiesRedPacketLog');
    Route::get('activities/log-activity-reward', 'ViewController@activitiesLogActivityReward');

    Route::get('community/list', 'ViewController@communityList');
    Route::get('community/valid-card', 'ViewController@communityValidCard');

    Route::get('stock/apply-request', 'ViewController@stockApplyRequest');
    Route::get('stock/apply-list', 'ViewController@stockApplyList');
    Route::get('stock/apply-history', 'ViewController@stockApplyHistory');

    Route::get('agent/create', 'ViewController@agentCreate');
    Route::get('agent/list', 'ViewController@agentList');
    Route::get('agent/bills', 'ViewController@agentBills');
    Route::get('agent/valid-card', 'ViewController@agentValidCard');

    Route::get('top-up/admin', 'ViewController@topUpAdmin');
    Route::get('top-up/agent', 'ViewController@topUpAgent');
    Route::get('top-up/player', 'ViewController@topUpPlayer');

    Route::get('permission/member', 'ViewController@permissionMember');
    Route::get('permission/group', 'ViewController@permissionGroup');

    Route::get('system/log', 'ViewController@systemLog');

    Route::get('order/wechat', 'ViewController@orderWechat');
    //提现
    Route::get('order/withdrawals', 'ViewController@withdrawals');
    Route::get('order/rebates', 'ViewController@agentRebate');
    //规则
    Route::get('rules/wx-top-up', 'ViewController@wxTopUpRule');
    Route::get('rules/rebate', 'ViewController@rebateRule');

    // 微信订单
    Route::get('order/search', 'ViewController@searchWxOrder');

});

//代理商接口
Route::group([
    'middleware' => ['auth', 'agent.active'],
    'prefix' => 'agent/api',
    'namespace' => 'Agent',
], function () {
    Route::put('self/info', 'AgentController@update');
    Route::match(['put', 'post'], 'self/password', 'AgentController@updatePass');
    Route::get('self/agent-type', 'AgentController@agentType');

    Route::post('stock', 'StockController@apply');
    Route::get('stock/history', 'StockController@applyHistory');

    Route::get('subagent', 'SubAgentController@show');
    Route::post('subagent', 'SubAgentController@create');
    Route::delete('subagent/{user}', 'SubAgentController@destroy')->where('user', '[0-9]+');
    Route::match(['put', 'post'],'subagent/{child}', 'SubAgentController@updateChild')->where('child', '[0-9]+');

    Route::get('community', 'CommunityController@showCommunityList');
    Route::get('communities', 'CommunityController@getAgentOwnerCommunities');
    Route::post('community', 'CommunityController@createCommunity');
    //代理商禁止删除社区
    //Route::delete('community/{communityId}', 'CommunityController@deleteCommunity')->where('communityId', '[0-9]+');
    Route::get('community/info/{communityId}', 'CommunityController@getCommunityInfo')->where('communityId', '[0-9]+');
    Route::get('community/detail/{communityId}', 'CommunityController@getCommunityDetail')->where('communityId', '[0-9]+');
    Route::match(['put', 'post'],'community/info/{community}', 'CommunityController@updateCommunityInfo')->where('community', '[0-9]+');
    Route::get('community/card/top-up-history', 'CommunityTopUpController@getTopUpHistory');
    Route::post('community/card/top-up', 'CommunityTopUpController@topUpCommunity');
    Route::post('community/member/invitation', 'CommunityMembersController@inviteMember');
    Route::match(['put', 'post'], 'community/member/approval-application/{application}', 'CommunityMembersController@approveApplication')->where('application', '[0-9]+');
    Route::match(['put', 'post'], 'community/member/decline-application/{application}', 'CommunityMembersController@declineApplication')->where('application', '[0-9]+');
    Route::match(['put', 'post'], 'community/member/kick-out', 'CommunityMembersController@kickOutMember');
    Route::put('community/member/log/read/{community}', 'CommunityMembersController@readCommunityLog')->where('community', '[0-9]+');
    Route::get('community/room/{communityId}', 'CommunityRoomController@getCommunityOpenRoom')->where('communityId', '[0-9]+');
    Route::get('community/game-record/{communityId}', 'CommunityGameRecordController@search')->where('communityId', '[0-9]+');
    Route::match(['put', 'post'], 'community/game-record/mark/{recordInfoId}', 'CommunityGameRecordController@markRecord')->where('recordInfoId', '[0-9]+');
    Route::get('community/game-type/rules/{community}', 'CommunityGameTypeController@getGameRules')->where('community', '[0-9]+');
    Route::post('community/game-type/rule/{community}', 'CommunityGameTypeController@modifyGameRuleTemplate')->where('community', '[0-9]+');
    Route::get('community/game-type/rule', 'CommunityGameTypeController@getGameRule');

    Route::post('top-up/child/{receiver}/{type}/{amount}', 'TopUpController@topUp2Child')->where('amount', '[0-9]+');
    Route::post('top-up/player/{player}/{type}/{amount}', 'TopUpController@topUp2Player')->where('amount', '[0-9]+');
    Route::get('top-up/child', 'TopUpController@topUp2ChildHistory');
    Route::get('top-up/player', 'TopUpController@topUp2PlayerHistory');

    //返利
    Route::get('rebates', 'RebateController@index');
    Route::get('rebates/statistics', 'RebateController@statistics');
    //提现
    Route::get('withdrawals', 'WithdrawalController@index');
    Route::get('withdrawals/amount-limit', 'WithdrawalController@amountLimit');
    Route::post('withdrawals', 'WithdrawalController@store');

    Route::get('wx-top-up-rules', 'WxTopUpRuleController@index');


});

//代理商视图
Route::group([
    'middleware' => ['auth', 'agent.active'],
    'prefix' => 'agent',
    'namespace' => 'Agent',
], function () {
    Route::get('home', 'ViewController@home');

    Route::get('player/top-up', 'ViewController@playerTopUp');  //玩家充值页面

    Route::get('stock/apply-request', 'ViewController@stockApplyRequest');
    Route::get('stock/apply-history', 'ViewController@stockApplyHistory');

    Route::get('subagent/list', 'ViewController@subagentList');
    Route::get('subagent/create', 'ViewController@subagentCreate');

    Route::get('community/list', 'ViewController@communityList');
    Route::get('community/manage', 'ViewController@communityManage');
    Route::get('community/community-top-up', 'ViewController@communityTopUp');  //玩家充值页面

    //给子代理商的充值记录
    Route::get('top-up/child', 'ViewController@topUpChild');
    Route::get('top-up/player', 'ViewController@topUpPlayer');
    Route::get('top-up/community', 'ViewController@topUpCommunity');

    Route::get('info', 'ViewController@info');

    //返利管理
    Route::get('pay/rebates', 'ViewController@rebates');
    //提现申请
    Route::get('pay/withdrawals', 'ViewController@withdrawals');
    //微信订单
    Route::get('pay/wx-order', 'ViewController@wxOrder');
});

//微信回调接口
Route::group([
    'prefix' => 'wechat',
    'namespace' => 'Wechat',
], function () {
    Route::any('official-account/callback', 'OfficialAccountController@callback');  //微信公众号事件回调
    Route::post('menus','WxMenuController@store'); //编辑微信菜单
    //Route::any('official-account/authorization', 'TestWebAuthController@callback');    //网页授权回调(使用路由不需要此回调)
});

//微信视图
Route::group([
    'middleware' => ['wechat.oauth'],
    'prefix' => 'wechat',
    'namespace' => 'Wechat',
], function () {
    Route::get('web-auth', 'ViewController@webAuth');
});

//Route::any('wechat/red-packet/test', 'Wechat\RedPacketController@sendRedPacket');   //测试微信红包