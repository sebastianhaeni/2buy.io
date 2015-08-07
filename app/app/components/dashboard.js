import React from 'react';
import { DocumentTitle } from '_lib/components';
import DashboardWidget from './widgets/dashboard-widget';
import ShoppingWidget from './widgets/shopping-widget';
import BillsWidget from './widgets/bills-widget';

export default React.createClass({

  render() {
    return (
      <DocumentTitle title="Dashboard">
        <div className="mdl-grid">
          <DashboardWidget className="mdl-cell--8-col">
            <ShoppingWidget />
          </DashboardWidget>
          <DashboardWidget className="mdl-cell--8-col mdl-cell--4-col-desktop">
            <BillsWidget />
          </DashboardWidget>
        </div>
      </DocumentTitle>
    );
  }

});
