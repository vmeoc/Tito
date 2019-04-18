"use strict"
var dbConnector = require('./db-connector');

module.exports = (context, callback) => {
  // Call dbConnector function to connect to the database then execute a query
    dbConnector('UPDATE TitoTable SET available = 1', (err, results) => {
        if (err) {
		throw err;
        }
    callback(undefined, JSON.stringify(results));
    });
}
