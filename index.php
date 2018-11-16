<?php 
get_header();
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
$pastEvent = getPost('event',array('title','thumbnail','start_date','end_date','start_time_hr','start_time_mn','end_time_hr','end_time_mn','department','place'),'desc','',
							 array(
								array(
									'key'		=> 'end_date',
									'compare'	=> '<',
									'value'		=> date('Ymd'),
								)
							),10,array('start_date','meta_value_num')
						);
$dep = getPost('department',array('title'),'asc');
$gallery = getPost('event_gallery',array('cover','image','event'),'desc');

	$startDate = date('Y-m-01');
	$endDate = date('Y-m-t');
	$dateRange = createRange($startDate,$endDate);
	$eventbyDate = array();
	foreach($dateRange as $row){
		$eventbyDate[$row] =  getPost('event',array('title','thumbnail','start_date','start_time_hr','start_time_mn','end_time_hr','end_time_mn','end_date','department','place','abstract'),'desc','',
							 array(
								'relation' 			=> 'AND',
								array(
									'key'		=> 'start_date',
									'compare'	=> '<=',
									'value'		=> date('Ymd',strtotime($row)),
								),
								array(
									'key'		=> 'end_date',
									'compare'	=> '>=',
									'value'		=> date('Ymd',strtotime($row)),
								)
							),'',array('start_date','meta_value_num')
						);
	}
	
	$event = getPost('event',array('title','author','date','thumbnail','start_date','start_time_hr','start_time_mn','end_time_hr','end_time_mn','end_date','department','place','abstract'),'desc','',
							 array(
								'relation' 			=> 'AND',
								array(
									'key'		=> 'start_date',
									'compare'	=> '<=',
									'value'		=> date('Ymd'),
								),
								array(
									'key'		=> 'end_date',
									'compare'	=> '>=',
									'value'		=> date('Ymd'),
								)
							),'',array('start_date','meta_value_num')
						);
	
?>
<main>
		<div class="container">
			
				<div class="col-xs-12 box" id="news" style="margin-bottom:10px;">
					<div class="title line">กิจกรรมไฮไลท์</div>
					
					<?php foreach($hilightContent as $key=>$row){ ?>
						
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-xxs-12 news-article" <?php echo $key==1 || $key==3 ? 'style="padding-right:10px;"' : NULL ?>>
							<a href="<?php echo bloginfo('url')?>/event/?id=<?php echo $row['id']?>" target="_blank">
								<div class="news-thumb">
									<img src="<?php echo $row['thumb']?>"/>
									
								</div>
								<div class="title">
									<div class="text"><?php echo $row['title']?></div>
									<div class="date">
										<span><i class="fa fa-calendar"></i> <?php echo DateThai($row['start_date'])?></span>
										<span><i class="fa fa-clock-o"></i> <?php echo $row['start_time']?></span>
									</div>
								</div>
							</a>
						</div>
					
					<?php } ?>
					
					
				</div>
				<div class="col-xs-12 box" id="calendar" style="margin-bottom:30px;">
				<div class="col-xs-12">
					<div class="title line">ปฏิทินกิจกรรม</div>
					<div class="text-right" style="margin-bottom:10px">
						<div class="btn-group" role="group" aria-label="Basic example">
							<a href="http://special.thaipbs.or.th/orgevent/wp-admin" class="btn btn-default"><i class="fa fa-pencil-square-o"></i> จัดการ</a>
						  <button type="button" class="btn btn-default"  id="dp-month" data-date=""><i class="fa fa-calendar"></i> เปลี่ยนเดือน</button>
						  <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#searchbox"><i class="fa fa-search"></i> ค้นหา</button>
						  
						</div>
					</div>
					<div id="searchbox" class="skm row collapse">
							
					<form class="form-horizontal" class="form-horizontal" id="search-form" method="POST" action="<?php echo get_bloginfo('url')?>/submit?fn=searchEvent">
									<div class="col-lg-4">
										<div class="form-group">
											<label>ชื่อเรื่อง</label>	
											<div>
												<input type="text" name="title" id="title" class="form-control" />
											</div>
										</div>
									
									</div>
									
									<div class="col-lg-3">
										<div class="form-group">
											
											<label>สำนัก</label>
											<div>
												<select name="dep" id="dep" class="form-control">
													<option value="">----------ทั้งหมด----------</option>
													<?php foreach($dep as $key=>$row){ ?>
														<option value="<?php echo $row['id']?>"><?php echo $row['title']?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										
									</div>
									
									<div class="col-lg-4">
										<div class="form-group">
											<label class="col-lg-3 text-right">เริ่มต้น</label>
											<div class="col-lg-9">
												<input type="text" name="start_date" id="start_date" class="form-control dp"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 text-right">สิ้นสุด</label>
											<div class="col-lg-9">
												<input type="text" name="e_date" id="e_date" class="form-control dp"/>
											</div>
										</div>
									</div>
									
								
									
								
									<div class="col-lg-1">
										<div class="submit"><button type="submit" title="ค้นหา" class="btn btn-sm btn-success"><i class="fa fa-search"></i></div>
										
									</div>
								
							
								
							</form>
						
							
						</div>
						
				</div>
				<div class="col-xs-6">
						
			
				
									
				<div class="responsive-calendar">
				<div class="controls title solid">
					<a href="#" class="prev pull-left" data-go="prev" id="prev-month"><i class="fa fa-arrow-circle-left"></i></a>
					<h4><span data-head-month></span> <span data-head-year></span> </h4>
					
					<a href="#" class="next pull-right" data-go="next" id="next-month"><i class="fa fa-arrow-circle-right"></i></a>
				</div>
				<div class="day-headers">
				  <div class="day header">จันทร์</div>
				  <div class="day header">อังคาร</div>
				  <div class="day header">พุธ</div>
				  <div class="day header">พฤหัสบดี</div>
				  <div class="day header">ศุกร์</div>
				  <div class="day header">เสาร์</div>
				  <div class="day header">อาทิตย์</div>
				</div>
				<div class="days" data-group="days">
				  
				</div>
			  </div>
	  
	  </div>
	  
	<div class="col-xs-6">
			
		
				 <div class="loading"></div>
	<div class="title skb" style="margin-bottom:0px"><span id="dateTitle"><?php echo DateThai(date('Ymd'),true)?></span>	<span class="eventCount"><span class="label label-info"><span class="num"><?php echo count($event)?></span> กิจกรรม</span>  </span></div>

	<div class="event-info">
	<?php if(!empty($event)){ ?>
		<?php foreach($event as $key=>$row){ 
					$start_date = date('Ymd',strtotime($row['start_date']));
					$end_date = date('Ymd',strtotime($row['end_date']));
		?>
						<article class="horizontal">
							<a href="<?php bloginfo('url')?>/event?id=<?php echo $row['id']?>">
							<div class="row">
								
								<div class="image col-lg-4 col-md-4">
									<img src="<?php echo $row['thumbnail']['url']?>" class="img-responsive" />
								</div>
								<div class="content col-lg-8 col-md-8">
									<h2><?php echo moretext($row['title'],130)?></h2>
									<div class="desc">
										
										<span><i class="fa fa-calendar"></i><?php 
										if($start_date == $end_date){
											echo DateThai($row['start_date']);
										}
										else{
											echo DateThai($row['start_date']).' - '.DateThai($row['end_date']);
										}
										?>
											</span>
											<span><i class="fa fa-clock-o"></i><?php echo $row['start_time_hr'].':'.$row['start_time_mn']?></span>
											<br /><span>โดย :  <?php echo $row['department']->post_title?></span>
									</div>
									
									
								</div>
							</div>
							</a>
						</article>
						<?php } ?>
	<?php }else{ ?>
			<div class="alert alert-warning skb" style="margin-top:10px">
    <strong>ไม่พบข้อมูลกิจกรรมที่เกี่ยวข้องในขณะนี้ !</strong>
  </div>		
					
	<?php } ?>
				</div>
				
	</div>	
</div>
				<div class="col-xs-12 box" id="gallery" style="margin-bottom:10px;">
						<div class="title line">ภาพกิจกรรม</div>
						<?php if(!empty($gallery)){ ?>
						<?php foreach($gallery as $key=>$row){ ?>
						<a href="#" class="gallery-<?php echo $key?>">
							<article class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
								<div class="image">
										<img class="img-responsive" src="<?php echo $row['cover']['url']?>">
										<div class="options static skm">
											<i class="fa fa-camera"></i> <?php echo count($row['image'])?></div>
								</div>
								<div class="content">
									<div class="title klight" style="font-weight:bold;"><?php echo $row['event']->post_title?></div>
									
								</div>
							</article>
						</a>
						<?php 
						if(!empty($row['image'])){
							
							echo '<script type="text/javascript">
									$(".gallery-'.$key.'").click(function(e) {
										e.preventDefault();
										$.fancybox.open([';
							foreach($row['image'] as $gkey=>$grow){
								echo '
								
									
										{
											href : "'.$grow['url'].'",
											title : "'.$grow['title'].'"
										}, ';
									
									
							}
							echo '
								], {
									helpers : {
										thumbs : {
											width: 75,
											height: 50
										}
									},
									openEffect : "none",
									closeEffect : "none",
									prevEffect : "none",
									nextEffect : "none"
							});
							});
							</script>';
						}
						}
						?>
						<?php 
						} 
						else{
							
							?>
							<div class="alert alert-warning">
								ติดตามข้อมูลภาพกิจกรรมได้เร็วๆนี้...
							</div>
							<?php
						}
						?>
				</div>
				
				
				
		</div>
</main>
<?php get_footer();?>
<script type="text/javascript">
function loadingBegin(){
	$('.loading').show();
	$('.event-info').html('');
	var $html = '<div class="progress progress-striped active"><div class="progress-bar progress-bar-success" style="width:0%"></div></div>';
	$('.loading').html($html);
	$(".progress-bar").animate({
		width: "100%"
	}, 300);
}
function loadingBeginNoHide(){
	$('.loading').show();
	var $html = '<div class="progress progress-striped active"><div class="progress-bar progress-bar-success" style="width:0%"></div></div>';
	$('.loading').html($html);
	$(".progress-bar").animate({
		width: "100%"
	}, 300);
}
function loadingSuccess(){
	$('.loading').hide();
}
function getMonthEvent(yNum,mNum,isDp = 0){
		  $.ajax({
			type : 'POST',
			url : '<?php bloginfo('url')?>/submit?fn=getMonthEvent',
			data : 'mth='+mNum+'&yr='+yNum+'&dp='+isDp,
			dataType : 'JSON',
			beforeSend : function(){  loadingBeginNoHide(); },
			success : function(data){
				loadingSuccess();
				var eventData = {};
				$.each(data.monthObj,function(key,row){
					if(row.length > 0){
						var subEvent = {};
						subEvent['number'] = row.length;
						eventData[key] = subEvent;
					}
				})
			
				$('.responsive-calendar').responsiveCalendar('edit', eventData);
				$('#dateTitle').html(data.title);
				$('.event-info').html(data.html);
				$('#dateTarget').val(data.date);
				$('.eventCount .num').text(data.count);
			}
		})
	  }

$(document).ready(function(){
				$('#dp-month').datepicker({ format: 'yyyy-mm', language: 'th' , viewMode: "months", minViewMode: "months"}).on('changeDate', function(ev){
						var selectedMonthYear = $('#dp-month').data('datepicker').getFormattedDate('yyyy-mm');
						var selectedMonth = $('#dp-month').data('datepicker').getFormattedDate('mm');
						var selectedYear = $('#dp-month').data('datepicker').getFormattedDate('yyyy');
						$('#dp-month').datepicker('hide');
						console.log(selectedYear+'/'+selectedMonth);
						getMonthEvent(selectedYear,selectedMonth,1);
						$('.responsive-calendar').responsiveCalendar(selectedMonthYear);
						
				});
	$('.dp').datepicker({ format: 'dd/mm/yyyy', language: 'th' });
	
	 $(".responsive-calendar").responsiveCalendar({
          time: '<?php echo date('Y-m')?>',
          events: {
			  <?php 
			  foreach($eventbyDate as $key=>$row){ 
			   if(count($row) > 0){
			  ?>
					"<?php echo $key ?>": {"number": <?php echo count($row)?>},
			  <?php 
			   }
			  } 
			  ?>
          }
        });
		
		$(document).on('click','.responsive-calendar .day.active a',function(e){
			e.preventDefault();
			$.ajax({
				type : 'POST',
				url : '<?php bloginfo('url')?>/submit?fn=getDayEvent',
				data : 'date='+$(this).data('day')+'-'+$(this).data('month')+'-'+$(this).data('year'),
				dataType : 'JSON',
				beforeSend : function(){ loadingBegin(); },
				success : function(data){
					loadingSuccess();
					$('#dateTitle').html(data.title);
					$('.event-info').html(data.html);
					$('#dateTarget').val(data.date);
					$('.eventCount .num').text(data.count);
				}
			})
		})
		
	$('#search-form').submit(function(e){
		e.preventDefault();
		$.ajax({
			type : 'POST',
			url : $(this).attr('action'),
			data : $(this).serialize(),
			dataType : 'JSON',
			beforeSend : function(){ loadingBegin(); },
			success : function(data){
				loadingSuccess();
				console.log(data);
				$('.eventCount .num').text(data.count);
				$('#dateTitle').html(data.title);
				$('.event-info').html(data.html);
			}
		})
	});
	$(document).on('click','#prev-month,#next-month,#dp-month',function(e){
		e.preventDefault();
	});

})
</script>