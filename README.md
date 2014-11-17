2buy.io
===================================

## Environment Dependencies
* Apache with PHP >= 5.5
* MySQL >= 5.6

## Install instructions

1. Create MySQL Database with <code>install.sql</code>.
2. Install [nodejs](http://nodejs.org/)
3. Install [Composer](https://getcomposer.org/)
4. Install [Ruby](https://www.ruby-lang.org/en/installation/)
5. Execute the following script in the project dir:

    ```
    gem install sass
    gem install compass
    composer install
    npm install
    bower install
    ```
6. Create <code>config.php</code> with <code>config.sample.php</code> to match your environment

To test if you successfully installed the API component you can call <code>/api/v1</code>.

The default admin user has the email <code>admin@shoppinglist.ch</code> and the password <code>1234</code>.

Compiling <code>.js</code> and <code>.scss</code> happens automatically when the Grunt file watcher is active. Start it like so: <code>grunt watch</code>.

## Description
The Shopping List provides members of a community household with a convenient way to tell others what’s currently needed in terms of everyday-articles. Users can add articles to the shopping list so the next member who goes shopping can purchase the missing articles. All the members are notified when someone performs an action in the app.

When an article gets bought, the buyer can mark it as bought and gets credit for it. The statistics should tell who orders the most and who buys the most.

The app is intended to work very well on mobile devices. Desktop resolutions should be supported as well, but aren’t the primary use case.

[View the Project plan](https://docs.google.com/spreadsheets/d/13WSqNUOvKZwPOybQbJwPmpcRZdPULlK52T3Jfx6dhZ4/pubhtml)

## i18n
To translate text into different locales, we use gettext. To edit the translations you can use [PoEdit](http://poedit.net/).

To extract new strings from the source, you can generate the twig templates into php files with <code>php web/locale/update-i18n.php</code> and then update the .po file within PoEdit.

## Branching & Deployment

The stable branch is 'prod'.
Changes are first to be tested on stage before being merged into 'prod' branch.
'master' and 'stage' are deployed automatically to the respective server ([dev.2buy.io](http://dev.2buy.io) resp. [stage.2buy.io](http://stage.2buy.io)). Updating bower, composer or the database will still require human action though.

Production deployment is done manually by the person in charge of releases.

## Features
<ul>
  <li>[x] User authentication</li>
  <li>[x] Multiple communities</li>
  <li>[ ] Shopping List
    <ul>
      <li>[x] Add new articles
        <ul>
          <li>[x] Autocomplete text box</li>
          <li>[x] Amount</li>
          <li>[ ] Send notification to others</li>
          <li>[x] Add to history</li>
        </ul>
      </li>
      <li>[x] Mark article as bought (swipe left)
        <ul>
          <li>[ ] Send notification to others</li>
          <li>[x] Add to history</li>
        </ul>
      </li>
      <li>[x] Delete article (swipe right)
        <ul>
          <li>[ ] Send notification to others</li>
          <li>[x] Add to history</li>
        </ul>
      </li>
      <li>[x] History
        <ul>
          <li>[x] Show all passed actions</li>
        </ul>
      </li>
      <li>[x] Statistics
        <ul>
          <li>[x] Show users weighted by orders (cake diagram)</li>
          <li>[x] Show users weighted by purchases (cake diagram)</li>
        </ul>
      </li>
      <li>[ ] Article suggestions
        <ul>
          <li>[ ] Admin can define list of suggested articles</li>
          <li>[ ] Admin can create articles</li>
          <li>[ ] Admin can delete articles</li>
          <li>[ ] Admin can edit articles</li>
        </ul>
      </li>
    </ul>
  </li>
  <li>[ ] Bills
    <ul>
      <li>[ ] Upload bill</li>
      <li>[ ] Show bills</li>
      <li>[ ] Mark bill as paid</li>
      <li>[ ] Delete bill</li>
      <li>[ ] Bill history</li>
      <li>[ ] Bill statistics</li>
    </ul>
  </li>
  <li>[ ] Notifications
    <ul>
      <li>[ ] E-Mail</li>
    </ul>
  </li>
  <li>[ ] Offline capability (no conflict merging)</li>
  <li>[x] Multi Language</li>
</ul>
