/*
 * 
 * 
 * 2013/11/29 add connection,disconnect and msg 
 */


 var server = require('http').createServer(),
 io = require('socket.io').listen(server),
 users =[],
 mysql_db = require('./mysql-config');

server.listen(8888);

var push = {};

io.sockets.on('connection', function (socket) {

  console.warn("someone login!");
  
  socket.on('login', function (obj) {
    if(!in_array(socket.id)){
      var user = {"id":socket.id,"name":obj.name};
      users.push(user);
      broadcast();
      io.sockets.emit('message', "["+obj.name+"]: Login Success!");
      io.sockets.emit('notify', "["+obj.name+"]: Login Success!");
    }
  });


  
  socket.on('msg',function(message){
    var user = retriveUser(socket.id);
    io.sockets.emit('message', "["+user.name+"] say:"+message);
    //socket.send("["+user.name+"] say:"+message);
  });
  
  socket.on('disconnect', function () {
    io.sockets.emit('user disconnected');
    for(var i=0;i<users.length;i++) {
      var user = users[i];
      if(user.id==socket.id){
        users.splice(i, 1);
      }
      broadcast();
    }
    console.info("disconnect userOnline:"+users.length)
  });


  function broadcastUsers(users){
    users.push(user);
    broadcast();

  }

  function retriveUser(id){
   for(var i=0;i<users.length;i++) {      
    if(users[i].id == id){
      return users[i];  
    }
  }
  return null;
}

function in_array(id) {
  for(var i=0;i<users.length;i++) {      
    return (users[i].id == id)
  }
  return false;
}

function broadcast(){ 
 io.sockets.emit('onlineUser', users);
}

 push.broadcast = function() {
  console.warn(" >>> emit notify!");
  io.sockets.emit('notify', "true");
}

});



push.findNotify = function() {

    mysql_db.con.query('SELECT * FROM mat_records where notify = 0', 
      function(err, rows,fields) {
      if (err) throw err;
      console.log(rows); //This can show the queried result rows.
      if(rows.length>0){
        mysql_db.con.query('update  mat_records set notify= 1 where notify = 0');
        if(typeof push.broadcast == 'function'){ 
          push.broadcast();
        }
      }
      // for(var i = 0 ;i < rows.length;i++){
      //   console.warn("["+i+"]:"+rows[i].notify);
      // }
    //mysql_db.con.end(); //End of connection
  });
}

//Start point
// setInterval(function(){
//  push.findNotify();
// },5000);



