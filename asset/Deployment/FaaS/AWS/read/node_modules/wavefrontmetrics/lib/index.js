const Metrics = require('metrics');
const Delta = require('./delta');

exports.Histogram = Metrics.Histogram;
exports.Meter = Metrics.Meter;
exports.Counter = Metrics.Counter;
exports.Timer = Metrics.Timer;

exports.deltaCounterName = Delta.deltaCounterName;
exports.Registry = require('./registry');
exports.WavefrontProxyReporter = require('./wavefront-proxy-reporter');
exports.WavefrontDirectReporter = require('./wavefront-direct-reporter');
exports.ConsoleReporter = Metrics.ConsoleReporter;
