module.exports = {
  path: 'shopping',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/Shopping'));
    });
  }
};
