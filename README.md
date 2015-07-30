2buy.io
===================================

## Environment Dependencies
* [nodejs](https://nodejs.org/) `^0.12`
* [PHP](https://php.net) `^5.5`
* [Composer](https://getcomposer.org/)

## Install instructions

1. Run `npm install`
2. Configure the created files `config/api.yml` and `config/propel.yml` to your needs.

## Running

Run `npm start` to execute the application. Run `npm start --open` to make it automatically open in your browser.

The default admin user has the email `admin@2buy.io` and the password <code>1234</code>.

## Building

* Execute <code>npm run build</code> to manually compile the frontend.

## Branching & Deployment

The stable branch is 'prod'.
Changes are first to be tested on stage before being merged into 'prod' branch.
'master' and 'stage' are deployed automatically to the respective server ([dev.2buy.io](http://dev.2buy.io) resp. [stage.2buy.io](http://stage.2buy.io)). 

Production deployment is done manually by the person in charge of releases.

### Current status

|Branch     |Status                                                                                           |
|-----------|-------------------------------------------------------------------------------------------------|
|Development|[![](https://shoppinglist.dploy.io/badge/13023223952324/14083.png)](http://shoppinglist.dploy.io)|
|Staging    |[![](https://shoppinglist.dploy.io/badge/13023223952324/14189.png)](http://shoppinglist.dploy.io)|
|Production |[![](https://shoppinglist.dploy.io/badge/13023223952324/14190.png)](http://shoppinglist.dploy.io)|
