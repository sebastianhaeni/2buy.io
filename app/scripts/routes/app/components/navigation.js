import React from 'react';
import { Navigation } from 'react-router';
import classNames from 'classnames';

export default React.createClass({
  mixins: [ Navigation ],

  propTypes: {
    isDrawerVisible: React.PropTypes.boolean,
    toggleDrawer: React.PropTypes.func.isRequired
  },

  getInitialPorps() {
    return {
      isDrawerVisible: false
    };
  },

  render() {
    const title = document.title;
    const drawerClasses = classNames('mdl-layout__drawer', {'is-visible': this.props.isDrawerVisible});

    return (
      <div>
        <header className="mdl-layout__header is-casting-shadow">
          <div className="mdl-layout__drawer-button mdl-js-ripple"
            onClick={this.props.toggleDrawer}>
            <i className="material-icons">menu</i>
          </div>
          <div className="mdl-layout__header-row">
            <span className="mdl-layout-title">{title}</span>
            <div className="mdl-layout-spacer"></div>
            <nav className="mdl-navigation mdl-layout--large-screen-only">
              <a className="mdl-navigation__link" href="">Link</a>
              <a className="mdl-navigation__link" href="">Link</a>
              <a className="mdl-navigation__link" href="">Link</a>
              <a className="mdl-navigation__link" href="">Link</a>
            </nav>
          </div>
        </header>
        <div className={drawerClasses} ref="drawer">
          <span className="mdl-layout-title">2buy.io</span>
          <nav className="mdl-navigation">
            <a className="mdl-navigation__link" href="">Link</a>
            <a className="mdl-navigation__link" href="">Link</a>
            <a className="mdl-navigation__link" href="">Link</a>
            <a className="mdl-navigation__link" href="">Link</a>
          </nav>
        </div>
      </div>
    );
  },

  _handleSettings() {
    this.transitionTo('settings');
  },

  _handleLogout() {
    this.transitionTo('logout');
  }

});
