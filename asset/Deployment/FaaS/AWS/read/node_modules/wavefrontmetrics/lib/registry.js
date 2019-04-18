'use strict';

const Report = require('metrics').Report,
  helper = require('./helper');

class Registry extends Report {

  constructor(trackedMetrics) {
    super(trackedMetrics);
    this.trackedTags = {};
  }

  addTaggedMetric(metricName, metric, tags) {
    this.addMetric(metricName, metric);
    if (!helper.isEmpty(tags)) {
      this.trackedTags[metricName] = tags;
    }
  }

  getTags(metricName) {
    if (!this.trackedTags[metricName]) { return; }
    return this.trackedTags[metricName];
  }
}

module.exports = Registry;
