const server = process.env.WAVEFRONT_URL;
const authToken = process.env.WAVEFRONT_API_TOKEN;
const isReportStandardMetrics = process.env.REPORT_STANDARD_METRICS !== 'False' && process.env.REPORT_STANDARD_METRICS  !== 'false'

// Validate Environment variables.
if (!server) {
  throw new Error('Environment variable WAVEFRONT_URL is not set.');
}
if (!authToken) {
  throw new Error('Environment variable WAVEFRONT_API_TOKEN is not set.');
}

// Metric prefix for all standard lambda metrics reported by wrapper.
const metricPrefix = "aws.lambda.wf.";

// Standard Lambda Metrics reported by wrapper.
const standardLambdaMetrics = {
  invocationsCounter : metricPrefix + 'invocations.count',
  coldStartsCounter : metricPrefix + 'coldstarts.count',
  errorsCounter : metricPrefix + 'errors.count',
  durationValue : metricPrefix + 'duration.value'
};
let isColdStart = true;

module.exports = {
  server,
  authToken,
  isReportStandardMetrics,
  standardLambdaMetrics,
  isColdStart
};
