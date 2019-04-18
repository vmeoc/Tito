const wavefrontReporter = require('./reporter');

const wrapper = (lambdaHandlerFunction) => function (event, context, callback){
    // Register standard lambda metrics with the registry.
    wavefrontReporter.registerStandardLambdaMetrics();
    // Keep track if wrappedCallBack is called, otherwise
    // register beforeExit event to report metrics to wavefront.
    let isWrapperCallbackExecuted = false;
    const wrappercallback = (error, successmesssage) =>{
      // Increment error counter as required.
      if(error !== undefined && error !==null){
          wavefrontReporter.incrementErrors();
      }
      wavefrontReporter.updateDuration(process.hrtime(startTime)[1] / 1000000)
      isWrapperCallbackExecuted = true;
      // Report metrics.
      wavefrontReporter.reportMetrics(context);
      // Return control to AWS Lambda.
      callback(error, successmesssage);
    }

    // Increment invocation counter.
    wavefrontReporter.incrementInvocations();
    const startTime = process.hrtime();
    try {
      lambdaHandlerFunction(event, context, wrappercallback)
      // Handle the case when original lambda handler function completes successfully but doesn't call the Callback().
      if(context.callbackWaitsForEmptyEventLoop){
        process.on('beforeExit', function() {
          if(!isWrapperCallbackExecuted){
            wavefrontReporter.updateDuration(process.hrtime(startTime)[1] / 1000000);
            wavefrontReporter.reportMetrics(context);
          }
        });
      }
    }catch(err){
      // Increment error counters.
      wavefrontReporter.incrementErrors();
      // Update duration.
      wavefrontReporter.updateDuration(process.hrtime(startTime)[1] / 1000000)
      wavefrontReporter.reportMetrics(context);
      throw err;
    }
}

const getRegistry = () => {
  return wavefrontReporter.getRegistry();
}

module.exports = {wrapper, getRegistry};
