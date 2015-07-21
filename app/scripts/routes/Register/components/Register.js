import React from 'react';
import { TextField, RaisedButton, Styles } from 'material-ui';
import PageContainer from '../../../components/PageContainer';

const ThemeManager = new Styles.ThemeManager();

export default React.createClass({

  childContextTypes: {
    muiTheme: React.PropTypes.object
  },

  getChildContext() {
    return {
      muiTheme: ThemeManager.getCurrentTheme()
    };
  },

  render() {
    return (
      <PageContainer>
        <h1>2buy.io</h1>
        <h2>Registration</h2>
        <form onSubmit={this._handleSubmit}>
          <div>
            <TextField
              hintText="Email"
              ref="email"
              type="email"
              required={true} />
          </div>
          <div>
            <TextField
              hintText="Password"
              ref="password"
              type="password"
              required={true} />
          </div>
          <RaisedButton primary={true} label="Submit" type="submit" />
        </form>
      </PageContainer>
    );
  },

  _handleSubmit() {
    // TODO
  }
});
