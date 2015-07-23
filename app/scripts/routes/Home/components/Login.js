import React from 'react';
import EmailPasswordLogin from './EmailPasswordLogin';
import ThirdPartyLogin from './ThirdPartyLogin';

export default React.createClass({

  getStyles() {
    return {
      root: {
        width: '100%'
      },
      leftCol: {
        width: '50%',
        float: 'left',
        boxSizing: 'border-box',
        borderRight: '1px solid #eee'
      },
      rightCol: {
        paddingLeft: 20,
        float: 'left'
      },
      label: {
        fontSize: 14,
        marginBottom: 20,
        fontWeight: 300
      }
    };
  },

  render() {
    let styles = this.getStyles();
    return (
      <div style={styles.root}>
        <div style={styles.leftCol}>
          <p style={styles.label}>... using email and password</p>
          <EmailPasswordLogin />
        </div>
        <div style={styles.rightCol}>
          <p style={styles.label}>... or with a 3rd party service</p>
          <ThirdPartyLogin />
        </div>
      </div>
    );
  }
});
