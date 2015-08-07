import React from 'react';
import { Link } from 'react-router';

export default React.createClass({

  render() {
    return (
      <div>
        <div className="mdl-card__title">
          <h2 className="mdl-card__title-text">Shopping List</h2>
        </div>
        <div className="mdl-card__supporting-text">
          <p>There are 5 articles left to buy. Since last week 12 articles were bought.</p>
          <p>The most active buyer is Sebastian. The most active orderer is David.</p>
          <p>&lt;insert fancy statistics here&gt;</p>
        </div>
        <div className="mdl-card__actions mdl-card--border">
          <Link to="/app/shopping" className="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
            Go to shopping list
          </Link>
        </div>
      </div>
    );
  }

});
