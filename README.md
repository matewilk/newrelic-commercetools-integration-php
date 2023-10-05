# Symfony demo app for New Relic

This Demo is to show how PHP CommerceTools SDK can be used in a Symfony application in a Docker environment with NewRelic monitoring enabled.

## Requirements

- PHP at least 8.1
- Symfony 6 
- Docker
- New Relic license key
- CommerceTools client credentials (id and secret)

## Installation

1. Clone/Download the repository.
2. Navigate to the path `root` directory.
3. Register the client credentials in environment variables `.env` file
```
APP_CTP_CLIENT_ID= your CTP_CLIENT_ID
APP_CTP_CLIENT_SECRET= your CTP_CLIENT_SECRET
APP_CTP_PROJECT_KEY= your CTP_PROJECT_KEY
APP_CTP_REGION=your CTP_CLOUD_REGION
```
1. Along with New Relic license key in the same file `.env` file
```
NEWRELIC_KEY=your New Relic license key
NEWRELIC_APP_NAME=newrelic-commercetools-php-integration
```

See the `env.example` file for reference.

## Architecture
### Containers
The app consists of 3 containers:
- `nginx` - nginx web server
- `php` - php-fpm container with the Symfony app
- `test` - container with the test script

### Endpoints
The app has 6 endpoints:
- `/` - healthcheck endpoint
- `/products` - endpoint to get products from CommerceTools
- `/categories` - endpoint to get categories from CommerceTools
- `/inventroy` - endpoint to get inventory from CommerceTools
- `/orders` - endpoint to get orders from CommerceTools


The application's architecture simplified diagram is shown below:
<img width="886" alt="app_diagram" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/b6e4cfa1-ae09-448d-85d7-0fd919fe2ccd">

New Relic monitoring is enabled for the `php` container. The `nginx` container is not monitored. The `test` container is used to run the test script. 

New Relinc PHP Agent is installed in the `php` container. The agent is configured in the `newrelic.ini` file located in the `docker/php` directory.

New Relic hooks up to CommerceTools SDK via Guzzle HTTP client which is used internally by the SDK and monitored by the New Relic agent by default.

### Monitoring
New Relic will monitor the following:
- All application performance metrics
- PHP application errors
- PHP application transactions
- Calls to CommerceTools API (external services) via the PHP SDK (Guzzle HTTP client)
- and more

## Test script (optional for local testing)

Uncomment the following lines in the `docker-compose.yml` file to run the test script in a separate container
```yaml
        # test:
        #   build:
        #     context: .
        #     dockerfile: docker/test/Dockerfile
        #   command: ["./test_script.sh"]
        #   depends_on:
        #     nginx:
        #       condition: service_healthy
```
This will run the `test_script.sh` script in the `test` container. The script will make a request to the various endpoint in order to visualise the New Relic monitoring.

## Using the Symfony Demo app in a Docker Environment

### Configuring the Demo App

1. Open the Terminal
2. Run `composer dump-env prod`
3. Run `composer install` or `composer update`

### Preparing the Docker environment

1. Always in the Root of the project 
2. For apple silicon hosted builds uncomment `platform: linux/amd64` in the `docker-compose.yml` file
3. Run `docker compose up`
4. Wait until the environment is running

### Navigate the application (or use the test script mentioned above)

1. Navigate to [http://localhost:8080/products](http://localhost:8080/products), [http://localhost:8080/categories](http://localhost:8080/categories), [http://localhost:8080/inventory](http://localhost:8080/inventory) or [http://localhost:8080/orders](http://localhost:8080/orders)
2. The result would be an array objects containing results from CommerceTools API.
3. If it's not please make sure that in Merchant Center in the project key selected (see the environment variable for the client credentials in the point 3 of the Installation section), there would be some data for products and categories.
4. Go in the New Relic UI to see the monitoring of the API calls.


### Screen shots from New Relic UI
<img width="1882" alt="Screenshot 2023-10-05 at 15 06 56" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/f01eff22-aee2-4c69-b232-940b303f1e7d">
<img width="1913" alt="Screenshot 2023-10-05 at 15 08 01" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/7e2a1f1f-b5d1-4353-82ce-e72e685ebe9a">
<img width="1879" alt="Screenshot 2023-10-05 at 15 08 44" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/580e1dd2-4534-4625-a969-40297bd50aa8">
<img width="1876" alt="Screenshot 2023-10-05 at 15 09 07" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/61337915-dd7a-4989-a504-c5b83b47e6fe">
<img width="1878" alt="Screenshot 2023-10-05 at 15 09 37" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/cbffa445-5741-4993-9527-24299958a463">
<img width="1883" alt="Screenshot 2023-10-05 at 15 10 21" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/ee0d021b-1eab-4d92-9ba7-643b37c43a38">
<img width="1893" alt="Screenshot 2023-10-05 at 15 11 48" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/431db20e-151c-48c1-a11b-a97551f2c742">
<img width="1875" alt="Screenshot 2023-10-05 at 15 12 34" src="https://github.com/matewilk/newrelic-commercetools-php-integration/assets/6328360/5ad45841-132b-4d21-8295-3a46a3abc846">
