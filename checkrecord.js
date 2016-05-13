function vote(){
	//alert(sr + "1" + index + "2" + name + "3" + targetname + "4"+myip);
	$.ajax({
		type:"GET",
		url:'vote.php',
		data:{sr:sr,target:index,fbname:name,targetname:targetname,ip:myip},
		//dateType:"text",
		success:function(msg){
			//alert(msg);
			voteclick = false;
			if(msg.match('002'))
			{
				alert("今日已投票過，請明天再來!每人一天只能投ㄧ票!");
				window.location="index.php?page="+page;
				$(".vote-box-btn-img").attr("src","images/herfr-vote-me-btn-02.png");
			}
			if(msg.match('006'))
			{
				alert("相同IP位址一天只能投五票!");
				window.location="index.php?page="+page;
				$(".vote-box-btn-img").attr("src","images/herfr-vote-me-btn-02.png");
			}
			else if(msg.match('004')){alert('投票時間已過，感謝您的支持！');}
			else if(msg.match('003')) 
			{ 
				alert("已投票成功了喔!感謝您的支持!");
				$(".vote-box-btn-img").attr("src","images/herfr-vote-me-btn-02.png");
				var url = "http://youngfb.com/sport/images/fb_share_img.jpg";
				var result;
				result="挑戰『2014運動酷照』，贏得口袋DV/運動鞋墊/登機箱等大獎！";
	
				var body = result;
				FB.getLoginStatus(function (response) {
				if(response.status === 'connected')
				{
					/*FB.api('/me/feed/', 'post', { message: body,link: 'http://youngfb.com/wiup/index.php?page='+page ,picture: url,name: 'wi-up 日本戰利品PK讚' }, function(response) {
					if (!response || response.error) {
						alert(response.error.message);
						alert('Error occured');
					} 
					else 
					{*/
						location.reload();
					//}});	
				}

				});
			}
			else if(msg.match('005'))
			{
				alert("投票無效，請稍候再試");
				location.reload();
			}
		},
		/*error:function(e){
			alert(e.message);
		}*/

	});
}