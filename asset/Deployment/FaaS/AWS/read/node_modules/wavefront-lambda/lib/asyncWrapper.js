const wavefrontReporter = require('./reporter');
const generateWrapper = require('./wrapper');
const AsyncFunction = (async () => {}).constructor;

const handleSuccess =(context, startTime)=> {
  // Update Duration
  wavefrontReporter.updateDuration(process.hrtime(startTime)[1] / 1000000)
  wavefrontReporter.reportMetrics(context);
}

const handleError = (context, startTime) => {
  // Increment error counter.
  wavefrontReporter.incrementErrors();
  // Update Duration
  wavefrontReporter.updateDuration(process.hrtime(startTime)[1] / 1000000)
  wavefrontReporter.reportMetrics(context);
}

const generateAsyncWrapper = ((lambdaHandlerFunction) => async function (event, context) {
        // Register standard lambda metrics with the registry.
        wavefrontReporter.registerStandardLambdaMetrics();
        // Increment invocation counter.
        wavefrontReporter.incrementInvocations();
        // Record start time to calculate duration of execution of original lambda function.
        let startTime = process.hrtime();
        return lambdaHandlerFunction(event, context)
        .then((data) => {
          handleSuccess(context, startTime);
          return data;
        })
        .catch((error) => {
          handleError(context, startTime);
          throw error;
        });
});

const wrapper = lambdaHandlerFunction => {
  if(lambdaHandlerFunction instanceof AsyncFunction === true){
    return generateAsyncWrapper(lambdaHandlerFunction);
  } else {
    return generateWrapper.wrapper(lambdaHandlerFunction);
  }
};

const getRegistry = function(){
  return wavefrontReporter.getRegistry();
}

module.exports = {wrapper, getRegistry};
