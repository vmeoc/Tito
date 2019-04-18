'use strict';

const util = require('util');
const deltaPrefix = '\u2206';
const altDeltaPrefix = '\u0394';

function deltaCounterName(metricName) {
  return module.exports.hasDeltaPrefix(metricName) ? metricName : deltaPrefix + metricName;
}

function hasDeltaPrefix(metricName) {
  return metricName ? metricName.startsWith(deltaPrefix) : false;
}

function resetAndGetName(counter, prefix, name, value) {
  counter.dec(value);
  return prefix ? `${deltaPrefix + prefix}.${name.substring(1)}` : `${deltaPrefix}${name.substring(1)}`;
}

module.exports = {
  deltaCounterName,
  hasDeltaPrefix,
  resetAndGetName
};
