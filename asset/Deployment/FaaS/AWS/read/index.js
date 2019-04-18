"use strict"
const dbConnector = require('./db-connector');

exports.handler = async (event) => {
    try{
		const results = await dbConnector('SELECT * FROM TitoTable');
		const response = {
    	    statusCode: 200,
    	    headers: {
    "Access-Control-Allow-Origin" : "*", // Required for CORS support to work
    "Access-Control-Allow-Credentials" : true // Required for cookies, authorization headers with HTTPS 
  },
   		    body: JSON.stringify(results),
   		 };
    	return response;
    } catch (e){
		const response = {
      	  	statusCode: 500,
        	body: e.message,
    	};
    	return response;
    }    
};
