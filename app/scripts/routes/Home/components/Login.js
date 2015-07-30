import React from 'react';
import EmailPasswordLogin from './email-password-login';
import ThirdPartyLogin from './third-party-login';

export default React.createClass({

  render() {
    return (
      <div>
        <div>
          <p>... using email and password</p>
          <EmailPasswordLogin />
        </div>
        <div>
          <p>... or with a 3rd party service</p>
          <ThirdPartyLogin />
        </div>
      </div>
    );
  }
});
