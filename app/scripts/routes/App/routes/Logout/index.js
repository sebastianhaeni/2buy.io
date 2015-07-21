module.exports = {
  path: 'logout',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/Logout'));
    });
  }
};
