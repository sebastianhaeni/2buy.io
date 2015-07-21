module.exports = {
  path: 'register',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/Register'));
    });
  }
};
