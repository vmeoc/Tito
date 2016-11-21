Tito
Time traffic optimizer

Abtract:
This is  a sample multi tiers application to showcase the various ways of deploying and running across multiple technologies such as VMware vRealize Automation, virtual machines, containers, Kubernetes, public cloud, PaaS, etc... etc... etc...  (Gosh, there's so many....)
It's a super simple application to make it easy to understand the code (and therefore modify it), used with widely supported languages/framework (PHP, Bootstrap) on a typical 3 Tiers architecture.
What does the app do when running? I was looking of something that would interest as many people as possible and I thought most people are commuting pretty much everyday so I wrote a "Time Traffic Overview" app a.k.a Tito.
Simply enter your home address, work address and regular time departure and it will give you some stats. Beware, some of them are scary. Have you ever calculate the amount of time in your life you will spend commuting? Here we go...

So, the app is made of a simple index.php webpage providing the initial content, once the user has clicked on submit, form_result.php is triggered and will turn the inputs in the right format, ask Google on the duration, create some stats, display them, display a map, write the inputs in a DB. That's it!

The folder deployment contain the various Infra as a code files to deploy the app.
The other folder are just css files, picture files and other stuff.

For more information, visit www.vmcloud.fr.

![My image](http://img.over-blog-kiwi.com/1/53/11/35/20160926/ob_6f2ff9_container01-jpg-492x0-q85-crop-smart.jpg)