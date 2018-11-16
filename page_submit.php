<?php
/*
Template name: submit
*/
function createHTML($data,$search = false){
	//print_r($data);
	$html = " ";
	if(!empty($data)){
		foreach($data as $key=>$row){
					$start_date = date('Ymd',strtotime($row['start_date']));
					$end_date = date('Ymd',strtotime($row['end_date']));
					
					$html .= '<article class="horizontal">';
					$html .= '<a target="_blank" href="'.get_bloginfo('url').'/event?id='.$row['id'].'">';
						$html .= '<div class="row">';
					
									$html .= '<div class="image col-lg-4 col-md-4">
										<img src="'.$row['thumbnail']['url'].'" class="img-responsive" />
									</div>
									<div class="content col-lg-8 col-md-8">
										<h2>'.moretext($row['title'],130).'</h2>
										<div class="desc">
											<span><i class="fa fa-calendar"></i>';
										if($start_date == $end_date){
											$html .= DateThai($row['start_date']);
										}
										else{
										$html .= DateThai($row['start_date']).' - '.DateThai($row['end_date']);
										}

									$html .='</span>
											<span><i class="fa fa-clock-o"></i>'.$row['start_time_hr'].':'.$row['start_time_mn'].'</span>
											<br /><span>โดย : '.$row['department']->post_title.'</span>
										</div>
						
										
									</div>
								</div>
								</a>
							</article>';
		}
	}
	else{
		$html .= '<div class="alert alert-warning skb" style="margin-top:10px">
    <strong>ไม่พบข้อมูลกิจกรรม !</strong>
  </div>';
	}
	return $html;
}


function getDayEvent(){
	
	$target = $_POST['date'];
	$event = getPost('event',array('title','date','author','thumbnail','start_date','start_time_hr','start_time_mn','end_date','department','place','abstract'),'desc','',
							 array(
								'relation' 			=> 'AND',
								array(
									'key'		=> 'start_date',
									'compare'	=> '<=',
									'value'		=> date('Ymd',strtotime($target)),
								),
								array(
									'key'		=> 'end_date',
									'compare'	=> '>=',
									'value'		=> date('Ymd',strtotime($target)),
								)
							),'',array('start_date','meta_value_num')
						);
	$result['html'] = createHTML($event);
	$result['date'] = date('Y-m-d',strtotime($target));
	$result['title'] = DateThai(date('Ymd',strtotime($target)),true);
	$result['count'] = count($event);
	echo json_encode($result);
}



function getMonthEvent(){
	if($_POST['dp']==1){
		$rMth = $_POST['mth'];
	}
	else{
		$rMth = $_POST['mth']+1;
	}
	$month = str_pad($rMth,2,0,STR_PAD_LEFT);
	$startDate = date($_POST['yr'].'-'.$month.'-01');
	$endDate = date($_POST['yr'].'-'.$month.'-t');
	$dateRange = createRange($startDate,$endDate);
	$eventbyDate = array();
	foreach($dateRange as $row){
		$eventbyDate[$row] =  getPost('event',array('title','thumbnail','start_date','start_time_hr','start_time_mn','start_time','end_date','department','place','abstract'),'desc','',
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
	
	
	$result['html'] = createHTML($eventbyDate[key($eventbyDate)]);
	$result['date'] = date('Y-m-d',strtotime($startDate));
	$result['title'] = DateThai(date('Ymd',strtotime($startDate)),true);
	$result['count'] = count($eventbyDate[key($eventbyDate)]);
	$result['monthObj'] = $eventbyDate;
	echo json_encode($result);
}

function searchEvent(){
	
		$queryArray = array();
		if($_POST['start_date'] != "" && $_POST['e_date']){
			$startDateText = str_replace('/', '-', $_POST['start_date']);
			$endDateText = str_replace('/', '-', $_POST['e_date']);
			$startDate = date('Ymd',strtotime($startDateText));
			$eDate = date('Ymd',strtotime($endDateText));
			
			$queryArray = array(
									
									array(
										'key'		=> 'start_date',
										'compare'	=> '>=',
										'value'		=> $startDate,
									),
									array(
										'key'		=> 'start_date',
										'compare'	=> '<=',
										'value'		=> $eDate,
									)
								);
		}
							
		if($_POST['dep'] != ""){
			$queryArray[] = array(
							'key'		=> 'department',
							'compare'	=> '=',
							'value'		=> $_POST['dep']
						);
		}
		
		
		if($_POST['title'] != ""){
				$event = getPost('event',array('title','author','date','thumbnail','start_date','start_time_hr','start_time_mn','end_date','department','place','abstract'),'desc','',
							 $queryArray,'',array('start_date','meta_value_num'),$_POST['title']
						);
		}
		else{
				$event = getPost('event',array('title','author','date','thumbnail','start_date','start_time','start_time_hr','start_time_mn','end_date','end_time','department','place','abstract'),'desc','',
							 $queryArray,'',array('start_date','meta_value_num')
						);
		}

		
		
		$result['title'] = 'ผลการค้นหา';
		$result['html'] = createHTML($event,1);
		$result['count'] = count($event);
		echo json_encode($result);
	
}


function setMail($to,$data){
	
	$subject = 'เชิญชวนเข้าร่วมกิจกรรม'.html_entity_decode($data['title']);
	$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- So that mobile will display zoomed in --><meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- enable media queries for windows phone 8 --><meta name="format-detection" content="telephone=no">
<!-- disable auto telephone linking in iOS --><title>Single Column</title>
</head>
<body style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; margin: 0; padding: 0;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">';
	$body .= '<p style="font-size:24px;font-weight:bold;">เรียน ผู้บริหารและพนักงานทุกท่าน</p>';
	$body .= '<p style="font-size:20px;text-indent:20px;">เชิญชวนทุกท่านเข้าร่วมกิจกรรม <strong>'.$data['title'].'</strong> ในวันที่<strong> '.dateThai($data['start_date'],true);
	if($row['end_date'] != ""){
		$body .= ' - '.dateThai($data['end_date'],true);
	}
	$body .= ' </strong> เวลา <strong>'.$data['start_time_hr'].':'.$data['start_time_mn'].'</strong> คลิกดูรายละเอียดที่ <a href="'.get_bloginfo('url').'/event?id='.$data['id'].'" target="_blank">'.get_bloginfo('url').'/event?id='.$data['id'].'</a>';
	$body .= '<div><img src="'.$row['thumbnail']['url'].'"/></div>';
	$body .= '</body>
</html>';
	
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: ระบบปฏิทินกิจกรรมองค์กร <EventCalendarAdmin@thaipbs.or.th>';
	
	wp_mail($to, $subject, $body, $headers );
}


function sendEmail(){
	$event = getPost('event',array('title','thumbnail','start_date','start_time_hr','start_time_mn','end_time_hr','end_time_mn','end_date','email_notice','notice_date','notice_time_hr','notice_time_mn','notice_all','notice_to'),'desc','',
							 array(
								'relation' 			=> 'AND',
								array(
									'key'		=> 'email_notice',
									'compare'	=> '=',
									'value'		=> 1,
								),
								array(
									'key'		=> 'notice_date',
									'compare'	=> '<=',
									'value'		=> date('Ymd'),
								),
								array(
									'key'		=> 'notice_date',
									'compare'	=> '>=',
									'value'		=> date('Ymd'),
								)
							),'',array('start_date','meta_value_num')
						);
	
	foreach($event as $key=>$row){
		//echo  $upload_dir['basedir'].substr($row['thumbnail']['url'],strpos($row['thumbnail']['url'],"sites")+7,strlen($row['thumbnail']['url']));
		$noticeTime = date("H:i:s",strtotime($row["notice_time_hr"].":".$row["notice_time_mn"]));
		
		if(date("H:i:s") == $noticeTime){
			
			
			if($row['notice_all'] == 1){  // send all
				setMail("ThaiPBSAll@thaipbs.or.th",$row);
			}
			
			if(!empty($row['notice_to'])){ // send divide
				foreach($row['notice_to'] as $skey=>$srow){
					setMail($srow['receiver'],$row);
				}
			}
		}
	}
}

if($_GET['fn']){
	$_GET['fn']();
}
?>