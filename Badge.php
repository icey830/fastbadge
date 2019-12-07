<?php
namespace addons\badge;

use app\common\library\Menu;
use app\common\model\User;
use fast\Date;
use think\Addons;
use think\Config;
use think\Request;
use think\Route;

/**
 * 会员勋章
 */
class Badge extends Addons
{

    /**
     * 安装方法
     * @return bool
     */
    public function install()
    {
        $menu=[
        
          [
            "name" => "badge",
            "title" => "会员勋章",
            "icon" => "fa fa-shield",
            "sublist" => [
                [
                    "name" => "badge/badge",
                    "title" => "勋章设置",
                    "icon" => "fa fa-cog",
                    "sublist" => [
                        ['name' => 'badge/badge/index', 'title' => '查看'],
                        ['name' => 'badge/badge/add', 'title' => '添加'],
                        ['name' => 'badge/badge/edit', 'title' => '编辑'],
                        ['name' => 'badge/badge/del', 'title' => '删除'],
                        ['name' => 'badge/badge/multi', 'title' => '批量更新'],
                        
                     ]
                ],
                [
                    "name" => "badge/badgelog",
                    "title" => "会员勋章分配",
                    "icon" => "fa fa-id-badge",
                    'sublist' => [
                        ['name' => 'badge/badgelog/index', 'title' => '查看'],
                        ['name' => 'badge/badgelog/add', 'title' => '添加'],
                        ['name' => 'badge/badgelog/del', 'title' => '删除'],
                        ['name' => 'badge/badgelog/multi', 'title' => '批量更新'],
                    ]
        
                ],
              ]
          ]

        ];
       
        Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {

        Menu::delete('badge');
        return true;
    }

    /**
     * 插件启用方法
     */
    public function enable()
    {
         Menu::enable('badge');
         return true;
    }

    /**
     * 插件禁用方法
     */
    public function disable()
    {
        Menu::disable('badge');
        return true;
    }

        /**
     * 会员中心边栏后
     * @return mixed
     * @throws \Exception
     */
    public function userSidenavAfter()
    {
        $request = Request::instance();
        $actionname = strtolower($request->action());
        $data = [
            'actionname' => $actionname
        ];
        return $this->fetch('view/hook/user_sidenav_after', $data);
    }

        /**
     * 会员勋章展示方法
     * @return mixed
     * @param   $user_id 
     *  调用钩子的时候获取该参数  钩子用法 {:hook('mybadges', $user.id)} 第二个参数就是该参数
     */
    
    public function mybadges($user_id)
    {
      $request = Request::instance();
       // print_r($user_id);
      $badgelist =  \addons\badge\model\BadgeUser::where('user_id', $user_id)->find();

      $mybadges = json_decode($badgelist['badges']);
 if($mybadges){
   foreach ($mybadges as $obj) {
  echo "<a style='margin-right: 5px;' type='button' data-toggle='tooltip' data-placement='top' title='".$obj->name."'><img style='height:40px;width:35px;' src='".$obj->image."' ></a>";
      }
  } else {
  echo "<p style='color:#E91E63;'>您还没有获得任何勋章！</p>";
  }

     return $this->fetch('view/hook/mybadges');

    }

}
