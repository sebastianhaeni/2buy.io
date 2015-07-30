module.exports = {
  path: 'settings',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/Settings'));
    });
  }
};
