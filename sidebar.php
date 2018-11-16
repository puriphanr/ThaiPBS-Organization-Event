<?php
$pastEvent = getPost('event',array('title','thumbnail','start_time','end_time','department','place'),'desc','',
							 array(
								array(
									'key'		=> 'end_time',
									'compare'	=> '<',
									'value'		=> strtotime(date('Ymd')),
								)
							),10,array('start_time','meta_value_num')
						);
$hilight = getPost('hilight',array('activity'),'asc');
$hilightContent = array();
foreach($hilight as $key=>$row){
	$act_row = getPost('event',array('title','thumbnail','abstract','start_date','start_time_hr','start_time_mn'),'asc',$row['activity']->ID);
	$hilightContent[$key] = array(
									'id'=>$act_row[0]['id'],
									'title'=>$act_row[0]['title'],
									'thumb'=>$act_row[0]['thumbnail']['url'],
									'abstract'=>$act_row[0]['abstract'],
									'start_date'=>$act_row[0]['start_date'],
									'start_time'=>$act_row[0]['start_time_hr'].':'.$act_row[0]['start_time_mn']
								  );
}
						?>
						
<div class="col-lg-4 col-md-4 box" style="margin-bottom:10px;">
	<?php if(!empty($hilight)){ ?>
	<div id="past">
							<div class="title grey-bar">กิจกรรมไฮไลท์</div>
							<ul class="list-event">
							<?php foreach($hilightContent as $key=>$row){ ?>
							<li>
											<div class="pull-left image" style="margin-right: 10px;"><img src="<?php echo $row['thumb']?>" width="140" height="75"></div>
											<a href="<?php echo bloginfo('url')?>/event/?id=<?php echo $row['id']?>" target="_blank"><?php echo $row['title']?></a>
											
										</li>
							<?php } ?>
							</ul>
						</div>
	<?php } ?>
	<?php if(!empty($pastEvent)){ ?>
	<div id="past">
							<div class="title grey-bar">กิจกรรมที่ผ่านไปแล้ว</div>
						</div>
						<ul class="list-event">
							<?php foreach($pastEvent as $key=>$row){ ?>
							<li>
							<a href="<?php bloginfo('url')?>/event?id=<?php echo $row['id']?>" target="_blank">
								<?php echo $row['title']?>
							</a>
							<div class="datetime"><?php echo DateThai(date('Y-m-d',strtotime($row['start_time'])),true)?></div>
							</li>
							<?php } ?>
						</ul>
	<?php } ?>
</div>