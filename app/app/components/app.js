import React from 'react';
import { Footer } from '_lib/components';
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

  componentDidMount() {
    // enable mdl behavior
    componentHandler.upgradeDom();
  },

  componentWillReceiveProps() {
    // clear the 'is-visible' class from the drawer when the page changed
    let layout = document.getElementsByClassName('mdl-layout__drawer')[0];
    layout.className = 'mdl-layout__drawer';
  },

  render() {
    return (
      <div className="mdl-layout mdl-js-layout mdl-layout--fixed-header" ref="container">
        <Navigation />
        <Drawer />
        <main>
          {this.props.children || <Dashboard />}
        </main>
        <Footer />
      </div>
    );
  }

});
