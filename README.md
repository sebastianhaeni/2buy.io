2buy.io
===================================

## Environment Dependencies
* Apache with PHP >= 5.5
* MySQL >= 5.6

## Install instructions

1. Create MySQL Database with <code>docs/install.sql</code>. Optionally execute <code>docs/test-data.sql</code> to create test data.
2. Make sure you have installed the following dependencies:
	* [nodejs](http://nodejs.org/)
	* [Composer](https://getcomposer.org/)
	* [Ruby](https://www.ruby-lang.org/en/installation/)
3. Execute <code>npm install</code> (may take a while)
4. Create <code>config.php</code> with <code>config.sample.php</code> in <code>api/</code> to match your environment

To test if you successfully installed the API component you can call <code>/api/v1</code>.

The default admin user has the email <code>admin@2buy.io</code> and the password <code>1234</code>.

## Building

* Execute <code>npm run build</code> to manually compile the frontend.
* Execute <code>npm start</code> to automatically compile the frontend as soon as files change.

## Description
2buy.io provides members of a community household with a convenient way to tell others what’s currently needed in terms of everyday-articles. Users can add articles to the shopping list so the next member who goes shopping can purchase the missing articles. All the members are notified when someone performs an action in the app.

When an article gets bought, the buyer can mark it as bought and gets credit for it. The statistics should tell who orders the most and who buys the most.

The app is intended to work very well on mobile devices. Desktop resolutions should be supported as well, but aren’t the primary use case.

## Branching & Deployment

The stable branch is 'prod'.
Changes are first to be tested on stage before being merged into 'prod' branch.
'master' and 'stage' are deployed automatically to the respective server ([dev.2buy.io](http://dev.2buy.io) resp. [stage.2buy.io](http://stage.2buy.io)). Updating bower, composer or the database will still require human action though.

Production deployment is done manually by the person in charge of releases.

### Current status

|Branch     |Status                                                                                           |
|-----------|-------------------------------------------------------------------------------------------------|
|Development|[![](https://shoppinglist.dploy.io/badge/13023223952324/14083.png)](http://shoppinglist.dploy.io)|
|Staging    |[![](https://shoppinglist.dploy.io/badge/13023223952324/14189.png)](http://shoppinglist.dploy.io)|
|Production |[![](https://shoppinglist.dploy.io/badge/13023223952324/14190.png)](http://shoppinglist.dploy.io)|
