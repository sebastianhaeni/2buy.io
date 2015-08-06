import React from 'react';
import { Link } from 'react-router';

export default React.createClass({

  propTypes: {
    title: React.PropTypes.string
  },

  render() {
    return (
      <header className="mdl-layout__header is-casting-shadow">
        <div className="mdl-layout__header-row">
          <span className="mdl-layout-title document-title">{this.props.title}</span>
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
    );
  }

});
