import React from 'react';
import { Link, Navigation } from 'react-router';

export default React.createClass({
  mixins: [ Navigation ],

  render() {
    return (
      <div className="mdl-layout__drawer">
        <span className="mdl-layout-title">2buy.io</span>
        <nav className="mdl-navigation">
          <Link className="mdl-navigation__link" activeClassName="is-active" to="/app">Dashboard</Link>
          <Link className="mdl-navigation__link" activeClassName="is-active" to="/app/shopping">Shopping List</Link>
          <Link className="mdl-navigation__link" activeClassName="is-active" to="/app/bills">Bills</Link>
        </nav>
      </div>
    );
  }

});
