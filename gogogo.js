function joinForm()
{	
    if(joinChkForm())
	{
			//抓出fbname之後繼續
			fblogin();
			FB.api('/me', function(response) {
				name = response.name;
				id = response.id;
				$("#fbname").val(name);
				$("#fbid").val(id);
				if( $("#fbname").val() == "undefined" ){
					fblogin();
				} else {
				$("#myForm").submit();

				}
			});
	
    }else{
			console.log("C4")

    }
}

function joinChkForm(){

	var checkName=$("#name").val();
	
    if($("#name").val()==""){
        alert("請輸入姓名！");
		$("#name").focus();
        return false;
    }
	if(checkName.match(/\d+/g)!=null)
	{
		alert("姓名內不得包含數字！");
		$("#name").focus();
        return false;
	}
	
    if($("#tel").val()==""){
        alert("請輸入電話！");
		$("#tel").focus();
        return false;
    }
	if($("#mail").val()==""){
		alert("請輸入email！");
		$("#mail").focus();
        return false;
	}
        var checkMail = $("#mail").val();
        if(checkMail.match(/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|tw|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/) == null){
            alert("請輸入正確email！");
            $("#mail").focus();
            return false;
        }
    if($("#about").val()==""){
        alert("請輸入運動心得！");
		$("#about").focus();
        return false;
    }
	if($('.imagetext').text()=="尚未選擇")
	{
		alert("請上傳運動照片！");
		return false;
	}
	
    return true;
}

function selectPhoto()
{
	//alert("上傳相片");
	$('.file').click();
}