import React from 'react';
import { Navigation } from 'react-router';
import { Footer } from '_lib/components';

export default React.createClass({

  mixins: [Navigation],

  contextTypes: {
    router: React.PropTypes.object
  },

  render() {
    return (
      <div>
        {this._getHomePageHero()}
        {this._getHomePurpose()}
        {this._getHomeFeatures()}
        <Footer />
      </div>
    );
  },

  _getHomePageHero() {
    const heroStyle = {
      backgroundImage: 'url(' + require('../images/home-header.jpg') + ')',
      backgroundPosition: 'center center',
      backgroundSize: 'cover',
      height: '100vh'
    };
    const sloganStyle = {
      textShadow: '0 0 10px #000',
      color: '#fff',
      fontSize: 60,
      paddingTop: 160
    };
    const subSloganStyle = {
      textShadow: '0 0 10px #000',
      color: '#fff',
      fontSize: 21,
      paddingTop: 24
    };
    const signInButtonStyle = {
      margin: 20
    };

    return (
      <div className="mdl-typography--text-center" style={heroStyle}>
        <div style={sloganStyle}>2buy.io</div>
        <div style={subSloganStyle}>welcome at 2buy.io... make your life just a tad easier</div>
        <div style={signInButtonStyle}>
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