import React from 'react';
import { history } from 'react-router/lib/BrowserHistory';
import { Router } from 'react-router';
import injectTapEventPlugin from 'react-tap-event-plugin';
import { Master } from 'lib/components';

// import ES6 polyfills
import 'babel/polyfill';
// import our main style, component style is defined inside components
import './styles/main.scss';
// extension on material.js is required because there's also a material.css file
import 'script!material-design-lite/material.js';

// Needed for onTouchTap
// Can go away when react 1.0 releases
// Check this repo: https://github.com/zilverline/react-tap-event-plugin
injectTapEventPlugin();

const rootRoute = {
  path: '/',
  component: Master,
  childRoutes: [
    require('./app'),
    require('./help'),
    require('./privacy'),
    require('./signin'),
    require('./home')
  ]
};

React.render((
  <Router
    routes={rootRoute}
    history={history}
  />
), document.body);
