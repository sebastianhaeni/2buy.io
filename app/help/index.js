module.exports = {
  path: 'help',

  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/help'));
    });
  }
};
