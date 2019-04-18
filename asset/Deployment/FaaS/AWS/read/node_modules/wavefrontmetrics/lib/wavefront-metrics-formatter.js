'use strict';

const delta = require('./delta');
const Histogram = require('metrics').Histogram;

function counterPoint(counter, prefix, ts, tags) {
  if (delta.hasDeltaPrefix(counter.name)) {
    const value = counter.count;
    const name = delta.resetAndGetName(counter, prefix, counter.name, value);
    return pointLine('', name, '', value, ts, tags);
  } else {
    return pointLine(prefix, counter.name, '', counter.count, ts, tags);
  }
}

function meterPoints(meter, prefix, ts, tags) {
  let points = [];
  points.push(pointLine(prefix, meter.name, '.count', meter.count, ts, tags));
  points.push(pointLine(prefix, meter.name, '.mean_rate', meter.meanRate(), ts, tags));
  points.push(pointLine(prefix, meter.name, '.m1_rate', meter.oneMinuteRate(), ts, tags));
  points.push(pointLine(prefix, meter.name, '.m5_rate', meter.fiveMinuteRate(), ts, tags));
  points.push(pointLine(prefix, meter.name, '.m15_rate', meter.fifteenMinuteRate(), ts, tags));
  return points;
}

function timerPoints(timer, prefix, ts, tags) {
  let points = [];
  points.push(pointLine(prefix, timer.name, '.count', timer.count(), ts, tags));
  points.push(pointLine(prefix, timer.name, '.mean_rate', timer.meanRate(), ts, tags));
  points.push(pointLine(prefix, timer.name, '.m1_rate', timer.oneMinuteRate(), ts, tags));
  points.push(pointLine(prefix, timer.name, '.m5_rate', timer.fiveMinuteRate(), ts, tags));
  points.push(pointLine(prefix, timer.name, '.m15_rate', timer.fifteenMinuteRate(), ts, tags));
  return points.concat(histoPoints(timer, prefix, ts, tags));
}

function histoPoints(histo, prefix, ts, tags) {
  let points = [];
  const isHisto = histo instanceof Histogram;
  if (isHisto) {
    // send count if a histogram, otherwise assume this metric is being
    // printed as part of another (like a timer).
    points.push(pointLine(prefix, histo.name, '.count', histo.count, ts, tags));
  }

  let percentiles = histo.percentiles([.50,.75,.95,.98,.99,.999]);
  points.push(pointLine(prefix, histo.name, '.min', isHisto? histo.min : histo.min(), ts, tags));
  points.push(pointLine(prefix, histo.name, '.mean', histo.mean(), ts, tags));
  points.push(pointLine(prefix, histo.name, '.max', isHisto ? histo.max: histo.max(), ts, tags));
  points.push(pointLine(prefix, histo.name, '.stddev', histo.stdDev(), ts, tags));
  points.push(pointLine(prefix, histo.name, '.p50', percentiles[.50], ts, tags));
  points.push(pointLine(prefix, histo.name, '.p75', percentiles[.75], ts, tags));
  points.push(pointLine(prefix, histo.name, '.p95', percentiles[.95], ts, tags));
  points.push(pointLine(prefix, histo.name, '.p98', percentiles[.98], ts, tags));
  points.push(pointLine(prefix, histo.name, '.p99', percentiles[.99], ts, tags));
  points.push(pointLine(prefix, histo.name, '.p999', percentiles[.999], ts, tags));
  return points;
}

function pointLine(prefix, name, suffix, value, ts, tags) {
  tags = tags || '';
  let metric = prefix ? `${prefix}.${name}${suffix}` : `${name}${suffix}`;
  if (ts) {
    return `${metric} ${value} ${ts} ${tags}`;
  } else {
    return `${metric} ${value} ${tags}`;
  }
}

module.exports = {
  counterPoint,
  meterPoints,
  timerPoints,
  histoPoints
};
