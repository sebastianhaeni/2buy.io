import React from 'react';
import { Navigation } from 'react-router';

export default React.createClass({
  mixins: [ Navigation ],

  propTypes: {
    title: React.PropTypes.string
  },

  _handleRefresh() {
    console.warn('NOT YET IMPLEMENTED: refresh');
  },

  _handleSettings() {
    this.context.router.transitionTo('settings');
  },

  _handleLogout() {
    this.context.router.transitionTo('logout');
  },

  render() {
    return (
      <div>
        TODO
      </div>
    );
  }

});
