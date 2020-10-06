# Simpleweb backend developer challenge

Using the language and framework of your choice, please create a read-only, RESTful JSON API that allows a consumer to access a list of car parks located in the UK. The car park data can be found within the [car_parks.json](https://github.com/simpleweb/backend-developer-challenge/blob/main/car_parks.json) file within this respository.

## Requirements

The API must fulfil the following requirements, with tests around the code you write as you deem appropriate.

- The API must be protected using an API key.
- The API must support pagination with a limit of 20 results per page.
- The consumer must be able to filter car parks by features, including "park and ride" and "electric car charge point".

## Bonus credits

Extra bonus credit features you might consider, but are not required.

- Allow the consumer to locate the car parks within a specified radius from a given latitude and longitude.
- Throttle API requests on a per API key basis. After the first 100 requests per day, throttle to 1 request per 10 seconds.

Please push the project to a repository on GitHub for us to evaluate. Please include any documentation such as set up instructions and summerise the approach you have taken within the project README file.

## Improvements

We are always looking to improve our testing. If you have any suggestions or feedback on this test, please make notes and include it with your submission.
