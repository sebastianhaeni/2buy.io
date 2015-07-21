import React from 'react';
import { Navigation } from 'react-router';
import { TextField, RaisedButton } from 'material-ui';
import auth from '../../../utils/Auth';

export default React.createClass({

  mixins: [ Navigation ],

  getInitialState() {
    return {
      error: false
    };
  },

  handleSubmit(event) {
    event.preventDefault();

    let email = this.refs.email.getValue();
    let pass = this.refs.password.getValue();

    auth.login(email, pass).then(() => {
      let { location } = this.context.router.state;

      if (location.state && location.state.nextPathname) {
        this.replaceWith(location.state.nextPathname);
      } else {
        this.replaceWith('/');
      }
    }, () => {
      this.setState({ error: true });
    });
  },

  render() {
    return (
      <form onSubmit={this.handleSubmit}>
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
        <RaisedButton label="Sign In" primary={true} type="submit" />
        &nbsp;
        <RaisedButton label="Register" onClick={this._handleRegister} />

        {this.state.error && (
          <p>Bad login information.</p>
        )}
      </form>
    );
  },

  _handleRegister() {
    this.context.router.transitionTo('/register');
  }
});
