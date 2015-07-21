import React, { Component } from 'react';
import { Styles } from 'material-ui';

let DesktopGutter = Styles.Spacing.desktopGutter;

export default class extends Component {

  static propTypes = {
    children: React.PropTypes.oneOfType([
      React.PropTypes.object,
      React.PropTypes.array
    ])
  }

  getStyles() {
    return {
      margin: DesktopGutter
    };
  }

  render() {
    let styles = this.getStyles();

    return (
      <div style={styles}>
        {this.props.children}
      </div>
    );
  }
}
