import React from 'react';
import Home from '../routes/Home/components/Home';

export default React.createClass({

  propTypes: {
    children: React.PropTypes.object
  },

  render() {
    return (
      <div className="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        {this.props.children || <Home />}
      </div>
    );
  }
});
