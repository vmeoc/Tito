const expect = require('chai').expect;
const metrics = require('../lib/index');
const delta = require('../lib/delta');
const formatter = require('../lib/wavefront-metrics-formatter');

describe('counterPoint', function() {
  it('Validate counter point format', function() {
    const counter = new metrics.Counter();
    counter.name = "requests.counter";
    counter.inc();

    let point = formatter.counterPoint(counter, 'test', '', "key1=\"val1\"");
    expect(point).to.be.equal('test.requests.counter 1 key1=\"val1\"');

    point = formatter.counterPoint(counter, 'test', '1350450000', "key1=\"val1\"")
    expect(point).to.be.equal('test.requests.counter 1 1350450000 key1=\"val1\"');
  });
});

describe('deltaPoint', function() {
  it('Validate delta point format', function() {
    const counter = new metrics.Counter();
    counter.name = delta.deltaCounterName("requests.counter");
    counter.inc();

    let point = formatter.counterPoint(counter, 'test', '', "key1=\"val1\"");
    expect(point).to.be.equal('\u2206test.requests.counter 1 key1=\"val1\"');
  });
});

describe('meterPoints', function() {
  it('Validate meter point format', function() {
    const meter = new metrics.Meter();
    meter.name = "requests.meter";
    meter.mark(10);

    let points = formatter.meterPoints(meter, 'test', '', "key1=\"val1\"");
    console.log(points);
    expect(5).to.be.equal(points.length);
    expect(points[0]).to.be.equal('test.requests.meter.count 10 key1=\"val1\"');
  });
});

describe('timerPoints', function() {
  it('Validate timer point format', function() {
    const timer = new metrics.Timer();
    timer.name = "requests.timer";
    timer.update(10);

    let points = formatter.timerPoints(timer, 'test', '', "key1=\"val1\"");
    console.log(points);
    expect(15).to.be.equal(points.length);
    expect(points[0]).to.be.equal('test.requests.timer.count 1 key1=\"val1\"');
  });
});

describe('histoPoints', function() {
  it('Validate timer point format', function() {
    const histo = new metrics.Histogram();
    histo.name = "requests.histo";
    histo.update(10);

    let points = formatter.histoPoints(histo, 'test', '', "key1=\"val1\"");
    console.log(points);
    expect(11).to.be.equal(points.length);
    expect(points[0]).to.be.equal('test.requests.histo.count 1 key1=\"val1\"');
  });
});
