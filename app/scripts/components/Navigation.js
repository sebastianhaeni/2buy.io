import React from 'react';
import { Navigation } from 'react-router';
import {
  AppBar,
  LeftNav,
  IconButton,
  Styles
} from 'material-ui';

import IconMenu from 'material-ui/lib/menus/icon-menu';
import MenuItem from 'material-ui/lib/menus/menu-item';

let { Spacing, Typography } = Styles;

const menuItems = [
  { route: '/', text: 'Dashboard' },
  { route: 'shopping', text: 'Shopping List' },
  { route: 'bills', text: 'Bills' }
];

export default React.createClass({
  mixins: [ Navigation ],

  propTypes: {
    title: React.PropTypes.string
  },

  contextTypes: {
    muiTheme: React.PropTypes.object
  },

  getStyles() {
    return {
      cursor: 'pointer',
      fontSize: '24px',
      color: Typography.textFullWhite,
      lineHeight: Spacing.desktopKeylineIncrement + 'px',
      fontWeight: Typography.fontWeightLight,
      backgroundColor: this.context.muiTheme.palette.primary1Color,
      paddingLeft: Spacing.desktopGutter,
      paddingTop: '0px',
      marginBottom: '8px'
    };
  },

  _handleRefresh() {
    console.warn('NOT YET IMPLEMENTED: refresh');
  },

  _handleSettings() {
    this.context.router.transitionTo('settings');
  },

  _handleLogout() {
    this.context.router.transitionTo('logout');
  },

  render() {
    //let username = ''; // TODO

    let header = (
      <div style={this.getStyles()} onTouchTap={this._onHeaderClick}>
        2buy.io
      </div>
    );

    let iconButtonElement = (
      <IconButton>
        <i className="material-icons md-light">expand_more</i>
      </IconButton>
    );

    let userMenu = (
      <IconMenu iconButtonElement={iconButtonElement}>
        <MenuItem primaryText="Refresh" onClick={this._handleRefresh} />
        <MenuItem primaryText="Settings" onClick={this._handleSettings} />
        <MenuItem primaryText="Sign out" onClick={this._handleLogout} />
      </IconMenu>
    );

    return (
      <div>
        <AppBar
          title={this.props.title}
          onLeftIconButtonTouchTap={this._toggleLeftNav}
          iconElementRight={userMenu}
          zDepth={1}
          />
        <LeftNav
          ref="leftNav"
          header={header}
          docked={false}
          menuItems={menuItems}
          onChange={this._onLeftNavChange} />
      </div>
    );
  },

  _toggleLeftNav() {
    this.refs.leftNav.toggle();
  },

  _onLeftNavChange(e, key, payload) {
    this.transitionTo(payload.route);
  },

  _onHeaderClick() {
    this.transitionTo('/');
    this.refs.leftNav.close();
  }

});
