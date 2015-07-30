import React from 'react';
import { Navigation } from 'react-router';
import Login from './Login';

export default React.createClass({

  mixins: [Navigation],

  contextTypes: {
    router: React.PropTypes.object
  },

  render() {
    return (
      <div className="android-content mdl-layout__content">
        <a name="top"></a>
        {this._getHomePageHero()}
        {this._getHomePurpose()}
        {this._getHomeFeatures()}
        {this._getSignInDialog()}
      </div>
    );
  },

  _getHomePageHero() {
    return (
      <div className="android-be-together-section mdl-typography--text-center">
        <div className="android-font android-slogan">be together. not the same.</div>
        <div className="android-font android-sub-slogan">welcome to android... be yourself. do your thing. see what's going on.</div>
      </div>
    );

    /*<div>
      <h1>2buy.io</h1>
      <h2>
        This will make your life easier by giving you a way to interact
        and manage your household digitally.
      </h2>
      <button className="mdl-button mdl-js-button mdl-button--raised
        mdl-js-ripple-effect"
        onClick={this._onSignInClick}>
        Sign In
      </button>
    </div>*/
  },

  _getHomePurpose() {
    return (
      <div className="android-screen-section mdl-typography--text-center">
        <a name="purpose"></a>
        <div className="mdl-typography--display-1-color-contrast">Powering screens of all sizes</div>
        <div className="android-screens">
          <div className="android-wear android-screen">
            <a className="android-link mdl-typography--font-regular mdl-typography--text-uppercase" href="">Android Wear</a>
          </div>
          <div className="android-phone android-screen">
            <a className="android-link mdl-typography--font-regular mdl-typography--text-uppercase" href="">Phones</a>
          </div>
          <div className="android-tablet android-screen">
            <a className="android-link mdl-typography--font-regular mdl-typography--text-uppercase" href="">Tablets</a>
          </div>
          <div className="android-tv android-screen">
            <a className="android-link mdl-typography--font-regular mdl-typography--text-uppercase" href="">Android TV</a>
          </div>
          <div className="android-auto android-screen">
            <a className="android-link mdl-typography--font-regular mdl-typography--text-uppercase mdl-typography--text-left" href="">Coming Soon: Android Auto</a>
          </div>
        </div>
      </div>
    );
  },

  _getHomeFeatures() {
    return (
      <p>TODO: Features</p>
    );
  },

  _getSignInDialog() {
    return (
      <Login />
    );
  },

  _onSignInClick() {
    this.refs.signInDialog.show();
  }
});
