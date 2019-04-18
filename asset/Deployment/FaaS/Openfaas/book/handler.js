"use strict"
var dbConnector = require('./db-connector');

module.exports = (context, callback) => {
    var data = JSON.parse(context);
    var str = 'UPDATE TitoTable SET available = 0 WHERE name = "' + data.name + '"';
    dbConnector(str, (err, results) => {
        if (err) {
		throw err;
        }
  
    callback(undefined, JSON.stringify(results));
    });    
}
