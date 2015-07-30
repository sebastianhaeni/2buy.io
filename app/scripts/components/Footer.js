import React, { Component } from 'react';

export default class extends Component {

  render() {
    return (
      <footer className="mdl-mega-footer">
        <div className="mdl-mega-footer__bottom-section">
          <div className="mdl-logo">&copy; 2015 Sebastian Häni</div>
          <ul className="mdl-mega-footer__link-list">
            <li><a href="/help">Help</a></li>
            <li><a href="/privacy">Privacy & Terms</a></li>
          </ul>
        </div>
      </footer>
    );
  }
}
