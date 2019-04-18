var expect = require('chai').expect;
var metrics = require('../lib/index');
var delta = require('../lib/delta');

describe('resetAndGetName', function() {
  it('Tests delta resetAndGetName', function() {
    var counter = new metrics.Counter();
    counter.inc();
    var deltaName = delta.deltaCounterName('deltaCounterName');
    var name = delta.resetAndGetName(counter, 'delta.test.prefix', deltaName, 1);
    expect(name.charAt(0)).to.be.equal('\u2206');
  });
});
