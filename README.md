Shopping List
===================================

## Dependencies
1.  [nodejs](http://nodejs.org/)
2.  [Bower](http://bower.io/) (<code>npm install -g bower</code>)
3.  [Composer](https://getcomposer.org/) (<code>npm install -g composer</code>)
4.  [less.js](https://github.com/less/less.js) (<code>npm install -g less</code>)
5.  Apache with PHP >= 5.5
6.  MySQL >= 5.6

## Install instructions

1. Install dependencies listed above
2. Install bower packages: <code>bower install</code>
3. Install composer packages: <code>composer install</code>
4. Create MySQL Database with <code>create-tables.sql</code>.
5. Create <code>config.php</code> with <code>config.sample.php</code> to match your local environment

To test if you successfully installed the API component you can call <code>/api/v1</code>.

The sample user created has the username "Administrator" and the password "1234".

## Description
The Shopping List provides members of a community household with a convenient way to tell others what’s currently needed in terms of everyday-articles. Users can add articles to the shopping list so the next member who goes shopping can purchase the missing articles. All the members are notified when someone performs an action in the app.

When an article gets bought, the buyer can mark it as bought and gets credit for it. The statistics should tell who orders the most and who buys the most.

The app is intended to work very well on mobile devices. Desktop resolutions should be supported as well, but aren’t the primary use case.

[View the Project plan](https://docs.google.com/spreadsheets/d/13WSqNUOvKZwPOybQbJwPmpcRZdPULlK52T3Jfx6dhZ4/pubhtml)


## Features
<ul>
  <li>User authentication</li>
  <li>Add new articles
    <ul>
      <li>Autocomplete text box</li>
      <li>Amount</li>
      <li>Send notification to others</li>
      <li>Add to history</li>
    </ul>
  </li>
  <li>Mark article as bought (swipe left)
    <ul>
      <li>Send notification to others</li>
      <li>Add to history</li>
    </ul>
  </li>
  <li>Delete article (swipe right)
    <ul>
      <li>Send notification to others</li>
      <li>Add to history</li>
    </ul>
  </li>
  <li>History
    <ul>
      <li>Show all passed actions</li>
    </ul>
  </li>
  <li>Statistics
    <ul>
      <li>Show users weighted by orders (cake diagram)</li>
      <li>Show users weighted by purchases (cake diagram)</li>
    </ul>
  </li>
  <li>Article suggestions
    <ul>
      <li>Admin can define list of suggested articles</li>
    </ul>
  </li>
  <li>Notifications
    <ul>
      <li>E-Mail</li>
    </ul>
  </li>
</ul>
