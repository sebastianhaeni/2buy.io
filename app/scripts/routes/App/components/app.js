import React from 'react';
import auth from '../../../utils/auth';
import Navigation from './navigation';

export default React.createClass({

  propTypes: {
    children: React.PropTypes.object
  },

  contextTypes: {
    router: React.PropTypes.object
  },

  getInitialState() {
    return {
      loggedIn: auth.loggedIn()
    };
  },

  /**
   * Sets the loggedIn state of auth.
   */
  setStateOnAuth(loggedIn) {
    this.setState({
      loggedIn: loggedIn
    });
  },

  componentWillMount() {
    auth.onChange = this.setStateOnAuth;
    auth.login();
  },

  render() {
    let title =
      !this.state.loggedIn ? '2buy.io' :
      this.context.router.isActive('shopping') ? 'Shopping List' :
      this.context.router.isActive('get-started') ? 'Get Started' :
      this.context.router.isActive('settings') ? 'Settings' :
      this.context.router.isActive('bills') ? 'Bills' : '2buy.io';

    return (
      <div>
        <Navigation title={title} />
        <div>
          {this.props.children}
        </div>
      </div>
    );

  }
});
