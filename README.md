## PHP Amadeus

[![Latest Stable Version](https://poser.pugx.org/sunspikes/php-amadeus/v/stable)](https://packagist.org/packages/sunspikes/php-amadeus)
[![License](https://poser.pugx.org/sunspikes/php-amadeus/license)](https://packagist.org/packages/sunspikes/php-amadeus)

This is a PHP implementation of the Amadeus Flight Search and Booking API.

See the [example.php](https://github.com/sunspikes/PHP-Amadeus/blob/master/example.php) for usage.

Sample WSDL & associated XSD files can be downloaded [here](https://www.dropbox.com/s/kybqutuxmjc2uz4/wsdl.zip)

Login to [Amadeus Extranet](https://extranets.us.amadeus.com) for Complete API documentation.

**Please note, this will currently only work with the WSDL file mentioned above, It wont work with the newer versions**

### FAQ

Q. Why did you create this package?

A. Back in 2011 I had implemented a flight booking web app in Joomla using the Amadeues API (SOAP v2), As Amadeus doesn't have any PHP SDK I had to create a custom Joomla component based on their SOAP API. Later I hacked together a working PHP class based on that and put it on GitHub hoping it may help someone who is starting an Amadeus flight booking project in PHP.

Q. Which Amadeus API version this package is using?

A. It's based on Amadeus SOAP v2 API

Q. Can i use this to implement a new Amadeus flight booking project?

A. No. AFAIK, For newer Amadeus projects you have to use their new API (SOAP v4) which is a bit more complex and uses WS-Security, WS-Addressing...etc.

Q. Do you have any plans to update this package to use the SOAP v4 API?

A. No. Currently neither I have access to the Amadeus extranet nor time to work on it. (Fork, May be?)

Q. How can this code help me with a new implementation?

A. As i mentioned earlier this is extracted from a really old project of mine, it messy. This could give you an overview the booking process and to make some test calls with the old API.

Q. Do you provide any paid support?

A. Sorry, I am not available for any paid support at this time.

### Author

Krishnaprasad MG [@sunspikes]

### Contributing

Please feel free to send pull requests.

### License

This is an open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
