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
          <table className="mdl-data-table mdl-js-data-table">
            <thead>
              <tr>
                <th className="mdl-data-table__cell--non-numeric">Article</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td className="mdl-data-table__cell--non-numeric">Acrylic (Transparent)</td>
                <td>25</td>
              </tr>
              <tr>
                <td className="mdl-data-table__cell--non-numeric">Plywood (Birch)</td>
                <td>50</td>
              </tr>
              <tr>
                <td className="mdl-data-table__cell--non-numeric">Laminate (Gold on Blue)</td>
                <td>10</td>
              </tr>
              <tr>
                <td className="mdl-data-table__cell--non-numeric">more...</td>
                <td></td>
              </tr>
            </tbody>
          </table>
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
