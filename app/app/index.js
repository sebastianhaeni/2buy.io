import { auth } from '_lib/utils';

module.exports = {
  path: 'app',
  onEnter: auth.requireAuth,

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/app'));
    });
  },

  childRoutes: [
    require('./routes/bills'),
    require('./routes/logout'),
    require('./routes/settings'),
    require('./routes/shopping')
  ]
};
