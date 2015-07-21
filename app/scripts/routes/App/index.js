import { requireAuth } from '../../utils/Auth';

module.exports = {
  path: 'app',
  onEnter: requireAuth,

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/App'));
    });
  },

  childRoutes: [
    require('./routes/Bills'),
    require('./routes/Dashboard'),
    require('./routes/Logout'),
    require('./routes/Settings'),
    require('./routes/Shopping')
  ]
};
