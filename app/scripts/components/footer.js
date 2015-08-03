import React, { Component } from 'react';
import { Link } from 'react-router';

export default class extends Component {

  render() {
    return (
      <footer className="mdl-mega-footer">
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

}
