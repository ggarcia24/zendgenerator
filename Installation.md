# Introduction #

The code right now is really _rough_ in some aspects (because of the early stages that the project is):

  * First you will need to apply [a patch](http://framework.zend.com/issues/browse/ZF-9018) to the Zend Framework in order to avoid a bad bug :-)
  * You have to export it or use svn:external property to use in case that you want to use it on you project
  * Please put this script inside a script directory within a newly created project
  * Create your desired database structure (in the future we may be able to use other types of origins)
  * From the top level project directory run "php script/generator.php". This will automagically generate all the classes and files included on the "quickstart" project in the zend framework manual

I'm working on making the code able to associate, and to be more automatic, in some tasks  i.e the code now does not generates the relationship between the classes (Model, DataMapper, etc.)

Hope that you enjoy it as much as I, while using it and doing it.

Greetings!
Gonzalo