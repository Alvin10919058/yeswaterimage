<?php 
	include('protected/db_con.php');


	//抓出所有票數

	$counts=array();

    $rSql="SELECT  `target` , COUNT(  `target` ) as 'count' FROM  `vote` GROUP BY  `target` ORDER BY  `target` ASC ";

    $query=mysql_query($rSql);

    while($result=mysql_fetch_array($query)){

        $counts[$result['target']]=$result['count'];

    }
	
	//抓出同一天裡同個fbid的票數
	/*$rSql="SELECT  * , COUNT(  `fbid` ) as 'count' FROM  `vote` GROUP BY  `fbid` , `date`";
	$query=mysql_query($rSql);
	while($result=mysql_fetch_array($query))
	{
		if($result['ip']!="sys")
			$counts[$result['target']]=$counts[$result['target']]-$result['count']+1;
	}*/
	

	//抓出參選者的資料

	$datasql = "SELECT * FROM `candidate` ORDER BY `num` ASC";

    $dataquery=mysql_query($datasql);

    $totalllll = mysql_num_rows($dataquery);

    $datac = array();


    while($dataresult=mysql_fetch_array($dataquery)){

        $dataresult['paragraph']= nl2br($dataresult['paragraph']);
		array_push($datac,$dataresult);
    }

	

	if(isset($_GET['page'])&&is_numeric($_GET['page'])){

        $page = $_GET['page'];    

    }else{

        $page = 1;

    }

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/" >

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="fb:app_id" content="871040533014524"/></meta>

<meta property="og:url" content="http://youngfb.com/sport/"/>
<meta property="og:title" content="2014運動酷照徵選"/>
<meta property="og:image" content="http://youngfb.com/sport/images/fb_share_img.jpg"/>
<meta property="og:type" content="website" />


<title>2014運動酷照徵選</title>

<link href="reset.css" rel="stylesheet" type="text/css" />

<link href="main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<!--<script src="jquery.js"></script>-->

<script src="checkrecord.js"></script>

<script src="fblogin.js"></script>

<script src="init_vote_frame.js"></script>

<!--<script src="update_vote_count.js"></script>-->

<script type="text/javascript" src="http://l2.io/ip.js?var=myip"></script>

<script>

var datac = <?php echo json_encode($datac); ?>,page = <?php echo $page; ?>,maxpage = <?php echo ceil(count($datac)/6) ?>,start,countv = <?php echo json_encode($counts); ?>;

var like1=false,like2=false,index,targetname;
var loc = "index";
var whoClick = "";
var voteclick = false;

$(document).ready(function(){

	//alert(myip);	會回傳IP
	if(page>maxpage){

		page=maxpage;

	}

	switchpage();

	$('.vote-box').hide();

//	$('.like-box').hide();
	var div = document.getElementById('like-box');
	div.style.position = 'absolute';
	div.style.top = '-1000px';
	//$('.like-box').css('position: absolute; top:1500px;');

	//點擊打開投票頁面

	$('.personimg').click(function(){
		/*for(i=0;i<datac.length;i=i+1)
		{
			var temp = document.getElementById('comments'+i);
				temp.setAttribute("style","display:none");
		}*/
		
		chosen=$(this).attr('class').substr(11,1);

		index=parseInt(chosen)+parseInt((page-1)*6);
		
		targetname = datac[index-1]['name'];
		
		if(index-1 < datac.length && page > 0)

			init_vote_frame(chosen,(page-1)*6);

	});

	

	//關閉投票盒

	$('.vote-box-x').click(function(){

		$('.vote-box').hide();
		/*for(i=0;i<datac.length;i=i+1)
		{
			var temp = document.getElementById('comments'+i);
			if($('#comments'+i).attr('value') == datac[index-1]['fbid'])
			{
				temp.setAttribute("style","display:none");
			}
		}*/
	});

	

	//關閉按讚盒

	$('.like-box-x').click(function(){

		$('.like-box').hide();

	});
	

	//分享至塗鴉牆(內頁)

	$('#share').click(function(){

		FB.ui(

		{

			method: 'feed',
			
			display: 'popup',

			name: '2014運動酷照徵選',

			link: 'http://youngfb.com/yeswaterimage/index.php?page='+page,

			picture: 'http://youngfb.com/yeswaterimage/images/fb_share_img.jpg',

			caption: '挑戰『2014運動酷照』，贏得口袋DV/運動鞋墊/登機箱等大獎！'

		},

		function(response) {
			
		}



		);

	});
	
	//分享至塗鴉牆(上面)

	$('#Image7').click(function(){

		FB.ui(

		{

			method: 'feed',
			
			display: 'popup',

			name: '2014運動酷照徵選',

			link: 'http://youngfb.com/yeswaterimage/index.php',

			picture: 'http://youngfb.com/yeswaterimage/images/fb_share_img.jpg',

			caption: '挑戰『2014運動酷照』，贏得口袋DV/運動鞋墊/登機箱等大獎！'

		},

		function(response) {
			
		}



		);

	});

	
	


	//點投我一票(內頁)

	$('.vote-box-btn-img').click(function(){
		if(!voteclick)
		{
			voteclick = true;
			votefblogin();
			FB.api('/me', function(response) {
  			name = response.name;
      		});
      		
			vote();
			
		}
	});
	//投我一票(主頁)
	for(i=1;i<=6;i=i+1)
	{
		$('.vote'+i).click(function(){
			if(!voteclick)
			{
				voteclick = true;
				chosen=$(this).attr('class').substr(4,1);
				index=parseInt(chosen)+parseInt((page-1)*6);
				targetname = datac[index-1]['name'];
				votefblogin();
				FB.api('/me', function(response) {
  				name = response.name;
      			});	  			
				vote();
				
			}
		});
	}

	

	//按讚盒

	$('.like-box-go').click(function(){

		isLiked1();

	});

	

	//最前頁

	$('#top_page').click(function(){

	 	page=1;

		switchpage();

	});

	//上一頁

	$('#prev_page').click(function(){

	 	if(page>1){

			page--;

		    switchpage();

		}	 

	});

	//下一頁

	$('#next_page').click(function(){

		if(page<maxpage){

			page++;

		    switchpage();

		}	 	

	});

	//最後頁

	$('#bottom_page').click(function(){

	 	page=maxpage;

		switchpage();

	});



	//右側廣告板動畫
	
	
	$('.photo-box').hide();
	
	//點擊圖片放大
	$('.vote-photo-img').click(function(){
		var bg = $('.vote-photo-img').css('background-image');
        bg = bg.replace('url(','').replace(')','');
		$('.photo-box-img').css({'background':'url("images/candidate/'+index+'.jpg?rand=1") no-repeat','background-size':"contain",'background-position':"center"});
		$('.photo-box').show();
	});
	
	//關閉照片盒
	$('.photo-box-x').click(function(){
		$('.photo-box').hide();
	});
	
	//跳頁功能
	$('.jump_go').click(function(){
		var temp = $('.jump_page').val();
		if($.isNumeric( temp )==true && temp>0)
		{
			if(temp<=maxpage)
			{
				page=temp;
				switchpage();
			}
			else
				alert("查無此頁");
		}
		else
			alert("請輸入正確的數字");
	});

});



//換頁功能

function switchpage(){

    <?php   if($totalllll != 0){?>

	

	$('.pagetext').text(page+"/"+maxpage);

	start = (page-1)*6;

	for(var z=1;z<7;z++){

		//抓參選者圖片

		var picclass = ".i"+z;

		//alert(picclass);

		$(picclass).css({'background':'url("images/candidate/'+(start+1)+'.jpg?rand=1") no-repeat','background-size':"contain",'background-position':"center"});

		

		if(datac[start]['name']==undefined){

			$('.personName'+z).text("");
			$('.personNo'+z).text("");

		}else{
			
			$('.personName'+z).text(datac[start]['name']);
			$('.personNo'+z).text((start+1)+". ");
		}
		
		if(datac[start]['count']==undefined){

			$('.vote-count'+z).text("0");

		}else{

			$('.vote-count'+z).text(datac[start]['count']);

		}

		

		start++;

		if(start==datac.length && datac.length%6 != 0){

			var dataleft = datac.length%6;

			for(var z=dataleft+1;z<7;z++){

				picclass = ".i"+z;
				$('.s'+z).text("");
				$(picclass).css('background','url("images/test.png")');
				
				$('.personName'+z).text("");
				$('.personNo'+z).text("");
				$('.vote-count'+z).text("0");
			}		

			break;

		}

	}

    <?php   }?>

}



function MM_swapImgRestore() { //v3.0

  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;

}

function MM_preloadImages() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}



function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



function MM_swapImage() { //v3.0

  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)

   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}

}

</script>

<style type="text/css">
body {
  /*background-image: url(images/bgcolor.png);*/
  background-size: contain;
  background-color: #EEF3FA;
}
</style>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56659478-3', 'auto');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');

</script>
</head>

<body >

<!--右側廣告欄-->
<div id="right-board">

<a href="http://goo.gl/n2cPmo" target="_blank">
<img id="right_1" width="130" src="images/right-board/right_1.gif" style="
    position: absolute;left:-130px; 
    top: -350px; bottom:0; margin:auto;
"></a>



<a href="http://goo.gl/nz35Ra" target="_blank">
<img id="right_2" width="130" src="images/right-board/right_2.jpg" style="
    position: absolute;left:-130px; 
    top: 200px; bottom:0; margin:auto;
"></a>

</div>






<div id="fb-root"></div>

<script language="JavaScript" src="https://connect.facebook.net/zh_TW/all.js"></script>

<script language="JavaScript">

//fb初始化

window.fbAsyncInit = function() {

  FB.init({

    appId: '871040533014524', // App ID

	channelUrl : '//youngfb.com/channel.php', // Channel File

	status: true,

    cookie: true,

    xfbml: true,

    oauth: true,
	
	version: 'v2.0'

  });

  

}



(function(d, s, id) {

  var js, fjs = d.getElementsByTagName(s)[0];

  if (d.getElementById(id)) return;

  js = d.createElement(s); js.id = id;

  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&appId=871040533014524&version=v2.0";

  fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));



</script>



<div id="wrapper">
<div class="main_img_l">
<div class="menu">
<!--		<a href="http://www.footdisc.com.tw" target="_blank"><img src="images/btn_logo.png" name="logo" width="137" height="21" border="0" id="logo" /></a>-->
		<a href="https://www.facebook.com/yeswater.tea/" target="_blank" ><img src="images/btn_facebook1.png" name="Image6" width="48" height="21" border="0" id="Image6" /></a>
        <a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','images/btn_vote2.png',1)"><img src="images/btn_vote2.png" name="Image2" width="110" height="21" border="0" id="Image2" /></a>
        <a href="join.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','images/btn_join2.png',1)"><img src="images/btn_join1.png" name="Image3" width="110" height="21" border="0" id="Image3" /></a>
        <a href="style.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','images/btn_active2.png',1)"><img src="images/btn_active1.png" name="Image4" width="110" height="21" border="0" id="Image4" /></a>
        <a href="winner.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','images/btn_winner2.png',1)"><img src="images/btn_winner1.png" name="Image5" width="110" height="21" border="0" id="Image5" /></a>
        <a href="#" ><img src="images/btn_share1.png" name="Image7" width="128" height="21" border="0" id="Image7" /></a>
        <!--<div class="fb-like" data-href="https://www.facebook.com/nicefoot" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="overflow:hidden"></div>-->
		
        <br />
   		  </div>

        </div>

        

        <div class="vote_frame">

        

        <div class="vote-func">

                
            
            <div class="candidate" id="p1">

        		<div class="person" id="i1" >

        			<img class="personimg i1" style="background-image:url(images/test.png); width:264px; height:217px;" />
                    <div class="btn_vote">
                    	<img src="images/btn_pmevote.png" name="vote" id="vote" class="vote1" />
                    	<div class="vote-count1">0</div>                    	
                    </div>

                    <div class="count" id="c1">
					<span class="personNo1"></span>
					<span class="personName1"></span>
					</div>

            	</div>
                <div class="person" id="i2" >

        			<img class="personimg i2" style="background-image:url(images/test.png); width:264px; height:217px;" />
                    <div class="btn_vote">
                    	<img src="images/btn_pmevote.png" name="vote" id="vote" class="vote2" />
                    	<div class="vote-count2">0</div>                    	
                    </div>

                    <div class="count" id="c2">
					<span class="personNo2"></span>
					<span class="personName2"></span>
					</div>

            	</div>
                <div class="person" id="i3" >

        			<img class="personimg i3" style="background-image:url(images/test.png); width:264px; height:217px;" />
                    <div class="btn_vote">
                    	<img src="images/btn_pmevote.png" name="vote" id="vote" class="vote3" />
                    	<div class="vote-count3">0</div>                    	
                    </div>

                    <div class="count" id="c3">
					<span class="personNo3"></span>
					<span class="personName3"></span>
					</div>

            	</div>

        		

        	</div>
            
            <div class="candidate" id="p2">

        		<div class="person" id="i4" >

        			<img class="personimg i4" style="background-image:url(images/test.png); width:264px; height:217px;" />
                    <div class="btn_vote">
                    	<img src="images/btn_pmevote.png" name="vote" id="vote" class="vote4" />
                    	<div class="vote-count4">0</div>                    	
                    </div>

                    <div class="count" id="c4">
					<span class="personNo4"></span>
					<span class="personName4"></span>
					</div>

            	</div>
                <div class="person" id="i5" >

        			<img class="personimg i5" style="background-image:url(images/test.png); width:264px; height:217px;" />
                    <div class="btn_vote">
                    	<img src="images/btn_pmevote.png" name="vote" id="vote" class="vote5" />
                    	<div class="vote-count5">0</div>                    	
                    </div>

                    <div class="count" id="c5">
					<span class="personNo5"></span>
					<span class="personName5"></span>
					</div>

            	</div>
                <div class="person" id="i6" >

        			<img class="personimg i6" style="background-image:url(images/test.png); width:264px; height:217px;" />
                    <div class="btn_vote">
	                    <img src="images/btn_pmevote.png" name="vote" id="vote" class="vote6" />
	                    <div class="vote-count6">0</div>                    	
                    </div>

                    <div class="count" id="c6">
					<span class="personNo6"></span>
					<span class="personName6"></span>
					</div>

            	</div>

        		

        	</div>

       		

        </div>   <!----vote-func-end--->   

		

				<!--投票frame-->
				
				<script>
				if(navigator.userAgent.indexOf("Chrome")>0){
   					document.writeln("<div id=\"vote-box\" class=\"vote-box\" style=\"position: relative; margin-top:-770px;\"><img src=\"images/share_fb_btn_all.png\" name=\"share\" width=\"53\" height=\"24\" id=\"share\" style=\"margin-top: -720px;\"/>");
					document.writeln("");
					document.writeln("");
					document.writeln("");
					document.writeln("				<div class=\"vote-number\" style=\"margin-left: 60px; margin-top: -680px;\"></div>");
					document.writeln("                ");
					document.writeln("                <div class=\"vote-name\" style=\"margin-left: 140px; margin-top: -680px;\">參賽者</div>");
					document.writeln("");
					document.writeln("				<div class=\"vote-count\" style=\"margin-left: 240px; margin-top: 47px;\">123</div>");
					document.writeln("");
					document.writeln("				<div class=\"vote-box-btn\">");
					document.writeln("");
					document.writeln("				<img class=\"vote-box-btn-img\" src=\"images/btn_vote_me.png\" name=\"vote-me\" width=\"121\" height=\"39\" id=\"vote-me\" style=\"margin-top: -685px;\"/>");
					document.writeln("");
					document.writeln("				</div>");
					document.writeln("<div class=\"vote-box-x\">");
					document.writeln("");
					document.writeln("				<img src=\"images/btn_x.png\" name=\"x\" width=\"18\" height=\"18\" id=\"x\" style=\"margin-top: -720px;\"/>");　
					document.writeln("				</div>");   				
   				}

   				else{
					document.writeln("<div id=\"vote-box\" class=\"vote-box\" style=\"position: relative; margin-top:-800px;\"><img src=\"images/share_fb_btn_all.png\" name=\"share\" width=\"53\" height=\"24\" id=\"share\" />");
					document.writeln("");
					document.writeln("");
					document.writeln("");
					document.writeln("				<div class=\"vote-number\"></div>");
					document.writeln("                ");
					document.writeln("                <div class=\"vote-name\">參賽者</div>");
					document.writeln("");
					document.writeln("				<div class=\"vote-count\">123</div>");
					document.writeln("");
					document.writeln("				<div class=\"vote-box-btn\">");
					document.writeln("");
					document.writeln("				<img class=\"vote-box-btn-img\" src=\"images/btn_vote_me.png\" name=\"vote-me\" width=\"121\" height=\"39\" id=\"vote-me\" />");
					document.writeln("");
					document.writeln("				</div>");
					document.writeln("");
					document.writeln("				<div class=\"vote-box-x\">");
					document.writeln("");
					document.writeln("				<img src=\"images/btn_x.png\" name=\"x\" width=\"18\" height=\"18\" id=\"x\"/>");
					document.writeln("");
					document.writeln("				</div>");   				}
				</script>
				
				

				<div class="vote-photo">

					<img class="vote-photo-img" />

				</div>
			

				<div class="vote-intro">

					<p align="justify" class="vote-intro-text" ></p>

				</div>

				<!--臉書留言-->
				<div class="FB-com">
				
				
				<?php
		
					for($i=0;$i<count($datac);$i++)
					{
						$id = $datac[$i]['fbid'];
						echo '<div id="comments'.$i.'" value="'.$id.'" class="fb-comments" data-href="http://youngfb.com/sport/index.php?target='.$id.'" data-width="300" data-numposts="5" data-colorscheme="light" style="display:none" ></div>';
					}
					
				?>
                 
				</div>
                 
		

        </div>   <!----vote_frame-end--->
		
				<!--按讚frame-->

                                <div class="like-box" id="like-box" style="position: absolute; top: 1000px;">
				
					<div id="like1" class="fb-like" data-href="https://www.facebook.com/nicefoot" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                                        <div id="like2" class="fb-like" data-href="https://www.facebook.com/wingandlong" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                                        
				</div>
				
	<!--照片放大-->
	<div class="photo-box" style="margin-left: -400px; margin-top:-2200px; background-color:rgba(0,0,0,0.8); width:1900px; height:3700px;position: absolute;">
	
		<!--參賽者-->
		<img class="photo-box-img" style="width:800px; height:600px; border-style:none; margin-left:550px; margin-top:1250px; position: absolute;"></img>
		<!--叉叉-->
		<img class="photo-box-x" src="images/herfr-vote-box-xbtn.png" style="margin-left: 1320px; margin-top: 1255px;position: absolute; " name="x" width="25" height="26" id="x"></img>
		
	</div>

        

      	<div class="footer">     		

          <div class="page"><p align="center">

        		<img src="images/herfr-top-page-btn.png" name="top_page" width="21" height="15" border="0" id="top_page" /><img src="images/herfr-prev-page-btn.png" name="prev_page" width="14" height="15" border="0" id="prev_page" /><span class="pagetext"></span><img src="images/herfr-next-page-btn.png" name="next_page" width="13" height="15" border="0" id="next_page" /><img src="images/herfr-bottom-page-btn.png" name="bottom_page" width="21" height="15" border="0" id="bottom_page" />
				<a>跳</a>
				<input id="jump_page" name="jump_page" class="jump_page" style="width: 30px;" />
				<a>頁</a>
				<a href="#jump_page" class="jump_go"><img src="images/go.png" name="go" id="go" /></a>
				</p>
				
     	  </div>

            

      	</div>



</div> 

<!----wrapper-end--->



</body>

</html>

