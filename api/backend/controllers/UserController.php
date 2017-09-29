<?php
namespace backend\controllers;
use yii;
use yii\web\Controller;
class UserController extends Controller
{
	//列表展示
	public function actionIndex()
	{
		$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
		$sql = "SELECT * FROM `user` AS u INNER JOIN `video_type` AS v ON u.t_id = v.t_id";
		$user = Yii::$app->db->createCommand($sql)->queryAll();
		echo $callback.'('.json_encode($user).')';
	}

	//删除
	public function actionDel()
	{
		$uid = isset($_GET['uid']) ? $_GET['uid'] : '';
		$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
		if(!empty($uid))
		{
			$sql = "UPDATE user SET status = 0 WHERE uid = $uid";
			$user = Yii::$app->db->createCommand($sql)->execute();
			if($user)
			{
				echo $callback.'('.json_encode(array('status'=>110,'msg'=>'删除成功')).')';
			}
		}
		else
		{
			echo $callback.'('.json_encode(array('status'=>105,'msg'=>'缺少必要的参数')).')';
		}
	}
}
