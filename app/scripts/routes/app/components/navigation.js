import React from 'react';
import { Navigation } from 'react-router';

export default React.createClass({
  mixins: [ Navigation ],

  propTypes: {
    title: React.PropTypes.string
  },

  render() {
    return (
      <header className="mdl-layout__header is-casting-shadow">
        <div className="mdl-layout__header-row">
          <span className="mdl-layout-title document-title">{this.props.title}</span>
          <div className="mdl-layout-spacer" />

          Community
          <button id="nav-community" className="mdl-button mdl-js-button mdl-button--icon">
            <i className="material-icons">keyboard_arrow_down</i>
          </button>
          <ul className="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
              htmlFor="nav-community">
            <li className="mdl-menu__item">Community 1</li>
            <li className="mdl-menu__item">Community 2</li>
            <li className="mdl-menu__item">Create new community</li>
          </ul>

          <button id="nav-user"
            className="mdl-button mdl-js-button mdl-button--icon">
            <i className="material-icons">more_vert</i>
          </button>
          <ul className="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
              htmlFor="nav-user">
            <li className="mdl-menu__item" onClick={this._goToSettings}>Settings</li>
            <li className="mdl-menu__item" onClick={this._goToLogout}>Sign out</li>
          </ul>
        </div>
      </header>
    );
  },

  _goToSettings() {
    this.transitionTo('/app/settings');
  },

  _goToLogout() {
    this.transitionTo('/app/logout');
  }

});
