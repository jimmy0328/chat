<!DOCTYPE html>
<html>
<head>
  <title>teleMAT - DrSays</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <meta name="description" content="teleMAT">
  <meta name="author" content="DrSays">
  <script src="assets/js/jquery-1.10.1.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="//192.168.0.100:8888/socket.io/socket.io.js?v=1"></script>
  <script>
  </script>
</head>
<body>
  <br/>
  <form class="form-horizontal" role="form" >

    <div class="form-group">
      <div class="col-lg-2 control-label"></div>
      <div id="onlineUsers" class="col-lg-8">
        <h1>TOS-Tasks</h1>
      </div>
    </div>


    <div class="form-group">
      <div class="col-lg-2 control-label"></div>
      <div id="onlineUsers" class="col-lg-8"></div>
    </div>
    <div class="form-group" id="loginDev">
      <label for="receiver" class="col-lg-2 control-label">YourName:</label>
      <div class="col-lg-2">
        <input type="txt" class="form-control" id="username"> 

      </div>
      <div class="col-lg-2">
        <input type="button" class="btn btn-warning" id="loginBtn" value="Login">
      </div>
    </div>
    <div class="form-group" id="msgDiv">
      <label for="receiver" class="col-lg-2 control-label">Msg:</label>
      <div class="col-lg-6">
        <input type="txt" class="form-control" id="msg"> 
      </div>
      <div class="col-lg-2">
        <input type="button" class="btn btn-primary" id="sendBtn" value="Send">
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-2 control-label"></div>
      <div class="col-lg-8">
        <textarea id="chatContent" style='background:black;color:yellow;' class="form-control" rows="20" width="90%"></textarea>
      </div>
    </div>
    <script type="text/javascript">

    $("#msg").keyup(function(event){
      if(event.keyCode == 13){
        sendMsg();
      }
    });

    $("#username").keyup(function(event){
      if(event.keyCode == 13){
       login();
     }
   });

    $(function(){
      $("#loginDev").show();
      $("#msgDiv").hide();
    });

    var socket = io.connect('//192.168.0.100:8888');
    var color = ["primary","info","warn","danger"];
    socket.on('onlineUser', function (data) {
      var html = "";
      for(var i = 0 ;i < data.length;i++){
        var tagColor = i % color.length;
        html+="<span class='label label-"+color[tagColor]+"'>";
        html+=data[i].name;
        html+="</span>";      
      }
      $("#onlineUsers").html(html);    
    });

    $("#loginBtn").on("click",login);

    $("#sendBtn").on("click",function(){
      sendMsg();
    });

    socket.on('message', function (message) {
      $('#chatContent').prepend(message+"\n"); 
    });

    socket.on('notify', function (message) {
   // alert(message);
 });

    function login(){
     var username = $("#username").val();
     socket.emit("login",
     {
      name: username
    });
     $("#loginDev").hide();
     $("#msgDiv").show();
   }
   function sendMsg(){
    var msg = $("#msg").val();
    socket.emit('msg',msg);
  }


  </script>
</form>
</body>
</html>