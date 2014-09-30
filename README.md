Shopping List
===================================

## Dependencies
1.  [Bower](http://bower.io/)
2.  [Composer](https://getcomposer.org/)
3.  less compiler
4.  Apache with PHP >= 5.5
5.  MySQL >= 5.6

## Install instructions

1. Install dependencies listed above:
2. Install bower packages
       bower install
3. Install comoposer packages:
       composer install
4. Create MySQL Database with <code>create-tables.sql</code>.
5. Create <code>config.php</code> with <code>config.sample.php</code> to match your local environment


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
