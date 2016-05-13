<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>2014運動酷照徵選</title>
<link href="reset.css" rel="stylesheet" type="text/css" />
<link href="main.css" rel="stylesheet" type="text/css" />
<script src="jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){

	//右側廣告板動畫
	
	
	$('.photo-box').hide();
	
	$('#Image7').click(function(){

		FB.ui(

		{

			method: 'feed',
			
			display: 'popup',

			name: '2014運動酷照徵選',

			link: 'http://youngfb.com/yeswaterimage/index.php',

			picture: 'http://youngfb.com/sport/yeswaterimage/fb_share_img.jpg',

			caption: '挑戰『2014運動酷照』，贏得口袋DV/運動鞋墊/登機箱等大獎！'

		},

		function(response) {
			
		}



		);

	});
});

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

<div id="fb-root"></div>

<script src="https://connect.facebook.net/zh_TW/all.js"></script>

<script>

//fb初始化

window.fbAsyncInit = function() {

  FB.init({

    appId: '871040533014524', // App ID

	channelUrl : '//youngmarketing.tw/channel.html', // Channel File

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

  js.src = "//connect.facebook.net/zh_TW/sdk.js";

  fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));



</script>

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


<div id="wrapper">
<div class="main_img_s">
<div class="menu">
<!--		    <a href="http://www.footdisc.com.tw" target="_blank"><img src="images/btn_logo.png" name="logo" width="137" height="21" border="0" id="logo" /></a>-->
        <a href="https://www.facebook.com/yeswater.tea/" target="_blank" ><img src="images/btn_facebook1.png" name="Image6" width="48" height="21" border="0" id="Image6" /></a>
        <a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','images/btn_vote2.png',1)"><img src="images/btn_vote1.png" name="Image2" width="110" height="21" border="0" id="Image2" /></a>
        <a href="join.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','images/btn_join2.png',1)"><img src="images/btn_join1.png" name="Image3" width="110" height="21" border="0" id="Image3" /></a>
        <a href="style.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','images/btn_active2.png',1)"><img src="images/btn_active1.png" name="Image4" width="110" height="21" border="0" id="Image4" /></a>
        <a href="winner.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','images/btn_winner2.png',1)"><img src="images/btn_winner2.png" name="Image5" width="110" height="21" border="0" id="Image5" /></a>
        <a href="#" ><img src="images/btn_share1.png" name="Image7" width="128" height="21" border="0" id="Image7" /></a>
        <!--<div class="fb-like" data-href="https://www.facebook.com/nicefoot" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="overflow:hidden"></div>-->
        
        <br />
</div>
</div>
<div class="maim_frame"><img src="images/winner.jpg" name="winner" width="1080" height="918" border="0" id="winner" /></div>









</div>
</body>
</html>
