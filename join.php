<?php
	define('MB', 1048576);

	include('protected/db_con.php');	
	$script="";
	$joinpost = 0;
	//報名成功的動作
	if(isset($_POST['send']) && $_POST['send']==1)
	{
		extract($_POST);	//提取所有submit的資料
		
		//用fbid作判定，檢查資料庫是否有資料，以免重複報名
		$sql =  mysql_query("SELECT num FROM candidate WHERE fbid = '$fbid'");
		if(mysql_num_rows($sql) == 0)
		{
			//上傳檔案
			if($_FILES['fileupload']['name']!="" && $_FILES["fileupload"]["tmp_name"]!="")
			{
                if ($_FILES['fileupload']['size'] > 2*MB)	//檢查檔案大小
				{
                    $script = "<script>alert('很抱歉，照片檔案過大，請先壓縮再進行上傳!');top.location.href='join.php';</script>";
					$joinpost = 0;
                }
				else if(!isset($fbid) || !isset($fbname) || empty($fbid) || empty($fbname))
					$script = "<script>alert('很抱歉，報名失敗，請稍候再試');top.location.href='join.php';</script>";
				else
				{
                    //取檔名
                    $sql =  mysql_query("SELECT num FROM candidate ORDER BY num DESC");
                    $sn = mysql_num_rows($sql);
					//抓資料庫的資料，以便決定參選者編號
                    if($sn == 0){
                        $sn = 1;
                    }else{
                        $sn++;
                    }
                    $newFilename = $sn.'.jpg';
                    copy ($_FILES["fileupload"]["tmp_name"],'images/candidate/'.$newFilename);
					
                    $newFilename = $sn.'.jpg';
                    copy ($_FILES["fileupload"]["tmp_name"],'images/candidate/backup/'.$newFilename);
					
					$date = Date("Y-m-d");
					$time = Date("H:i:s");
					//$script = "<script>alert('$fbname!');</script>";
						
					mysql_query("INSERT INTO `candidate`(`paragraph`, `name`, `phone`, `email`, `fbid`, `fbname`, `candidno`, `date`, `time`, `count`) 
					VALUES ('$about','$name','$tel','$mail','$fbid','$fbname','$sn','$date','$time','0')");
					$joinpost = 1;
					$script = "<script>alert('成功報名，感謝您的參加！');</script>";
                }
			}
			else
				$script = "<script>alert('很抱歉，照片上傳失敗，請再嘗試報名一次');top.location.href='join.php';</script>";
		}
		else
		{
			$joinpost = 2;
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8" >
<?php   echo $script;?>
<title>2014運動酷照徵選</title>

<link href="reset.css" rel="stylesheet" type="text/css" />
<link href="main.css" rel="stylesheet" type="text/css" />

<script charset="utf-8" language="javascript" type="text/javascript" src="gogogo.js"></script>
<script src="jquery.js"></script>
<script src="fblogin.js"></script>
<script type="text/javascript"></script>

<script>
var postJoin = <?php echo $joinpost; ?>;
var like1=false,like2=false;
var loc="join";
var whoClick = "";

$(document).ready(function(){

	if(postJoin==1)
	{
		var url = "http://youngfb.com/yeswaterimage/images/fb_share_img.jpg";
		var result;
		result="挑戰『2014運動酷照』，贏得口袋DV/運動鞋墊/登機箱等大獎！";
	
		var body = result;
		/*FB.getLoginStatus(function (response) {
			if(response.status === 'connected')
			{
				FB.api('/me/feed/', 'post', { message: body,link: 'http://youngfb.com/globalmall/',picture: url,name: 'G妞童話公主選拔' }, function(response) {
					if (!response || response.error) {
					alert(response.error.message);
					alert('Error occured');
				} 
				else {
					
				//}});	
			}
		});*/
		
		window.location="index.php";
	}
	else if(postJoin==2)
	{
		alert("已經有參加過了喔! 每人限參加一次!");
		window.location = "index.php";
	}

	$('.file').hide();
//	$('.like-box').hide();
	//先把讚鈕弄到看不到(但是不能隱藏)
	var div = document.getElementById('like-box');
	div.style.position = 'absolute';
	div.style.top = '-1000px';
	
	$('.info_upload').click(function(){
		joinForm();
	});
	
	$('.upload').click(function(){
		selectPhoto();
	});
	
	//選擇檔案後提交
	$('#file').change(function() {

		//檢查副檔名
		var ext = $('.file').val().match(/\.([^\.]+)$/)[1];
		switch(ext.toLowerCase())
		{
			case 'jpg':
			case 'bmp':
			case 'png':
			case 'jpeg':
			case 'gif':
			case 'tif':
				break;
			default:
				alert('檔案格式不符，請上傳圖片!');
				$('.file').val('');
		}
		
		var url = $('.file').val();
		url = url.substring(12);		
		if(url!="")
		{
			alert("OK!");
			$('.imagetext').text("已選擇");
		}
		else
		{
			alert("您未選擇");;
			$('.imagetext').text("尚未選擇");
		}
		//這裡ie讀不到
		//alert($('.file').val());
		 //alert($('#file'));
		 //alert(this);
		 readURL(this);
	});
	

	//右側廣告板動畫
	
	
	$('.photo-box').hide();
	
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
	
	
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
            
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }
            
        reader.readAsDataURL(input.files[0]);
    }
	else
	{
		$('#preview').attr('src', '#');
	}
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

<body onload="MM_preloadImages('images/herfr-join-02-btn.png','images/herfr-style-02-btn.png','images/herfr-product-02-btn.png','images/herfr-winner-02-btn.png');">

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

<script src="https://connect.facebook.net/zh_TW/all.js"></script>

<script>

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
<div class="main_img_s">
<div class="menu">
		<!--<a href="http://www.footdisc.com.tw" target="_blank"><img src="images/btn_logo.png" name="logo" width="137" height="21" border="0" id="logo" /></a>-->
		<a href="https://www.facebook.com/yeswater.tea/" target="_blank" ><img src="images/btn_facebook1.png" name="Image6" width="48" height="21" border="0" id="Image6" /></a>
        <a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','images/btn_vote2.png',1)"><img src="images/btn_vote1.png" name="Image2" width="110" height="21" border="0" id="Image2" /></a>
        <a href="join.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','images/btn_join2.png',1)"><img src="images/btn_join2.png" name="Image3" width="110" height="21" border="0" id="Image3" /></a>
        <a href="style.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','images/btn_active2.png',1)"><img src="images/btn_active1.png" name="Image4" width="110" height="21" border="0" id="Image4" /></a>
        <a href="winner.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','images/btn_winner2.png',1)"><img src="images/btn_winner1.png" name="Image5" width="110" height="21" border="0" id="Image5" /></a>
        <a href="#" ><img src="images/btn_share1.png" name="Image7" width="128" height="21" border="0" id="Image7" /></a>
        <!--<div class="fb-like" data-href="https://www.facebook.com/nicefoot" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="overflow:hidden"></div>-->
        <br />
</div>
</div>

<form id="myForm" method="post" name="myForm" enctype="multipart/form-data">
<input type="hidden" name="send" value="1">
<div class="maim_frame">
<div class="join">


<input id="name" name="name" type="text" style="height:25px; width:100px; margin-top:265px; margin-left:-110px;" />
<br>
<input id="tel" name="tel" type="text" style="height:25px; width:120px; margin-top:15px; margin-left:-90px;" />
<br>
<input id="mail" name="mail" type="text" style="height:25px; width:200px; margin-top:15px; margin-left:-10px;" />
<br>
<textarea id="about" name="about" maxlength="100" style="height:120px; width:400px; margin-top:15px; margin-left:190px;"></textarea>
<br>

<input class="file" id="file" type="file" name="fileupload" accept="image/*">
<img id="preview" class="preview" src="images/join_see.png" alt="預覽圖" style="width: auto;height:126px; margin:20px 0px 0px 400px;" />	
<!--用以觀看預覽圖-->
<br>
<input class="fbid" id="fbid" type="text" name="fbid" style="display: none;"/>
<input class="fbname" id="fbname" type="text" name="fbname" style="display: none;"/>

<img src="images/herfr-join-ok.png" class="info_upload" name="info_upload" width="121" height="39" border="0" id="info_upload" /></a>

</div>

<div id="upload" class="upload">
<p class="imagetext" style="position:relative;display:none;" >尚未選擇</p>
</div>

</div>

</form>


<!--按讚frame-->

                <div class="like-box-2" id="like-box" style="position: absolute; top: 1000px;">
			<div id="like1" class="fb-like" data-href="https://www.facebook.com/nicefoot" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
			<div id="like2" class="fb-like" data-href="https://www.facebook.com/wingandlong" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
		</div>
		

</div>
</body>
</html>
