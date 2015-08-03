import React from 'react';
import GoogleLogin from './google-login';

export default React.createClass({

  propTypes: {
    handleSuccess: React.PropTypes.func.isRequired,
    handleFailure: React.PropTypes.func.isRequired
  },

  render() {
    return (
      <div>
        <GoogleLogin
          handleSuccess={this.props.handleSuccess}
          handleFailure={this.props.handleFailure} />
      </div>
    );
  }

});
