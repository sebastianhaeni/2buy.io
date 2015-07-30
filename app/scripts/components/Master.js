import React from 'react';
import Home from '../routes/Home/components/Home';
import Footer from './Footer';

export default React.createClass({

  propTypes: {
    children: React.PropTypes.object
  },

  render() {
    return (
      <div className="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
        mdl-layout--fixed-header">
        <main className="mdl-layout__content">
          {this.props.children || <Home />}
        </main>
        <Footer />
      </div>
    );
  }
});
