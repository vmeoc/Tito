# wavefront-lambda-nodejs

This is a Wavefront Nodejs wrapper for AWS Lambda to enable reporting standard lambda metrics and custom app metrics directly to wavefront.

## Requirements
Node.js runtime v8.10

## Installation
```
npm install wavefront-lambda
```

## Environment variables
WAVEFRONT_URL = \<INSTANCE>.wavefront.com  
WAVEFRONT_API_TOKEN = Wavefront API token with Direct Data Ingestion permission.  
REPORT_STANDARD_METRICS = Set to False or false to not report standard lambda metrics directly to wavefront.  

## Usage

Wrap your AWS Lambda handler function.

```javascript
const wavefrontLambda = require('wavefront-lambda')
const metrics = require('wavefrontmetrics');

exports.myHandler = wavefrontLambda.wrapper(function(event, context, callback) {
  // your code
});
```

## Standard Lambda Metrics reported by Wavefront Lambda wrapper

The Lambda wrapper sends the following standard lambda metrics to wavefront:

| Metric Name                       |  Type              | Description                                                             |
| ----------------------------------|:------------------:| ----------------------------------------------------------------------- |
| aws.lambda.wf.invocations.count   | Delta Counter      | Count of number of lambda function invocations aggregated at the server.|
| aws.lambda.wf.errors.count        | Delta Counter      | Count of number of errors aggregated at the server.                     |
| aws.lambda.wf.coldstarts.count    | Delta Counter      | Count of number of cold starts aggregated at the server.                |
| aws.lambda.wf.duration.value      | Gauge              | Execution time of the Lambda handler function in milliseconds.          |

The Lambda wrapper adds the following point tags to all metrics sent to wavefront:

| Point Tag             | Description                                                                   |
| --------------------- | ----------------------------------------------------------------------------- |
| LambdaArn             | ARN(Amazon Resource Name) of the Lambda function.                             |
| Region                | AWS Region of the Lambda function.                                            |
| accountId             | AWS Account ID from which the Lambda function was invoked.                    |
| ExecutedVersion       | The version of Lambda function.                                               |
| FunctionName          | The name of Lambda function.                                                  |
| Resource              | The name and version/alias of Lambda function. (Ex: DemoLambdaFunc:aliasProd) |
| EventSourceMappings   | AWS Event source mapping Id. (Set in case of Lambda invocation by AWS Poll-Based Services)|

## Custom Lambda Metrics

The wavefront nodejs lambda wrapper reports custom business metrics via API's provided by the [nodejs-metrics-wavefront client] (https://github.com/wavefrontHQ/nodejs-metrics-wavefront).  
Please refer to the below code sample which shows how you can send custom business metrics to wavefront from your lambda function.

### Code Sample

```javascript
const wavefrontLambda = require('wavefront-lambda')
const metrics = require('wavefrontmetrics');

exports.myHandler = wavefrontLambda.wrapper(function(event, context, callback) {
  // Get registry to report metrics.
  let registry = wavefrontLambda.getRegistry();

  // Register and report Counters with app tags.
  let counter = new metrics.Counter();
  registry.addTaggedMetric("sample.counter.count", counter, {"key1":"val1"});
  counter.inc();

  // Register and report Delta Counters with app tags.
  let deltaCounter = new metrics.Counter();
  let deltaCounterName = metrics.deltaCounterName("sample.deltaCounter.count");
  registry.addTaggedMetric(deltaCounterName, deltaCounter, {"key1":"val1"});
  deltaCounter.inc();

  callback(null, "some success message");
  // or
  // callback("some error type");
});

```

Note: Having the same metric name for any two types of metrics will result in only one time series at the server and thus cause collisions.
In general, all metric names should be different. In case you have metrics that you want to track as both a Counter and Delta Counter, consider adding a relevant suffix to one of the metrics to differentiate one metric name from another.
