import React from 'react';
import { Link, Navigation } from 'react-router';
import classNames from 'classnames';

export default React.createClass({
  mixins: [ Navigation ],

  title: '',

  propTypes: {
    isDrawerVisible: React.PropTypes.bool,
    toggleDrawer: React.PropTypes.func.isRequired
  },

  getInitialPorps() {
    return {
      isDrawerVisible: false
    };
  },

  render() {
    if(this.title && this.title !== document.title){
      this.props.isDrawerVisible = false;
    }
    this.title = document.title;
    const drawerClasses = classNames('mdl-layout__drawer', {'is-visible': this.props.isDrawerVisible});

    return (
      <div>
        <header className="mdl-layout__header is-casting-shadow">
          <div className="mdl-layout__drawer-button"
            onClick={this.props.toggleDrawer}>
            <i className="material-icons">menu</i>
          </div>
          <div className="mdl-layout__header-row">
            <span className="mdl-layout-title">{this.title}</span>
            <div className="mdl-layout-spacer"></div>
              <button id="nav-menu-lower-right"
                className="mdl-button mdl-js-button mdl-button--icon">
                <i className="material-icons">more_vert</i>
              </button>
              <ul className="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                  htmlFor="nav-menu-lower-right">
                <li className="mdl-menu__item"><Link to="/app/settings">Settings</Link></li>
                <li className="mdl-menu__item"><Link to="/app/logout">Sign out</Link></li>
              </ul>
          </div>
        </header>
        <div className={drawerClasses} ref="drawer">
          <span className="mdl-layout-title">2buy.io</span>
          <nav className="mdl-navigation">
            <Link className="mdl-navigation__link" activeClassName="is-active" to="/app">Dashboard</Link>
            <Link className="mdl-navigation__link" activeClassName="is-active" to="/app/shopping">Shopping List</Link>
            <Link className="mdl-navigation__link" activeClassName="is-active" to="/app/bills">Bills</Link>
          </nav>
        </div>
      </div>
    );
  }

});
