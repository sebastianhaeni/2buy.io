import React from 'react';
import { ClearFix, Mixins, Styles } from 'material-ui';

let { StylePropable, StyleResizable } = Mixins;
let DesktopGutter = Styles.Spacing.desktopGutter;

export default React.createClass({

  mixins: [
    StylePropable, StyleResizable
  ],

  propTypes: {
    children: React.PropTypes.object,
    style: React.PropTypes.object
  },

  getStyles() {
    return {
      root: {
        padding: DesktopGutter,
        boxSizing: 'border-box'
      },
      content: {
        maxWidth: 1200,
        margin: '0 auto'
      },
      rootWhenSmall: {
        paddingTop: (DesktopGutter * 2),
        paddingBottom: (DesktopGutter * 2)
      },
      rootWhenLarge: {
        paddingTop: (DesktopGutter * 3),
        paddingBottom: (DesktopGutter * 3)
      }
    };
  },

  render() {
    let {
      style,
      ...other
    } = this.props;

    let styles = this.getStyles();

    return (
      <ClearFix {...other}
        style={this.mergeAndPrefix(
          styles.root,
          style,
          this.isDeviceSize(StyleResizable.statics.Sizes.SMALL)
            && styles.rootWhenSmall,
          this.isDeviceSize(StyleResizable.statics.Sizes.LARGE)
            && styles.rootWhenLarge)}>
        {this.props.children}
      </ClearFix>
    );
  }
});
