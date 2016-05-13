//將個人資訊載入
function init_vote_frame(chosen,number){
	var index=parseInt(number)+parseInt(chosen);
	$('.vote-box').show();
	$('.vote-number').text(index+". ");
	$('.vote-name').text(datac[index-1]['name']);
	if(countv[index]!=undefined)
		$('.vote-count').text(countv[index]+"");
	else
		$('.vote-count').text('0');
	
	$('.vote-photo-img').css({'background':'url("images/candidate/'+index+'.jpg?rand=1") no-repeat','background-size':"contain",'background-position':"center"});
	$('.vote-intro-text').html(datac[index-1]['paragraph']);
	
	for(i=0;i<datac.length;i=i+1)
	{
		var temp = document.getElementById('comments'+i);
		//alert(temp.getAttribute("style"));
		if($('#comments'+i).attr('value') == datac[index-1]['fbid'])
		{
			temp.setAttribute("style","display:visibility");
		}
	}
}
