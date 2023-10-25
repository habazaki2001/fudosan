<!Doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=-100" />
    <meta name="format-detection" content="telephone=no" />
    <title>{=$current_category_name=}</title>
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
                    <h1 class="fw-light">{=$base_title=}</h1>
                </div>
            </div>
        </section>


        
        <section class="clearfix">
            <!-- CATEGORY BUTTON -->
            <p class="f_center">
                <ONCategory>
                    <a class="btn btn-secondary my-2" href="../{=$category_url=}/">{=$category_name=}</a>
                </ONCategory>
            </p>
            <!-- // CATEGORY BUTTON -->

            <!-- LIST OVERNOTE -->
            <ul class="list_ovn">
                 <?php $limitNum = 10 ?>
                 <ONContributeSearch page="@$_GET['p']" limit="$limitNum" category="@$current_category_id">
                    <ONContributeFetch>
                        <li>
                            <h4>{=$title=}</h4>
                            <ONIf condition="$img01_Value">
                                <p class="center"><a href="../{=$url=}"><img src="{=$img01_Src=}" alt="{=$title=}"></a></p>
                            </ONIf>
                            <ONIf condition="$text01_Value">
                                <div>{=$text01_Value=}</div>
                            </ONIf>
                       </li>
                    </ONContributeFetch>
                 </ONContributeSearch>
            </ul>

          <!-- *********   PAGINATION   ********* -->
          <ONPagenation record_count="$max_record_count" limit="$limitNum">
             <ONIf condition="$max_record_count > $limitNum">
                <div class="clearfix">
                   <ul class="pagination">
                      <ONIf condition="$current_page <= 1">
                         <li class="disabled"><a href="#">&lt;&lt;</a></li>
                         <ONElse>
                            <li><a href="./?p={=$current_page-1=}" class="en">&lt;&lt;</a></li>
                      </ONIf>
                      <ONPagenationFetch>
                         <ONIf condition="$current_page == $page">
                            <li class="active"><a href="#">{=$page=}</a></li>
                            <ONElse>
                               <li><a href="./?p={=$page=}">{=$page=}</a></li>
                         </ONIf>
                      </ONPagenationFetch>
                      <ONIf condition="$current_page*$limitNum < $max_record_count">
                         <li><a href="./?p={=$current_page+1=}">&gt;&gt;</a></li>
                         <ONElse>
                            <li class="disabled"><a href="#">&gt;&gt;</a></li>
                      </ONIf>
                   </ul>
                </div>
             </ONIf>
          </ONPagenation>
        <!-- *********    /PAGINATION ********* -->
        </section>
    </main>
        <!-- end #main-->

    <footer></footer>
</body>
</html>