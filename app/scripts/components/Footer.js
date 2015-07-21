import React, { Component } from 'react';
import { Styles } from 'material-ui';
import FullWidthSection from './FullWidthSection';

export default class extends Component {

  getStyles() {
    return {
      footer: {
        backgroundColor: Styles.Colors.grey900,
        textAlign: 'center',
        position: 'absolute',
        width: '100%',
        bottom: 0
      },
      p: {
        margin: '0 auto',
        padding: '0',
        color: Styles.Colors.lightWhite,
        maxWidth: '335px'
      }
    };
  }

  render() {
    let styles = this.getStyles();

    return (
      <FullWidthSection style={styles.footer}>
        <p style={styles.p}>
          &copy; 2015 Sebastian Häni
        </p>
      </FullWidthSection>
    );
  }
}
