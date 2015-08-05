import React from 'react';
import auth from '../../../utils/auth';
import Footer from '../../../components/footer';
import Navigation from './navigation';
import Dashboard from './dashboard';

export default React.createClass({

  propTypes: {
    children: React.PropTypes.object
  },

  contextTypes: {
    router: React.PropTypes.object
  },

  getInitialState() {
    return {
      loggedIn: auth.loggedIn(),
      isDrawerVisible: false
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
    return (
      <div className="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <Navigation toggleDrawer={this._toggleDrawer} isDrawerVisible={this.state.isDrawerVisible} />
        <main onClick={this._hideNavigationDrawer}>
          {this.props.children || <Dashboard />}
        </main>
        <Footer />
      </div>
    );
  },

  _toggleDrawer() {
    this.setState({isDrawerVisible: !this.state.isDrawerVisible});
  },

  _hideNavigationDrawer() {
    this.setState({isDrawerVisible: false});
  }

});
