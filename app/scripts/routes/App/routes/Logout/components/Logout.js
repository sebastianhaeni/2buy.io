import React from 'react';
import auth from '../../../../../utils/Auth';

export default React.createClass({

  componentDidMount() {
    auth.logout();
  },

  render() {
    return <p>You are now logged out.</p>;
  }

});
