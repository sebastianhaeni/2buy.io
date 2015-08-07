module.exports = {
  path: 'bills',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/bills'));
    });
  }
};
