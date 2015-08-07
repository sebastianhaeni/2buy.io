import React from 'react';
import { Navigation } from 'react-router';
import DocumentTitle from '../../../components/document-title';
import Footer from '../../../components/footer';
import auth from '../../../utils/auth';
import ThirdPartyLogin from './third-party-login';

export default React.createClass({

  mixins: [ Navigation ],

  render() {
    const gridStyle = {
      justifyContent: 'center',
      height: '100vh'
    };
    const cardStyle = {
      width: '100%'
    };
    const thirdPartyStyle = {
      display: 'flex',
      justifyContent: 'center'
    };
    const layoutStyle = {
      backgroundImage: 'url(' + require('../images/sign-in-header.jpg') + ')',
      backgroundPosition: 'center center',
      backgroundSize: 'cover'
    };

    return (
      <DocumentTitle title="Sign In">
        <div className="mdl-layout mdl-js-layout" style={layoutStyle}>
          <header className="mdl-layout__header mdl-layout__header--transparent">
            <div className="mdl-layout__drawer-button" onClick={this.goBack}>
              <i className="material-icons">arrow_back</i>
            </div>
            <div className="mdl-layout__header-row">
              <span className="mdl-layout-title">Sign in</span>
            </div>
          </header>
          <main className="mdl-layout__content">
            <div className="mdl-grid" style={gridStyle}>
              <div className="mdl-cell mdl-cell--4-col">
                <div className="mdl-card mdl-shadow--6dp" style={cardStyle}>
                  <div className="mdl-card__title" style={thirdPartyStyle}>
                    <h2 className="mdl-card__title-text">
                      Please sign in:
                    </h2>
                  </div>
                  <div className="mdl-card__supporting-text" style={thirdPartyStyle}>
                    <ThirdPartyLogin handleSuccess={this._handleSuccess} handleFailure={this._handleFailure} />
                  </div>
                </div>
              </div>
            </div>
            <Footer />
          </main>
        </div>
      </DocumentTitle>
    );
  },

  _handleSuccess(authType, token) {
    auth.login3rdParty(authType, token).then(() => {
      this.transitionTo('/app');
    }, this._handleFailure);
  },

  _handleFailure(error) {
    console.error(error);
  }

});
