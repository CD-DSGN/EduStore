<?php

/*	author: nahuanjie
*	Create a new file named address.plist
*	教师注册的地区选择的文件
*	同时可迁移至收货地址
*/

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');

// 定义一堆常量
$fileHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?\>\n<!DOCTYPE plist PUBLIC \"-//Apple//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">\n<plist version=\"1.0\">";
$fileFooter = "</plist>\n";
$dictionaryStart = "<dict>";
$dictionaryEnd = "</dict>\n";
$keyStart = "<key>";
$keyEnd = "</key>\n";
$arrayStart = "<array>\n";
$arrayEnd = "</array>\n";
$stringStart = "<string>";
$stringEnd = "</string>\n";

// $regionFile = fopen("region.txt", "w");

$provinceArray = $provinceCityArray = $cityTownArray =  array();

$sql = "SELECT * FROM ecs_region WHERE region_type > 0 ORDER BY region_id";

$region_info = $db->getAll($sql);

foreach ($region_info as $keys => $values) {			// 得到的values仍然是一个数组
	if ( $values['region_type'] == 1 ) {				// 得到省
		$provinceArray[$values['region_id']] = $values['region_name'];
	}  else if ( $values['region_type'] == 2 ) {		// 得到市
		$tempProvinceId = $values['parent_id'];
		$provinceCityArray[$tempProvinceId][$values['region_id']] = $values['region_name'];
	}  else if ( $values['region_type'] == 3 ) {		// 得到县
		$tempCityId = $values['parent_id'];
		$cityTownArray[$tempCityId][$values['region_id']] = $values['region_name'];
	}
}

// 输出省
// foreach ($provinceArray as $key => $value) {
// 	echo $key ."=>". $value ."<br/>";
// }

// 输出市
// var_dump($cityTownArray);
// foreach ($cityTownArray as $keys => $values) {
// 	if ( is_array($values))
// 	{
// 		echo $keys ."=><br/>";
// 		foreach ($values as $key => $value) {
// 			echo $key ."=>". $value ."<br/>";
// 		}
// 	}
// }
$regionStr = "";
$regionStr .= $fileHeader;
$regionStr .= $dictionaryStart;

foreach ($provinceArray as $provinceKey => $provinceValue) {
	$regionStr .= $keyStart;
	$regionStr .= $provinceValue;
	$regionStr .= $keyEnd;
	$regionStr .= $arrayStart;
	$regionStr .= $dictionaryStart;
	foreach ($provinceCityArray as $provinceCityKey => $provinceCityValue) {
		if ( $provinceCityKey == $provinceKey ) {
			foreach ($provinceCityValue as $key => $value) {
				$regionStr .= $keyStart;
				$regionStr .= $value;
				$regionStr .= $keyEnd;
				$regionStr .= $arrayStart;
				foreach ($cityTownArray as $cityTownKey => $cityTownValue) {
					if ( $cityTownKey == $key ) {
						foreach ($cityTownValue as $key => $value) {
							$regionStr .= $stringStart;
							$regionStr .= $value;
							$regionStr .= $stringEnd;
						}
					}
				}
			$regionStr .= $arrayEnd;
			}
		}
	}
	$regionStr .= $dictionaryEnd;
	$regionStr .= $arrayEnd;
}


$regionStr .= $dictionaryEnd;
$regionStr .= $fileFooter;
echo $regionStr;













