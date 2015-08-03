import React from 'react';
import { Navigation } from 'react-router';
import Footer from '../../../components/footer';

export default React.createClass({

  mixins: [Navigation],

  contextTypes: {
    router: React.PropTypes.object
  },

  render() {
    return (
      <div className="mdl-layout__content">
        {this._getHomePageHero()}
        {this._getHomePurpose()}
        {this._getHomeFeatures()}
        <Footer />
      </div>
    );
  },

  _getHomePageHero() {
    return (
      <div className="buy-home-header mdl-typography--text-center">
        <div className="buy-slogan">2buy.io</div>
        <div className="buy-sub-slogan">welcome at 2buy.io... make your life just a tad easier</div>
        <div className="buy-sign-in-button">
          <button
            className="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
            onClick={this._onSignInClick}>
            Sign In
          </button>
        </div>
      </div>
    );
  },

  _getHomePurpose() {
    // TODO
  },

  _getHomeFeatures() {
    // TODO
  },

  _onSignInClick() {
    this.transitionTo('/signin');
  }
});
