'use strict';
const ScheduledReporter = require('metrics').ScheduledReporter,
  Histogram = require('metrics').Histogram,
  util = require('util'),
  https = require('https'),
  zlib = require('zlib'),
  delta = require('./delta'),
  formatter = require('./wavefront-metrics-formatter'),
  helper = require('./helper');

const agent = new https.Agent({
  keepAlive: true
});

class WavefrontDirectReporter extends ScheduledReporter {

  /**
   * A custom reporter that sends metrics to a wavefront server using the wavefrontf data format.
   * @param {Report} registry registry instance whose metrics to report on.
   * @param {String} prefix A string to prefix on each metric (i.e. app.hostserver)
   * @param {String} server The wavefront server of the form clusterName.wavefront.com.
   * @param {String} token The Wavefront API token with direct ingestion permission.
   * @param {object} tags The tags to add to wavefront measurements, defaults to none if not specified.
   * @param {String} gzip True to gzip the metrics posted to Wavefront.
   * @constructor
   */
  constructor(registry, prefix, server, token, globaltags, gzip) {
    super(registry);
    this.prefix = prefix;
    this.server = server;
    this.token = token;
    this.batchSize = 10000;
    this.gzip = gzip;
    this.globaltags = !helper.isEmpty(globaltags) ? globaltags : {};
  }

  report() {
    const metrics = this.getMetrics();
    const self = this;
    let points = [];

    if (metrics.counters.length != 0) {
      metrics.counters.forEach(count => self.appendCounter(count, points));
    }

    if (metrics.meters.length != 0) {
      metrics.meters.forEach(meter => self.appendMeter(meter, points));
    }

    if (metrics.timers.length != 0) {
      metrics.timers.forEach(timer => {
        // Don't log timer if its recorded no metrics.
        if (timer.min() != null) {
          self.appendTimer(timer, points);
        }
      });
    }

    if (metrics.histograms.length != 0) {
      metrics.histograms.forEach(histogram => {
        // Don't log histogram if its recorded no metrics.
        if (histogram.min != null) {
          self.appendHistogram(histogram, points);
        }
      });
    }

    if (points.length != 0) {
      if (points.length >= self.batchSize) {
        chunks = getChunks(points, self.batchSize);
        for (i = 0; i < chunks.length; i++) {
          self.reportPoints(chunks[i]);
        }
      } else {
        self.reportPoints(points);
      }
    }
  }

  reportPoints(points) {
    const self = this;
    const pointsStr = points.join('\n');
    let options = {
      hostname: self.server,
      path: '/report?f=graphite_v2',
      method: 'POST',
      agent: agent,
      headers: {
           'Content-Type': 'text/plain',
           'Authorization': 'Bearer ' + self.token
      }
    };

    if (self.gzip) {
      const buffer = Buffer.from(pointsStr);
      zlib.gzip(buffer, (err, buffer) => {
        if (!err) {
          options.headers['Content-Encoding'] = 'gzip';
          options.headers['Content-Length'] = buffer.length;
          self.reportToServer(buffer, options);
        } else {
          console.error(err);
        }
      });
    } else {
      options.headers['Content-Length'] = pointsStr.length;
      self.reportToServer(pointsStr, options);
    }
  }

  reportToServer(data, options) {
    let req = https.request(options, (res) => {
      res.on('data', (d) => {
        process.stdout.write(d);
      });
    });

    req.on('error', (e) => {
      console.error(e);
    });

    req.write(data);
    req.end();
  }

  appendCounter(counter, points) {
    let tags = helper.tagger(this.registry.getTags(counter.name), this.globaltags);
    points.push(formatter.counterPoint(counter, this.prefix, '', tags));
  }

  appendMeter(meter, points) {
    let tags = helper.tagger(this.registry.getTags(meter.name), this.globaltags);
    points.push(...formatter.meterPoints(meter, this.prefix, '', tags));
  }

  appendTimer(timer, points) {
    let tags = helper.tagger(this.registry.getTags(timer.name), this.globaltags);
    points.push(...formatter.timerPoints(timer, this.prefix, '', tags));
  }

  appendHistogram(histogram, points) {
    let tags = helper.tagger(this.registry.getTags(histogram.name), this.globaltags);
    points.push(...formatter.histoPoints(histogram, this.prefix, '', tags));
  }
}

/**
 * Returns an array with arrays of the given size.
 *
 * @param points {Array} Array to split
 * @param chunkSize {Integer} Size of every chunk
 */
function getChunks(points, chunk_size){
    let chunks = [];
    while (points.length) {
        chunks.push(points.splice(0, chunk_size));
    }
    return chunks;
}

module.exports = WavefrontDirectReporter;
