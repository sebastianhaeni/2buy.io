module.exports = {
  getComponents (cb) {
    require.ensure([], (require) => {
      cb(null, require('./components/home'));
    });
  }
};
