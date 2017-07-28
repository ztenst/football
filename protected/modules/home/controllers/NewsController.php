<?php
class NewsController extends HomeController{

	public $cates = [];

	public $rights = [];

	// public $kw = '';

	public function init()
	{
		parent::init();
		$this->cates = CHtml::listData(ArticleCateExt::model()->normal()->findAll(),'id','name');
		// 热门推荐
        $rmtjs = RecomExt::getObjFromCate(2,6);
        // 三个联赛
        $leas = LeagueExt::model()->normal()->findAll(['limit'=>3]);
        // 积分
        $points = [];
        if($leas) {
            foreach ($leas as $key => $value) {
                $criteria = new CDbCriteria;
                $criteria->addCondition('lid=:lid');
                $criteria->params[':lid'] = $value->id;
                $criteria->order = 'points desc';
                $criteria->limit = 10;
                $points[] = PointsExt::model()->findAll($criteria);

            }
        }
        // 十个评论
        $comms = CommentExt::model()->normal()->findAll(['limit'=>10,'order'=>'praise desc, created asc']);
        $this->rights = ['leas'=>$leas,'points'=>$points,'rmtjs'=>$rmtjs,'comms'=>$comms];
	}
	public function actionList($cid='',$kw='',$tag='')
	{
		$criteria = new CDbCriteria;
		if($kw) {
			$criteria->addSearchCondition('title',$kw);
			$this->kw = $kw;
		}
		if($cid) {
			$cate = ArticleCateExt::model()->find(['condition'=>"pinyin='$cid'"]);
			$seo = json_decode($cate->seo,true);
			if(isset($seo['t']) && $seo['t'])
				$this->pageTitle = $seo['t'];
			if(isset($seo['d']) && $seo['d'])
				$this->description = $seo['d'];
			if(isset($seo['k']) && $seo['k'])
				$this->keyword = $seo['k'];
			$criteria->addCondition('cid=:cid');
			$criteria->params[':cid'] = $cate->id;
			$cid = $cate->id;
		}
		if($tag) {
			$tag = TagExt::model()->find(['condition'=>"pinyin='$tag'"]);
			$tagName = $tag->name;
			$t = SiteExt::getAttr('seo','home_news_tag_title');
	        $k = SiteExt::getAttr('seo','home_news_tag_keyword');
	        $d = SiteExt::getAttr('seo','home_news_tag_desc');

	        foreach (['{site}'=>'球布斯','{tag}'=>$tagName] as $key => $value) {
	        	$t && $this->pageTitle = str_replace($key, $value, $t);
		        $k && $this->keyword = str_replace($key, $value, $k);
		        $d && $this->description = str_replace($key, $value, $d);
	        }
			
			$datas = ArticleTagExt::findNewsByTag($tag->id,20);
		} else {
			$datas = ArticleExt::model()->normal()->getList($criteria,20);
		}
		$infos = $datas->data;
		$pager = $datas->pagination;
		if($infos) {
			$ids = '';
			foreach ($infos as $key => $value) {
				$ids .= $value->id.',';
			}
			setCookie('news_list_ids',trim($ids));
		}
        // var_dump($this->cates);exit;
		$this->render('list',['infos'=>$infos,'pager'=>$pager,'cid'=>$cid,'cates'=>$this->cates,'rights'=>$this->rights]);
	}

	public function actionInfo($id='')
	{
		$info = ArticleExt::model()->findByPk($id);
		$this->obj = $info;
		$t = SiteExt::getAttr('seo','home_news_info_title');
        $k = SiteExt::getAttr('seo','home_news_info_keyword');
        $d = SiteExt::getAttr('seo','home_news_info_desc');
        $t && $this->pageTitle = $t;
        $k && $this->keyword = $k;
        $d && $this->description = $d;
		// var_dump($this->user);exit;
		
		$info->hits += 1;
		$info->save();
		$nextid = $preid = '';
		$lists = $_COOKIE['news_list_ids'];
		if(isset($lists) && $lists) {
			$lists = explode(',', $lists);
			foreach ($lists as $key => $value) {
				if($id==$value) {
					isset($lists[$key+1]) && $nextid = $lists[$key+1];
					isset($lists[$key-1]) && $preid = $lists[$key-1];
				}
			}
		}
		$this->render('info',['info'=>$info,'rights'=>$this->rights,'nextid'=>$nextid,'preid'=>$preid]);
	}

	public function actionSetPraise($id='')
	{
		if(!$this->user) {
			echo json_encode(['msg'=>'请登陆后操作','s'=>'error']);
		} else {
			$uid = $this->user->id;
			if(Yii::app()->db->createCommand("select id from praise where uid=$uid and cid=$id")->queryScalar()) {
				echo json_encode(['msg'=>'您已点过赞','s'=>'error']);
			} else {
				$praise = new PraiseExt;
				$praise->uid = $uid;
				$praise->cid = $id;
				$praise->save();
				$info = CommentExt::model()->findByPk($id);
				$info->praise += 1;
				$info->save();
				echo json_encode(['num'=>$info->praise,'s'=>'success']);
			}
		}
	}
}