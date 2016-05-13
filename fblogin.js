var sr;
var uid;
var name;
function fblogin() {
FB.getLoginStatus(function(response) {
  //alert(response.name);
  if (response.status === 'connected') {
    console.log('Logged in.');
  }
  else {
    FB.login();
  }
});

}

function votefblogin() {
FB.getLoginStatus(function(response) {
  //alert(response.authResponse.userID);
  
  if (response.status === 'connected') {
  sr=response.authResponse.signedRequest;
    console.log('Logged in.');
  }
  else {
    FB.login();
  }
}

);

}


function fbloginForJoin()
{

FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
				$("#myForm").submit();

    console.log('Logged in.');
  }
  else {


  	 FB.login(function(response) {

console.log(response)

   // handle the response
 }, {scope: 'public_profile,email'});

	//$("#myForm").submit();
  }
});
return;
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }
 
    return true;
}

function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }