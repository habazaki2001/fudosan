<?php

	$setting=unserialize(@file_get_contents(DATA_DIR.'/setting/overnotes.dat'));
	ini_set('mbstring.http_input', 'pass');
	parse_str($_SERVER['QUERY_STRING'],$_GET);
	$keyword=isset($_GET['k'])?trim($_GET['k']):'';
	$category=isset($_GET['c'])?trim($_GET['c']):'';
	$page=isset($_GET['p'])?trim($_GET['p']):'';
	$base_title = !empty($setting['title'])? $setting['title'] : 'OverNotes';

?><!Doctype html>
<html lang="ja">
<?php
	$contribute=get_contribute($contribute_id);
		$title=$contribute['title'];
	$category_id=$contribute['category'];
	$category_data=unserialize(@file_get_contents(DATA_DIR.'/category/'.$category_id.'.dat'));
	$category_name=$category_data['name'];
	$category_text=@$category_data['text'];
	$category_url=$category_data['id'];
	$field_id=$contribute['field'];
	$id=$contribute['id'];
	$field=get_field($field_id);
	$date=$contribute['public_begin_datetime'];
	$url=$contribute['url'].'/';

	foreach($field as $field_index=>$field_data){
		${$field_data['code'].'_Name'}=$field_data['name'];
		${$field_data['code'].'_Value'}=make_value(
		$field_data['name']
				,@$contribute['data'][$field_id][$field_index]
			,$field_data['type']
			,$id
			,$field_id
			,$field_index
		);
		if($field_data['type']=='image'){
			${$field_data['code'].'_Src'}=ROOT_URI.'/_data/contribute/images/'.@$contribute['data'][$field_id][$field_index];
		}
	}

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=-100" />
    <meta name="format-detection" content="telephone=no" />
    <title><?php echo $title; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />





    <!-- DELETE -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
    li{list-style: none;}
    .list_ovn li {margin-bottom: 30px;padding-bottom: 30px;border-bottom: 1px solid #ccc;}
    .pagination {display: flex;justify-content: center;flex-wrap: wrap;text-align: center;margin: 30px auto 0}
    .pagination li {margin: 0 10px}
    .pagination li a {width: 40px;height: 40px;text-align: center;border: 1px solid #000;background: #fff;display: flex;text-decoration: none;color: #000;text-decoration: none;justify-content: center;align-items: center;border-radius: 5px;transition: all ease 0.3s;}
    .pagination li:hover a,.pagination li.active a {background: #000;color: #fff;}.pagination li.active a {pointer-events: none;}
    .pagination li.disabled {display: none}
    .f_center{display: flex;justify-content: center;}
    .f_center a{margin: 0 5px;}
    .list_ovn{display: flex;flex-wrap: wrap;}
    .list_ovn li{width: 30%;margin: :0 1.5% 50px 0;}
    main{padding: 30px;}
    h3{text-align: center;margin-bottom: 50px;}
    </style>
    <!-- /DELETE -->



</head>

<body id="ovn_detail" class="under ovn_page">
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <strong>Overnotes</strong>
                </a>
            </div>
        </div>
    </header>

    <main>
        <h3><?php echo $title; ?></h3>
        <!-- LIST OVERNOTE -->
        <section class="clearfix">
            <?php
	if($text01_Value){
?>
            <div class="mb30"><?php echo $text01_Value; ?></div>
            <?php
	}
?>

            <?php
	if($text02_Value){
?>
            <p class="mb30"><?php echo $text02_Value; ?></p>
            <?php
	}
?>

            <?php
	if($radio1_Value){
?>
            <ul class="list01">
                <li><?php echo $radio1_Value; ?></li>
            </ul>
            <?php
	}
?>

            <?php
	if($check1_Value){
?>
                <ul>
                    <li><?php echo $check1_Value; ?></li>
                </ul>
            <?php
	}
?>

            <?php
	if($select_Value){
?>
                <ul>
                    <li><?php echo $select_Value; ?></li>
                </ul>
            <?php
	}
?>

            <?php
	if($img01_Value){
?>
        	<p class="center ovn_img"><img src="<?php echo $img01_Src; ?>" alt="<?php echo $title; ?>"></p>
            <p class="center">will show when Value = true</p>
            <?php
	}
?>

            <p class="f_center"><a class="btn btn-secondary my-2" href="../<?php echo $category_url; ?>/">一覧に戻る</a></p>
        </section>
    </main>
    <!-- end #main-->

    <footer></footer>
    <!-- end footer -->
    <script src="../js/sweetlink.js"></script>
    <script src="../js/common.js"></script>
</body>
</html>