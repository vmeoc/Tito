const metrics = require('wavefrontmetrics');
const config = require('./config');

let registry;
let standardMetrics;

const registerStandardLambdaMetrics = () => {
  // Initiate Registry
  registry = new metrics.Registry();
  // Return if reportStandardLambdaMetrics is disabled.
  if(!config.isReportStandardMetrics){
    return;
  }

  let standardMetricsKeys = Object.keys(config.standardLambdaMetrics).map(key => config.standardLambdaMetrics[key]);

  // Register Standard Lambda Metrics as Counters.
  standardMetrics = standardMetricsKeys.reduce((metricObj, name) => {
      metricObj[name] = new metrics.Counter();
      if(name.includes('value')) {
        registry.addTaggedMetric(name, metricObj[name]);
      } else{
        let deltaName = metrics.deltaCounterName(name);
        registry.addTaggedMetric(deltaName, metricObj[name]);
      }
      return metricObj;
  }, {});

  if(config.isColdStart){
    //Update cold start counter.
    incrementColdStarts()
    config.isColdStart = false;
  }
}

// Function to increment or update the given metric with the given value.
// This method should only be used to handle updating values of standardLambdaMetrics
// defined in ./config.js
const incrementMetric = function (metricName, value) {
  if (!config.isReportStandardMetrics) {
    return;
  }
  standardMetrics[metricName].inc(value);
}

const incrementInvocations = function(){
  incrementMetric(config.standardLambdaMetrics.invocationsCounter, 1)
}

const incrementErrors = function(){
  incrementMetric(config.standardLambdaMetrics.errorsCounter, 1)
}

const incrementColdStarts = function(){
  incrementMetric(config.standardLambdaMetrics.coldStartsCounter, 1)
}

const updateDuration = function(value){
  incrementMetric(config.standardLambdaMetrics.durationValue, value)
}

const getRegistry = () => {
  return registry;
}

const reportMetrics = (context) =>  {
  if(context != null){
    let invokedFunctionArn = context.invokedFunctionArn;
    let splitArn = invokedFunctionArn.split(":");
    let [prefixArn, prefixAws, prefixLambda, region, accountId, functionOrEventSource, functionNameOrEventSourceId, versionOrAlias] = splitArn;

    // Expected formats for Lambda ARN are:
    // https://docs.aws.amazon.com/general/latest/gr/aws-arns-and-namespaces.html#arn-syntax-lambda
    let tags = {
      "LambdaArn":       invokedFunctionArn,
      "source":          context.functionName,
      "FunctionName":    context.functionName,
      "ExecutedVersion": context.functionVersion,
      "Region":          region,
      "accountId":       accountId
    }
    if (functionOrEventSource === "function") {
      tags["Resource"] = functionNameOrEventSourceId
      if (splitArn.length === 8) {
        tags["Resource"] += ":" + versionOrAlias
      }
    } else if (functionOrEventSource === "event-source-mappings") {
      tags["EventSourceMappings"] = functionNameOrEventSourceId
    }

    try{
      let directReporter = new metrics.WavefrontDirectReporter(registry, "", config.server, config.authToken, tags);
      directReporter.report()
    }catch(exception){
      console.warn('Failed to report metrics to wavefront.');
    }
  }else{
    console.warn('Failed to report metrics to wavefront as retrieving lambdaContext from AWS failed.');
  }
}

module.exports = {
  registerStandardLambdaMetrics,
  incrementInvocations,
  incrementErrors,
  incrementColdStarts,
  updateDuration,
  reportMetrics,
  getRegistry
};
