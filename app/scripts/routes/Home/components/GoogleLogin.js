import React from 'react';

export default React.createClass({

  componentDidMount() {
    gapi.signin2.render('my-signin2', {
      'width': 200,
      'longtitle': true,
      'onsuccess': this._handleSuccess,
      'onfailure': this._handleFailure
    });
  },

  render() {
    return (
      <div id="my-signin2"></div>
    );
  },

  _handleSuccess(googleUser) {
    // Useful data for your client-side scripts:
    let profile = googleUser.getBasicProfile();

     // Don't send this directly to your server!
    console.log('ID: ' + profile.getId());
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail());

    // The ID token you need to pass to your backend:
    let idToken = googleUser.getAuthResponse().id_token;
    console.log('ID Token: ' + idToken);
  },

  _handleFailure(error) {
    console.err(error);
  }

});
