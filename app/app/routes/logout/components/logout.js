import React from 'react';
import { Navigation } from 'react-router';
import { auth } from '_lib/utils';

export default React.createClass({

  mixins: [ Navigation ],

  componentDidMount() {
    auth.logout().then(() => {
      this.transitionTo('/');
    });
  },

  render() {
    return <p>You are now logged out.</p>;
  }

});
