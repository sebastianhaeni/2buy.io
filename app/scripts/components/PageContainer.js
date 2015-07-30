import React, { Component } from 'react';

export default class extends Component {

  static propTypes = {
    children: React.PropTypes.oneOfType([
      React.PropTypes.object,
      React.PropTypes.array
    ])
  }

  render() {
    return (
      <div>
        {this.props.children}
      </div>
    );
  }
}
