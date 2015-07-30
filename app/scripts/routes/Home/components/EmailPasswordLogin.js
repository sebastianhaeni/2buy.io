import React from 'react';
import { Navigation } from 'react-router';
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
          <div className="mdl-textfield mdl-js-textfield">
            <input className="mdl-textfield__input" type="email" ref="email" />
            <label className="mdl-textfield__label" htmlFor="email">
              E-Mail
            </label>
          </div>
          <div className="mdl-textfield mdl-js-textfield">
            <input
              className="mdl-textfield__input"
              type="password"
              ref="password" />
            <label className="mdl-textfield__label" htmlFor="password">
              Password
            </label>
          </div>
        </div>
        <button className="mdl-button mdl-js-button mdl-button--raised
          mdl-button--colored mdl-js-ripple-effect" type="submit">
          Sign In
        </button>
        <button className="mdl-button mdl-js-button mdl-button--raised
          mdl-js-ripple-effect" onClick={this._handleRegister}>
          Register
        </button>

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
