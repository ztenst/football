<?php 
class MatchController extends HomeController{
	public function actionIndex($time='',$lid='')
	{
		$criteria = new CDbCriteria;
		if($time) {
			$time = strtotime($time);
			$criteria->addCondition('time>=:t1 and time<:t2');
			$criteria->params[':t1'] = TimeTools::getDayBeginTime($time);
			$criteria->params[':t2'] = TimeTools::getDayEndTime($time);
		} else {
			$criteria->addCondition('time>=:t1');
			$criteria->params[':t1'] = TimeTools::getDayBeginTime(time()-86400);
		}
		if($lid) {
			$criteria->addCondition('lid=:lid');
			$criteria->params[':lid'] = $lid;
		}
		$matchs = MatchExt::model()->normal()->findAll($criteria);
		$this->render('index',['matchs'=>$matchs,'time'=>$time,'lid'=>$lid]);
	}
}