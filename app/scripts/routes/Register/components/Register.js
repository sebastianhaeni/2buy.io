import React from 'react';

export default React.createClass({

  render() {
    return (
      <div>
        <h1>2buy.io</h1>
        <h2>Registration</h2>
        <form onSubmit={this._handleSubmit}>
          <div>
            <div className="mdl-textfield mdl-js-textfield">
              <input className="mdl-textfield__input"
                type="email" refs="email" required={true} />
              <label className="mdl-textfield__label"
                htmlFor="email">E-Mail</label>
            </div>
          </div>
          <div>
            <div className="mdl-textfield mdl-js-textfield">
              <input className="mdl-textfield__input"
                type="password" refs="password" required={true} />
              <label className="mdl-textfield__label"
                htmlFor="password">Password</label>
            </div>
          </div>
          <button className="mdl-button mdl-js-button mdl-button--raised
            mdl-button--colored" type="submit">
            Submit
          </button>
        </form>
      </div>
    );
  },

  _handleSubmit() {
    // TODO
  }
});
