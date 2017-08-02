
            <?php if($matchs): ?>
            <div class="widget d_textbanner"><a class="style01" style="color: #00b7ee" href="<?=$this->owner->createUrl('/home/match/index')?>"><strong style="background-color:#00b7ee;margin-top: 5px" >热门比赛</strong>
            <div style="margin-bottom: 11px">
                <ul>
                <?php foreach ($matchs as $key => $value) {?>
                    <li>
                        <div style="display: inline-flex;width: 100%;">
                        <style type="text/css">
                            .c1{
                                width: 40%;
                                margin-left:20px;
                                margin-top:10px;
                                margin-right:10px;
                            }
                            .im1{
                                height: 50px;
                                width: 50px
                            }
                            .c2{
                                width: 100px;
                                padding-top: 20px
                            }
                            .p1{
                                padding-left: 0 !important;padding-right: 0 !important;
                                font-family: -webkit-pictograph;
                            }
                        </style>
                            <div class="c1">
                                <div class="match-img" style="width: 60px">
                                    <center><img class="im1" src="<?=ImageTools::fixImage($value->home_team->image)?>">
                                    <span><?=$value->home_name?></span></center>
                                </div>
                            </div>
                            <div class="c2">
                            <center>
                            <p class="p1" style="padding-bottom: 5px">
                                <span><?=$value->league->name?></span>
                                </p>
                                <p class="p1">
                                <span style="font-size: 30px"><?=$value->home_score.' : '.$value->visitor_score?></span>
                                </p>
                                </center>
                            </div>
                            <div class="c1"><div class="match-img" style="width: 60px"><center><img class="im1" src="<?=ImageTools::fixImage($value->visit_team->image)?>">
                            <span><?=$value->visitor_name?></span></center></div></div>
                        </div>
                    </li>
                    <?php if($key<count($matchs)-1):?>
                    <hr style="margin-top: 5px;margin-bottom: 5px"><?php endif;?>
                <?php } ?>
                </ul>
            </div>
            </a></div><?php endif;?>
            <div class="widget widget_categories d_textbanner"><strong class="str1" style="margin-top: 5px">积分榜</strong>
               <div class="row" style="width: 90%;margin:0 auto">
                   <ul class="nav nav-tabs" style="margin-bottom: 0px;">
                   <?php if($leas) foreach ($leas as $key => $value) {?>
                       <li class="<?=$key==0?'active':''?> tabli1">
                            <a class="tab1" style="font-size: 14px" href="#tab_1_<?=$key+1?>" data-toggle="tab">
                            <center><?=$value->name?> </center></a>
                        </li>
                  <?php  } ?>
                    </ul>
                    <div class="tab-content">
                    <?php foreach ($points as $key => $value) {?>
                        <div class="tab-pane fade <?=$key==0?'active':''?> in" id="tab_1_<?=$key+1?>">
                        <?php if($value): ?>
                            <table class="table table-striped table-hover" style="margin-top: -1px;font-size: 12px">
                            <?php for ($i=0; $i < count($value); $i++) { 
                                for ($j=$i+1; $j < count($value); $j++) { 
                                    if($value[$j]['points']>$value[$i]['points']) {
                                        $t = $value[$i];
                                        $value[$i] = $value[$j];
                                        $value[$j] = $t;
                                    }
                                }
                            } ?>
                                <?php foreach ($value as $r => $v) { $team = $v->team; ?>
                                    <tr>
                                            <td align='center'><?=$r+1?></td>
                                            <td align='center' style="width: 40%"><img src="<?=ImageTools::fixImage($team->image)?>" style="width: 20px;height:20px;float: left" alt="">&nbsp;<?=Tools::u8_title_substr($team->name,12) ?></td>
                                            <td  align='center'>胜<?=$v->win?>负<?=$v->lose?></td>
                                            <td align='center'><?=$v->points?></td>
                                        </tr>
                                <?php } ?>
                                    </table>
                                <?php endif; ?>
                        </div>
                    <?php } ?>
                    </div>
               </div>
            </div>
<?php $nopic = SiteExt::getAttr('qjpz','newsImg')?>
            <div class="widget d_postlist">

                <div class="title">
                    <span class="title_span" style="padding-left: 0;padding-right: 0"><strong style="background-color:#00b7ee;color: white;padding: 4px 15px;">热门推荐</strong></span></div>
                <ul>
                <?php if($rmtjs) foreach ($rmtjs as $key => $v) {  $value = $v->getObj();  if($value): ?>
                   <li>
                   <a href="<?=$this->owner->createUrl('/home/news/info',['id'=>$value->id])?>" title="<?=$value->title?>" style="padding-bottom: 0">
                   <span class="thumbnail" style="border: none"><img src="<?=ImageTools::fixImage($value->image?$value->image:$nopic)?>" /></span>
                   <span class="text"><?=$value->title?></span>
                   <span class="muted"><?=date('Y-m-d',$value->updated)?></span><span class="muted_1"><?=$value->comment_num?>评论</span>
                   </a></li>
                <?php endif; } ?>
                </ul>
            </div>
            <style type="text/css">
                        .fa{
                                line-height: initial;
                        }
                        .str1{
                            color: #fff;
                            display: inline-block;
                            font-size: 14px;
                            font-weight: normal;
                            margin: -1px 0 0;
                            margin-left: 15px;
                            padding: 4px 15px;background-color: #00b7ee;
                        }
                    </style>
            <style type="text/css">
                       .tabli1{
                        width: 33% !important;
                       }
                       .tab1{
                        margin-left: 0!important;
                        padding-right: 0!important;
                        padding-left: 0;padding-right: 0!important;
                        border: none !important;
                       }
                   </style>
            