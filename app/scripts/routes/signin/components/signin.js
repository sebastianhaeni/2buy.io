import React from 'react';
import { Navigation } from 'react-router';
import DocumentTitle from 'react-document-title';
import ThirdPartyLogin from './third-party-login';
import auth from '../../../utils/auth';

export default React.createClass({

  mixins: [ Navigation ],

  render() {
    return (
      <DocumentTitle title="Sign In">
        <div className="mdl-layout__content">
          <h2>Sign in</h2>
          <ThirdPartyLogin handleSuccess={this._handleSuccess} handleFailure={this._handleFailure} />
        </div>
      </DocumentTitle>
    );
  },

  _handleSuccess(authType, token) {
    auth.login3rdParty(authType, token).then(() => {
      this.transitionTo('/app');
    }, this._handleFailure);
  },

  _handleFailure(error) {
    console.error(error);
  }

});
