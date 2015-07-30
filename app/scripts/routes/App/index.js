import { requireAuth } from '../../utils/auth';

module.exports = {
  path: 'app',
  onEnter: requireAuth,

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/app'));
    });
  },

  childRoutes: [
    require('./routes/bills'),
    require('./routes/dashboard'),
    require('./routes/logout'),
    require('./routes/settings'),
    require('./routes/shopping')
  ]
};
