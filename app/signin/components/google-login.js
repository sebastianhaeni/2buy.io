import React from 'react';
import { AuthConstants } from '_lib/constants';

export default React.createClass({

  propTypes: {
    handleSuccess: React.PropTypes.func.isRequired,
    handleFailure: React.PropTypes.func.isRequired
  },

  componentDidMount() {
    gapi.signin2.render('my-signin2', {
      'width': 200,
      'longtitle': true,
      'onsuccess': this._handleSuccess,
      'onfailure': this.props.handleFailure
    });
  },

  render() {
    return (
      <div id="my-signin2"></div>
    );
  },

  _handleSuccess(googleUser) {
    // Useful data for your client-side scripts:
    // let profile = googleUser.getBasicProfile();

    // Don't send this directly to your server!
    //console.log('ID: ' + profile.getId());
    //console.log('Name: ' + profile.getName());
    //console.log('Image URL: ' + profile.getImageUrl());
    //console.log('Email: ' + profile.getEmail());

    // The ID token you need to pass to your backend:
    let idToken = googleUser.getAuthResponse().id_token;
    this.props.handleSuccess(AuthConstants.GOOGLE, idToken);
  }

});
