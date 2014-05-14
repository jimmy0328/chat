
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : '192.168.0.94',
  user     : 'root',
  password : 'such520',
  database : 'telemat'
});

// connection.connect(function(err) {
//   console.warn("connect success!");
// });

// if(mysql.createClient) {
//   console.warn(">>> create client db1");
//     db = mysql.createClient(db_options);
// } else {
//    console.warn(">>> create client db2");
//     db = mysql.Client(db_options);
//     db.connect(function(err) {
//         if(err) {
//             console.error('connect db ' + db.host + ' error: ' + err);
//             process.exit();
//         }
//     });
// }
exports.con = connection;
