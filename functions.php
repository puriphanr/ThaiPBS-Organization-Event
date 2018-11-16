<?php
date_default_timezone_set("Asia/Bangkok"); 
add_action( 'load-edit.php', 'posts_for_current_author' );
function posts_for_current_author() {
    global $user_ID;

    /*if current user is an 'administrator' do nothing*/
    //if ( current_user_can( 'add_users' ) ) return;

    /*if current user is an 'administrator' or 'editor' do nothing*/
    if ( current_user_can( 'edit_others_pages' ) ) return;

    if ( ! isset( $_GET['author'] ) ) {
        wp_redirect( add_query_arg( 'author', $user_ID ) );
        exit;
    }

}

function getPost($post_type,$field = array(),$order = 'asc',$tag_id = '',$meta_query = array(),$num = '',$orderby = array(),$s = ''){
		$args = array( 
						'post_type' => $post_type, 
						'order' => $order,
						'posts_per_page' => $num,
						'meta_query' => $meta_query

					);
		if(!empty($tag_id)){
			$args['p'] = $tag_id;
		}
		if(!empty($s)){
			$args['s'] = $s;
		}
		if(!empty($orderby)){
			$args['meta_key'] = $orderby[0];
			$args['orderby'] = $orderby[1];
		}
		
		$loop = new WP_Query( $args );
		$i = 0;
		$result = array();

		while ( $loop->have_posts() ) : $loop->the_post();
			foreach($field as $key=>$row){
				$result[$i]['id'] = get_the_ID();
				if($row == 'title'){
					$result[$i][$row] = get_the_title();
				}
				elseif($row == 'desc'){
					$result[$i][$row] = get_the_content();
				}
				elseif($row == 'author'){
					$result[$i][$row] = get_the_author();
				}
				elseif($row == 'date'){
					$result[$i]['date'] = get_the_date('Y-m-d');
					$result[$i]['time'] = get_the_time('H:i');
				}
				else{
					$result[$i][$row] = get_field($row);
				}
			}
			$i++;
		endwhile;	
		return $result;
	
}

	function moretext($message,$length = 150){
		
		if(mb_strlen($message) > $length){
			return mb_substr($message, 0, $length). "..." ;
		}
		else{
			return $message;
		}
	}
function format_date($date){
	
		$arrayMonth = array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
		$exdate = explode('/',$date);
		$month = (int)$exdate[1];
		$year = substr($exdate[2]+543,2,2);
		return (int)$exdate[0]." ".$arrayMonth[$exdate[1]-1]." ".$year;
	
}	
function DateThai($strDate,$long = false){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		if(!$long){
			$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			$strYear = substr($strYear,2,2);
		}
		else{
			$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		}
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
}
function DayThai($num,$long = false){
	
		if(!$long){
			$strDayCut = Array("","จ","อ","พ","พฤ","ศ","ส","อ");
		}
		else{
			$strDayCut = Array("","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์");
		}
		$strDayThai=$strDayCut[$num];
		return $strDayThai;
}
function MonthThai($num,$long = false){
	
		if(!$long){
			$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		}
		else{
			$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		}
		$strMonthThai=$strMonthCut[$num];
		return $strMonthThai;
}
function YearThai($bc){
		return $bc+543;
}
function MonthArray(){
	return array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
}
function createRange($start, $end, $format = 'Y-m-d') {
    $start  = new DateTime($start);
    $end    = new DateTime($end);
    $invert = $start > $end;

    $dates = array();
    $dates[] = $start->format($format);
    while ($start != $end) {
        $start->modify(($invert ? '-' : '+') . '1 day');
        $dates[] = $start->format($format);
    }
    return $dates;
}
function getWeekDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}
?>