module.exports = {
  path: 'privacy',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/privacy'));
    });
  }
};
