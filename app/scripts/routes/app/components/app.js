import React from 'react';
import auth from '../../../utils/auth';
import Footer from '../../../components/footer';
import Navigation from './navigation';
import Drawer from './drawer';
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
      title: '2buy.io',
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

  componentWillReceiveProps() {
    let layout = document.getElementsByClassName('mdl-layout__drawer')[0];
    layout.className = 'mdl-layout__drawer';
  },

  render() {
    return (
      <div className="mdl-layout mdl-js-layout mdl-layout--fixed-header" ref="container">
        <Navigation title={this.state.title} />
        <Drawer />
        <main>
          {this.props.children || <Dashboard />}
        </main>
        <Footer />
      </div>
    );
  }

});
