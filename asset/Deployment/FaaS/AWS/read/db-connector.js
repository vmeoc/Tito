var mysql = require('mysql');

// On exporte ici une fonction
module.exports = (query) => {
    return new Promise((resolve,reject)=>{
    var con = mysql.createConnection({
        host: "tito4.cz2lccqj0gzo.eu-west-1.rds.amazonaws.com",
        user: "root",
        password: "Tito2016",
        database: "Tito4DB"
});

    // Open database connection
    con.connect();

    // -----------------------------------------------------
    // Execute query, pass callback parameter
    con.query(query, (error,results)=>{
        if (error){
            return reject(error);
        }
            return resolve(results);
    }); // <-- callback function from parameter 
    // -----------------------------------------------------
    // Close database connection
    con.end(); 
    })
  
}

