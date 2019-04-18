const config = require('./config');
const semver = require('semver');
let wrapper;
// Check if nodejs runtime is greater than v8.0.
// If so return wrapper which can handle async functions.
if (semver.gte(process.version, '8.0.0')){
    wrapper = require('./asyncWrapper');
  } else {
    wrapper = require('./wrapper');
  }

module.exports = wrapper
