"use strict"
var dbConnector = require('./db-connector');

module.exports = (context, callback) => {
  // Call dbConnector function to connect to the database then execute a query
    dbConnector('SELECT * FROM TitoTable', (err, results) => {
        if (err) {
		throw err;
        }
    callback(undefined, JSON.stringify(results));
    });
}
