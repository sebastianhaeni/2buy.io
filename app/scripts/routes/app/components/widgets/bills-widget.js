import React from 'react';
import { Link } from 'react-router';

export default React.createClass({

  render() {
    return (
      <div>
        <div className="mdl-card__title">
          <h2 className="mdl-card__title-text">Bills</h2>
        </div>
        <div className="mdl-card__supporting-text">
          <p>Currently there are 3 open bills submitted by members of your community.</p>
          <p>Your community spent a total of 312.40 CHF this year.</p>
        </div>
        <div className="mdl-card__actions mdl-card--border">
          <Link to="/app/bills" className="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
            Go to bills
          </Link>
        </div>
      </div>
    );
  }

});
