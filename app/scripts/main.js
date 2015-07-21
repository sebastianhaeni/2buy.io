import React from 'react';
import { history } from 'react-router/lib/BrowserHistory';
import { Router } from 'react-router';
import injectTapEventPlugin from 'react-tap-event-plugin';
import Master from './components/Master';

import 'normalize.css';
import '../styles/main.scss';

// Needed for onTouchTap
// Can go away when react 1.0 releases
// Check this repo: https://github.com/zilverline/react-tap-event-plugin
injectTapEventPlugin();

const rootRoute = {
  path: '/',
  component: Master,
  childRoutes: [
    require('./routes/Register'),
    require('./routes/App'),
    require('./routes/Home')
  ]
};

React.render((
  <Router
    routes={rootRoute}
    history={history}
  />
), document.getElementById('root'));
