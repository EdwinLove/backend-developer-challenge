# Simpleweb backend developer challenge

## Approach

My approach with this was small lightweight and fast. I didn't want to reinvent the wheel and I didn't have a lot of time.

After some messing around trying to spin up enough basic symfony components to make this work I thought it was too bloated so decided to use Slim4 and (after a little refactoring to remove a bit of overengineering I introduced with Model calsses and interfaces) produced it with a simple single file app with no objects at all.

Due to time constraints (it took a while to get mongo installed and running) there are aspects that are not up to production standard and there are no tests and not enough guards against bad or invalid data or error handling but as it is read only this is not as important.

## Setup

* A mongo database must be set up and populated with the data from the json file.
* composer install must be run to set up all of the dependencies.
* The config.json.dist file needs to be copied to config.json and have the configuration values set to talk to the mongo database and also an array of allowed api keys to enable access.