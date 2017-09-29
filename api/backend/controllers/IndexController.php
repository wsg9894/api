<?php
namespace backend\controllers;
use yii;
use yii\web\Session;
use yii\web\Controller;
class IndexController extends Controller
{
	//后台登录接口
	public function actionIndex()
	{
		$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
		$username = isset($_GET['username']) ? $_GET['username'] : '';
		$password = isset($_GET['password']) ? $_GET['password'] : '';
		$md5_password = md5($password);
		if(!empty($username) && !empty($password))
		{
			$sql = "SELECT uid,user_name,password FROM user WHERE user_name = '$username'";
			$user = Yii::$app->db->createCommand($sql)->queryOne();
			if($user)
			{
				if($md5_password == $user['password'])
				{
					$session = Yii::$app->session;
					$session->set('username',$username);
					echo $callback.'('.json_encode(array('status'=>100,'msg'=>$user['uid'])).')';
				}
				else
				{
					echo $callback.'('.json_encode(array('status'=>103,'msg'=>'密码错误')).')';
				}
			}
			else
			{
				echo $callback.'('.json_encode(array('status'=>102,'msg'=>'用户名不存在')).')';
			}
		}
		else
		{
			echo $callback.'('.json_encode(array('status'=>101,'msg'=>'用户名或密码不可为空')).')';
		}
	}
}