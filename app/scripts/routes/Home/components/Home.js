import React from 'react';
import { Navigation } from 'react-router';
import { Mixins, Dialog, RaisedButton, Styles } from 'material-ui';
import FullWidthSection from '../../../components/FullWidthSection';
import Login from './Login';

let { StylePropable, StyleResizable } = Mixins;
let { Colors, Typography } = Styles;
let ThemeManager = new Styles.ThemeManager().getCurrentTheme();

export default React.createClass({

  mixins: [Navigation, StylePropable, StyleResizable],

  contextTypes: {
    router: React.PropTypes.object,
    muiTheme: React.PropTypes.object
  },

  render() {
    return (
      <div>
        {this._getHomePageHero()}
        {this._getHomePurpose()}
        {this._getHomeFeatures()}
        {this._getSignInDialog()}
      </div>
    );
  },

  _getHomePageHero() {
    let styles = {
      root: {
        backgroundColor: ThemeManager.palette.primary2Color,
        overflow: 'hidden'
      },
      tagline: {
        margin: '16px auto 0 auto',
        textAlign: 'center',
        maxWidth: '575px'
      },
      label: {
        color: ThemeManager.palette.primary1Color
      },
      signInStyle: {
        margin: '16px 32px 0px 32px'
      },
      h1: {
        color: Colors.darkWhite,
        fontWeight: Typography.fontWeightLight
      },
      h2: {
        //.mui-font-style-title
        fontSize: '20px',
        lineHeight: '28px',
        paddingTop: '19px',
        marginBottom: '13px',
        letterSpacing: '0'
      },
      nowrap: {
        whiteSpace: 'nowrap'
      },
      taglineWhenLarge: {
        marginTop: '32px'
      },
      h1WhenLarge: {
        fontSize: '56px'
      },
      h2WhenLarge: {
        //.mui-font-style-headline;
        fontSize: '24px',
        lineHeight: '32px',
        paddingTop: '16px',
        marginBottom: '12px'
      }
    };

    styles.h2 = this.mergeStyles(styles.h1, styles.h2);

    if (this.isDeviceSize(StyleResizable.statics.Sizes.LARGE)) {
      styles.tagline = this.mergeStyles(
        styles.tagline,
        styles.taglineWhenLarge);
      styles.h1 = this.mergeStyles(styles.h1, styles.h1WhenLarge);
      styles.h2 = this.mergeStyles(styles.h2, styles.h2WhenLarge);
    }

    return (
      <FullWidthSection style={styles.root}>
        <div style={styles.tagline}>
          <h1 style={styles.h1}>2buy.io</h1>
          <h2 style={styles.h2}>
            This will make your life easier by giving you a way to interact
            and manage your household digitally.
          </h2>
          <RaisedButton
            label="Sign In"
            onTouchTap={this._onSignInClick}
            linkButton={true}
            style={styles.signInStyle}
            labelStyle={styles.label}/>
        </div>
      </FullWidthSection>
    );
  },

  _getHomePurpose() {
    let styles = {
      root: {
        backgroundColor: Colors.grey200
      },
      content: {
        maxWidth: '700px',
        padding: 0,
        margin: '0 auto',
        fontWeight: Typography.fontWeightLight,
        fontSize: '20px',
        lineHeight: '28px',
        paddingTop: '19px',
        marginBottom: '13px',
        letterSpacing: '0',
        textAlign: 'center',
        color: Typography.textDarkBlack
      }
    };

    return (
      <FullWidthSection style={styles.root}>
        <p style={styles.content}>
          2buy.io helps managing shopping lists, shopping trips, ToDo lists,
          discussions, bills. Create multiple communities and invite friends.
        </p>
      </FullWidthSection>
    );
  },

  _getHomeFeatures() {
    let styles = {
      root: {
        textAlign: 'center'
      },
      content: {
        maxWidth: 906
      }
    };
    return (
      <FullWidthSection style={styles.root}>
        <p style={styles}>TODO: Features</p>
      </FullWidthSection>
    );
  },

  _getSignInDialog() {
    return (
      <Dialog
        title="Sign In ..."
        actions={[{ text: 'Cancel' }]}
        ref="signInDialog">
        <Login />
      </Dialog>
    );
  },

  _onSignInClick() {
    this.refs.signInDialog.show();
  }
});
