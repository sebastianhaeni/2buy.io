import React from 'react';
import classNames from 'classnames';

export default React.createClass({

  propTypes: {
    className: React.PropTypes.string,
    children: React.PropTypes.node
  },

  render() {
    const className = classNames('mdl-cell', 'mdl-card', 'mdl-shadow--2dp', this.props.className);

    return (
      <div className={className}>
        {this.props.children}
      </div>
    );
  }

});
