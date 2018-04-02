# Final project Birkbeck University year 2017/2018

LOCAL INSTALLATION
------------------

1. Clone or download the project from [this link](https://github.com/amusso01/Well-Street-App.git)
2. Create a database for the project then import tables and data from the sql file __wellstreetapp.sql__
3. Open your terminal/command prompt, navigate to project folder and run `composer install` 
4. Open the config file  `your_web_root_name/config/config.php` with your text editor:
    1. Set the `$FILE_ROOT` variable to the path of the index.php file root inside `/public_html` (this will be the URL root in deployment) *Ex: `/Well-Street-App/public_html`* 
    2. Set the database credentials 
5. The application is ready to run. Open your web browser and navigate to the public.html folder. *Ex: `localhost/Well-Street-App/public_html/`*

#### Constraints

* Make sure you have Composer install on your machine. Visit [this site](https://getcomposer.org/) to install Composer
* You must have an AMP (Apache-MySql-PHP) environment install on your machine. My suggestion [MAMP ](https://www.mamp.info/en/) for mac and [WAMP](http://www.wampserver.com/en/) for windows or build your own.

FOR FURTHER DEVELOPMENT 
-----------------------

6. In the terminal/command prompt navigate inside the public_html folder and run the comand `npm install`
7. Run gulp command to compile and minify */src/style.scss* into */media/css/style.min.css* 
8. The gulp command also automate the live reload of the browser

#### Constraints

* Make sure you can run npm command in your system. Visit [Node.js](https://nodejs.org/en/) for more information
* Install LiveReload plugin for your browser to automate the gulp reload operation. [Chrome plugin](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei). __not a constraint, system can be developed without this feature__
