# Wavefront reporters for metrics

A node.js Wavefront reporters for [metrics](https://www.npmjs.com/package/metrics).

# Installation

    $ npm install wavefrontmetrics

# Usage

## Wavefront Reporters

```javascript
const metrics = require('wavefrontmetrics');
const registry = new metrics.Registry();

// Report directly to a Wavefront server
const directReporter = new metrics.WavefrontDirectReporter(registry, "wavefront.nodejs.direct", "<cluster>.wavefront.com", "<wavefront_api_token>", { "tag0": "default", "source": "wavefront-nodejs-example"});
directReporter.start(5000);

// Report to a Wavefront proxy
const proxyReporter = new metrics.WavefrontProxyReporter(registry, "wavefront.nodejs.proxy", "localhost", 2878, { "tag0": "default", "source": "wavefront-nodejs-example"});
proxyReporter.start(5000);
```


## Metrics
```javascript
const metrics = require('wavefrontmetrics');
const registry = new metrics.Registry();

// Counter with metric level tags
let c = new metrics.Counter();
registry.addTaggedMetric("http.requests", c, {"key1":"val1"});
c.inc();

// Histogram
let h = new metrics.Histogram();
registry.addTaggedMetric("request.duration", h, {"key1":"val1"});
h.update(50);

// Meter
let m = new metrics.Meter();
registry.addTaggedMetric("request.meter", m, {"key1":"val1"});
m.mark(1);

// Timer
let t = new metrics.Timer();
registry.addTaggedMetric("request.timer", m, {"key1":"val1"});
t.update(50);
```

## DeltaCounter

```javascript
const metrics = require('wavefrontmetrics');
const registry = new metrics.Registry();

let deltaCounter = new metrics.Counter();
let deltaName = metrics.deltaCounterName("http.requests");
registry.addTaggedMetric(deltaName, deltaCounter, {"key1":"val1"});
deltaCounter.inc(10);
```
