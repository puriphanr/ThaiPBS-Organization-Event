<?php
/*
Template name: event
*/
get_header();
$event = getPost('event',array('title','author','date','thumbnail','start_time_hr','start_time_mn','end_time_hr','end_time_mn','department','place','description','start_date','end_date','contact_name','tel','email','website'),'desc',$_GET['id']);

?>
<main>
		<div class="container">
			<div class="col-lg-12 col-md-12 box-breadcrumb">
				<ol class="breadcrumb">
				  <li><a href="<?php echo bloginfo('url')?>">หน้าหลัก</a></li>
				  <li class="active">กิจกรรม</li>
				</ol>
			</div>
			<div class="col-xs-8" style="margin-bottom:10px;">
			<div class="blog-post">
				<h1 id="title" class="skb blog-post-title"><?php echo $event[0]['title']?></h1>
					<div class="skm createBy">
						<div class="pull-left">แก้ไขล่าสุดโดย <?php echo $event[0]['author']?></div>
						<div class="pull-right">เมื่อวันที่ <?php echo DateThai($event[0]['date'])?> เวลา <?php echo $event[0]['time']?></div>
					</div>
					<div class="clear"></div>
			
				
				<div class="featured-image">
					<img src="<?php echo $event[0]['thumbnail']['url']?>" class="img-responsive" style="margin: auto;">
				</div>
					<div class="skm blog-post-meta">
					<div class="col-lg-12 info">
						<h3>ข้อมูลกิจกรรม</h3>
						<ul class="list-unstyled meta-list">
							<li>
							<i class="fa fa-calendar"></i> <strong>วันที่ :</strong> 
					<?php 
									$start_date = date('Ymd',strtotime($event[0]['start_date']));
									$end_date = date('Ymd',strtotime($event[0]['end_date']));
									
										if($start_date == $end_date){
											echo DateThai($event[0]['start_date']);
										}
										else{
											echo DateThai($event[0]['start_date']).' - '.DateThai($event[0]['end_date']);
								
										}
									?>
							</li>
							<li>
							 <i class="fa fa-clock-o"></i> <strong>เวลา :</strong>   
									<?php
											
												echo $event[0]['start_time_hr'].':'.$event[0]['start_time_mn'].'  น.';
											
											?>
							</li>
							<li>
								<i class="fa fa-map-marker"></i> <strong>สถานที่ : </strong> <?php echo $event[0]['place']?>
							</li>
							<li>
								<i class="fa fa-building"></i> <strong>จัดโดย : </strong> <?php echo $event[0]['department']->post_title?>
							</li>
						</ul>
					</div>
					<div class="col-lg-12 contact">
						<h3>ข้อมูลการติดต่อ</h3>
						<ul class="list-unstyled meta-list">
							<li>
								<i class="fa fa-user"></i> <strong>ผู้ประสานงาน : </strong> <?php echo $event[0]['contact_name']?>
							</li>
							<li>
								<i class="fa fa-phone-square"></i> <strong>โทรศัพท์ : </strong> <?php echo $event[0]['tel']?>
							</li>
							<li>
								<i class="fa fa-envelope"></i> <strong>อีเมล : </strong> <a href="mailto:<?php echo $event[0]['email']?>"><?php echo $event[0]['email']?></a>
							</li>
							<li>
								<i class="fa fa-globe"></i> <strong>เว็บไซต์ : </strong> <a href="<?php echo $event[0]['website']?>" target="_blank"><?php echo $event[0]['website']?></a>
							</li>
						</ul>
					</div>
					
				</div>
				<div class="body">
						<div class="abstract"><?php echo $event[0]['abstract']?></div>
						<?php echo $event[0]['description']?>
				</div>
								
							
			</div>
			
			</div>
			<?php get_sidebar()?>
		
		</div>
</main>
<?php get_footer();?>