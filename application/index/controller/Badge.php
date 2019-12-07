<?php

namespace app\index\controller;

use addons\badge\model\Badgelog;
use addons\badge\model\BadgeUser;
use app\common\controller\Frontend;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use fast\Date;

/**
 * 钩子控制器
 */
class Badge extends Frontend
{
    protected $layout = 'default';
   protected $noNeedRight = ['*'];

    /**
     * badgecenter
     * @return string
     */
    public function badgecenter()
    {
      $config = get_addon_config('badge');
     //勋章列表
     $badgelist = \addons\badge\model\Badge::where('id', '>', 0)->select();
     //  ->field('name,shuoming,image,jifen')
      $this->view->assign('badgelist', $badgelist);


      $this->view->assign('addonConfig', $config);
        return $this->view->fetch();

    }



    /**
     * mybadges
     * @return string
     */
    public function mybadges()
    {
       $config = get_addon_config('badge');
       //勋章中心列表
       $badgelist = \addons\badge\model\Badge::where('id', '>', 0)->select();
 
       $badgeloglist = Badgelog::where(['user_id' => $this->auth->id])
        ->order('id desc')
        ->paginate(10);

       //循环输出badge_log中的badge_id字段   
       $badgeids = [];
       foreach ($badgeloglist as $item => $value) {
       $badgeids[] = $value['badge_id'];
       }
       //用户已获得勋章列表
       $user_badges = [];
      foreach ($badgeids as $vv)
      {
      $user_bids = \addons\badge\model\Badge::where('id', '=', $vv)->field('name,shuoming,image,jifen')->select();
        foreach ($user_bids as $bids) {
          $user_badges[] = $bids;
          }
      }

       //条件判断如果badge_user表中存在该用户的数据就执行更新方法，如果不存在就新增一条数据，每个用户只存在一条数据
      $badges = \addons\badge\model\BadgeUser::where('user_id', $this->auth->id)->find();
      if ($badges) {
       $badges->badges = json_encode($user_badges);
       $badges->save();
       } else {
       \addons\badge\model\BadgeUser::create(['user_id' => $this->auth->id,'badges' => json_encode($user_badges), 'createtime' => time()]);
      }


 
 //定义添加的徽章按照配置的积分规则自动分配到会员
 $ssitem = [];
 $score = $this->auth->score;
foreach ($badgelist as $it => $ss) {
 $name = $ss['name'];
 $jifen = $ss['jifen'];
 $ssid = $ss['id'];
 if ($score >= $jifen) {
  $badge = \addons\badge\model\Badgelog::where('user_id', $this->auth->id)->where('badge_id', $ssid)->select();
    if ($badge) {
              //  $this->error('您已经领取过了!');
            } else {
  Db::startTrans();
                try {
                    \addons\badge\model\Badgelog::create(['user_id' => $this->auth->id, 'badge_id' => $ssid, 'createtime' => time()]);
                
                    Db::commit();
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error('失败,请稍后重试');
                }
          $this->success('恭喜您获得了新的徽章!');
        }
                       }

}


$this->view->assign('badgelist', $badgelist);
$this->view->assign('addonConfig', $config);
$this->view->assign('user_badges', $user_badges);
$this->view->assign('badgeloglist', $badgeloglist);
        return $this->view->fetch();
    }


}