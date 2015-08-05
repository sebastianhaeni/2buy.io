import React from 'react';
import { Link } from 'react-router';

export default React.createClass({

  render() {
    const style = {
      zIndex: 2,
      bottom: 0,
      position: 'fixed',
      width: '100%'
    };

    return (
      <footer className="mdl-mega-footer" style={style}>
        <div className="mdl-mega-footer__bottom-section">
          <div className="mdl-logo">
            2buy.io
          </div>
          <ul className="mdl-mega-footer__link-list">
            <li><Link to="/help">Help</Link></li>
            <li><Link to="/privacy">Privacy and Terms</Link></li>
          </ul>
        </div>
      </footer>
    );
  }

});
