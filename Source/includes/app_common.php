<?php

$months = array (
	'1' => 'يناير',
	'2' => 'فبراير',
	'3' => 'مارس',
	'4' => 'أبريل',
	'5' => 'مايو',
	'6' => 'يونيو',
	'7' => 'يوليو',
	'8' =>'أغسطس',
	'9' =>'سبتمبر',
	'10' =>'نوفمبر',
	'11' =>'أكتوبر',
	'12' =>'ديسمبر'
);

// Get equivelent date
function get_date_time($datetime)
{
	global $months;
	$ret = '';
	$datetime1 = date_create ($datetime);
	$n = date('Y-m-d H:i:s');
	$now = date_create ($n,new DateTimeZone('Africa/Cairo'));
	$interval = date_diff ($datetime1,$now);
	
	//Less than day
	if($interval->d == 0){
		//Less Than Hour
		if($interval->h == 0)
			$ret = 'منذ: '.$interval->i.' دقيقة ';
		else
			$ret = 'منذ : '. $interval->h .' ساعة ';
	}elseif ($interval->d  == 1){
		$ret = 'منذ أمس';
	}else{
		$day = date('j',  strtotime($datetime));
		$month = date('n',  strtotime($datetime));
		$month = $months[$month];
		$ret = 'فى ' . $day .' '. $month;
	}
	return $ret;
}


function redirect_from_old_url($id){
    switch($id){
        case 1:
         go_to('?con=ads&page=category&m_id=cars',true);
        break;
        case 2:
         go_to('?con=ads&page=category&m_id=buildings',true);
        break;
        case 3:
         go_to('?con=ads&page=category&m_id=phones',true);
        break;
        case 4:
         go_to('?con=ads&page=category&m_id=computers',true);
        break;
        case 5:
         go_to('?con=ads&page=category&m_id=furniture',true);
        break;
        case 6:
         go_to('?con=ads&page=category&m_id=animals',true);
        break;
        case 7:
         go_to('?con=ads&page=category&m_id=electronics',true);
        break;
        case 8:
         go_to('?con=ads&page=category&m_id=fashion',true);
        break;
        case 9:
         go_to('?con=ads&page=category&m_id=beauty',true);
        break;
    
        case 11:
         go_to('?con=ads&page=category&id=cars_cars',true);
        break;
        case 12:
         go_to('?con=ads&page=category&id=cars_trucks',true);
        break;
        case 13:
         go_to('?con=ads&page=category&id=cars_motorcycles',true);
        break;
        case 14:
         go_to('?con=ads&page=category&id=cars_batteries',true);
        break;
        case 15:
         go_to('?con=ads&page=category&id=cars_spareparts',true);
        break;
    
        case 20:
         go_to('?con=ads&page=category&m_id=buildings_appartments',true);
        break;
        case 21:
         go_to('?con=ads&page=category&m_id=buildings_villa',true);
        break;
        case 22:
         go_to('?con=ads&page=category&m_id=buildings_goods',true);
        break;
        case 23:
         go_to('?con=ads&page=category&m_id=buildings_offices',true);
        break;
        case 24:
         go_to('?con=ads&page=category&m_id=buildings_land',true);
        break;
    
        case 30:
         go_to('?con=ads&page=category&m_id=phones_iphone',true);
        break;
        case 31:
         go_to('?con=ads&page=category&m_id=phones_android',true);
        break;
        case 32:
         go_to('?con=ads&page=category&m_id=phones_nokia',true);
        break;
        case 33:
         go_to('?con=ads&page=category&m_id=phones_blackberry',true);
        break;
        case 34:
         go_to('?con=ads&page=category&m_id=phones_accessorise',true);
        break;
        case 35:
         go_to('?con=ads&page=category&m_id=phones_lines',true);
        break;
    
        case 40:
         go_to('?con=ads&page=category&m_id=computers_personal',true);
        break;
        case 41:
         go_to('?con=ads&page=category&m_id=computers_laptop',true);
        break;
        case 42:
         go_to('?con=ads&page=category&m_id=computers_accessories',true);
        break;
        case 43:
         go_to('?con=ads&page=category&m_id=computers_programs',true);
        break;
        case 44:
         go_to('?con=ads&page=category&m_id=computers_printers',true);
        break;
      
    
        case 50:
         go_to('?con=ads&page=category&m_id=furniture_home',true);
        break;
        case 51:
         go_to('?con=ads&page=category&m_id=furniture_office',true);
        break;
        case 52:
         go_to('?con=ads&page=category&m_id=furniture_kitchen',true);
        break;
        case 53:
         go_to('?con=ads&page=category&m_id=furniture_fabrics',true);
        break;
    
        case 60:
         go_to('?con=ads&page=category&m_id=animals_dogs',true);
        break;
        case 61:
         go_to('?con=ads&page=category&m_id=animals_cats',true);
        break;
        case 62:
         go_to('?con=ads&page=category&m_id=animals_birds',true);
        break;
        case 63:
         go_to('?con=ads&page=category&m_id=animals_fish',true);
        break;
        case 64:
         go_to('?con=ads&page=category&m_id=animals_animals',true);
        break;
    
        case 70:
         go_to('?con=ads&page=category&m_id=electronics_frigidaire',true);
        break;
        case 71:
         go_to('?con=ads&page=category&m_id=electronics_television',true);
        break;
        case 72:
         go_to('?con=ads&page=category&m_id=electronics_washingmachines',true);
        break;
        case 73:
         go_to('?con=ads&page=category&m_id=electronics_adaptations',true);
        break;
        case 74:
         go_to('?con=ads&page=category&m_id=electronics_others',true);
        break;
    
        case 80:
         go_to('?con=ads&page=category&m_id=fashion_women',true);
        break;
        case 81:
         go_to('?con=ads&page=category&m_id=fashion_children',true);
        break;
        case 82:
         go_to('?con=ads&page=category&m_id=fashion_men',true);
        break;
       
        case 90:
         go_to('?con=ads&page=category&m_id=beauty_tools',true);
        break;
        case 91:
         go_to('?con=ads&page=category&m_id=beauty_sports',true);
        break;
        case 92:
         go_to('?con=ads&page=category&m_id=beauty_medicine',true);
        break;
        case 93:
         go_to('?con=ads&page=category&m_id=beauty_centers',true);
        break;
        
    }
}

?>
