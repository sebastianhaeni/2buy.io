module.exports = {
  path: 'signin',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/signin'));
    });
  }
};
