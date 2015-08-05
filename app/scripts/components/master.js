import React from 'react';
import Home from '../routes/home/components/home';

export default React.createClass({

  propTypes: {
    children: React.PropTypes.object
  },

  render() {
    return (
      <div>
        {this.props.children || <Home />}
      </div>
    );
  }
});
