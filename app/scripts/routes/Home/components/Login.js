import React from 'react';
import EmailPasswordLogin from './EmailPasswordLogin';
import ThirdPartyLogin from './ThirdPartyLogin';

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
