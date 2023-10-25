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

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=-100" />
    <meta name="format-detection" content="telephone=no" />
    <title><?php echo $current_category_name; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />



    <!-- DELETE -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
    img{max-width: 100%;max-height: 300px;display: block;margin: 0 auto;}
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
    .list_ovn li{width: 30%;margin: 0 1.5% 50px 0;background: #ededed;padding: 15px;box-sizing: border-box;text-align: center;}
    </style>
    <!-- /DELETE -->



</head>

<body id="ovn_cate" class="under ovn_page">
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
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"><?php echo $base_title; ?></h1>
                </div>
            </div>
        </section>
        <!-- LIST OVERNOTE -->
        <section class="clearfix">
            <p class="f_center">
                <?php
	$category_index=get_category_index();
	foreach($category_index as $rowid=>$id){
		$category_data=unserialize(@file_get_contents(DATA_DIR.'/category/'.$id.'.dat'));
		$category_url=$category_data['id'];
		$category_name=$category_data['name'];
		$category_text=@$category_data['text'];
		$category_id=$id;
		${'category'.$id.'_url'}=$category_data['id'];
		${'category'.$id.'_name'}=$category_data['name'];
		${'category'.$id.'_text'}=@$category_data['text'];
		$selected=(@$_GET['c']==$id?' selected="selected"':'');

?>
                    <a class="btn btn-secondary my-2" href="../<?php echo $category_url; ?>/"><?php echo $category_name; ?></a>
                <?php
	}
?>
            </p>
            <ul class="list_ovn">
                         <?php $limitNum = 10 ?>
                         <?php
	$contribute_index=contribute_search(
		@$current_category_id
		,''
		,''
		,''
		,''
		,''
	);
	$max_record_count=count($contribute_index);

	$current_page=(@$_GET['p'])?(@$_GET['p']):1;
	$contribute_index=array_slice($contribute_index,($current_page-1)*$limitNum,$limitNum);
	$record_count=count($contribute_index)

?>
                            <?php
	$local_index=0;
	foreach($contribute_index as $rowid=>$index){
		$contribute=unserialize(@file_get_contents(DATA_DIR.'/contribute/'.$index['id'].'.dat'));
		$title=$contribute['title'];
		$url=$contribute['url'].'/';
		$category_id=$index['category'];
		$category_data=unserialize(@file_get_contents(DATA_DIR.'/category/'.$category_id.'.dat'));
		$category_name=$category_data['name'];
		$category_text=@$category_data['text'];
		$field_id=$index['field'];
		$date=$index['public_begin_datetime'];
		$id=$index['id'];
		$field=get_field($field_id);

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
		$local_index++;

?>
                                <li>
                                    <h4><?php echo $title; ?></h4>
                                    <?php
	if($img01_Value){
?>
                                        <p class="center"><a href="../<?php echo $url; ?>"><img src="<?php echo $img01_Src; ?>" alt="<?php echo $title; ?>"></a></p>
                                    <?php
	}
?>
                                    <?php
	if($text01_Value){
?>
                                        <div><?php echo $text01_Value; ?></div>
                                    <?php
	}
?>
                               </li>
                            <?php
		foreach($field as $field_index=>$field_data){
			unset(${$field_data['code'].'_Name'});
			unset(${$field_data['code'].'_Value'});
			unset(${$field_data['code'].'_Src'});
		}
	}
?>
                         
                    </ul>

                      <!-- *********   PAGINATION   ********* -->
                      <?php
	$page_count=(int)ceil($max_record_count/(float)$limitNum);
?>
                         <?php
	if($max_record_count > $limitNum){
?>
                            <div class="clearfix">
                               <ul class="pagination">
                                  <?php
	if($current_page <= 1){
?>
                                     <li class="disabled"><a href="#">&lt;&lt;</a></li>
                                     <?php
	}else{
?>
                                        <li><a href="./?p=<?php echo $current_page-1; ?>" class="en">&lt;&lt;</a></li>
                                  <?php
	}
?>
                                  <?php
	$page_old=@$page;
	for($page=1;$page<=$page_count;$page++){
?>
                                     <?php
	if($current_page == $page){
?>
                                        <li class="active"><a href="#"><?php echo $page; ?></a></li>
                                        <?php
	}else{
?>
                                           <li><a href="./?p=<?php echo $page; ?>"><?php echo $page; ?></a></li>
                                     <?php
	}
?>
                                  <?php
	}
$page=$page_old;
?>
                                  <?php
	if($current_page*$limitNum < $max_record_count){
?>
                                     <li><a href="./?p=<?php echo $current_page+1; ?>">&gt;&gt;</a></li>
                                     <?php
	}else{
?>
                                        <li class="disabled"><a href="#">&gt;&gt;</a></li>
                                  <?php
	}
?>
                               </ul>
                            </div>
                         <?php
	}
?>
                      
                    <!-- *********    /PAGINATION ********* -->
        </section>
    </main>
        <!-- end #main-->

    <footer></footer>
    <!-- end footer -->
    <script src="../js/sweetlink.js"></script>
    <script src="../js/common.js"></script>
</body>
</html>