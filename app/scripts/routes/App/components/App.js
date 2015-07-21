import React, { Component } from 'react';
import PageContainer from './../../../components/PageContainer';
import auth from '../../../utils/Auth';
import Navigation from './Navigation';

export default class extends Component {

  static propTypes = {
    children: React.PropTypes.object
  }

  static contextTypes = {
    router: React.PropTypes.object
  }

  constructor() {
    super();
    this.state = {
      loggedIn: auth.loggedIn()
    };
  }

  /**
   * Sets the loggedIn state of auth.
   */
  setStateOnAuth(loggedIn) {
    this.setState({
      loggedIn: loggedIn
    });
  }

  componentWillMount() {
    auth.onChange = this.setStateOnAuth;
    auth.login();
  }

  render() {
    let title =
      !this.state.loggedIn ? '2buy.io' :
      this.context.router.isActive('shopping') ? 'Shopping List' :
      this.context.router.isActive('get-started') ? 'Get Started' :
      this.context.router.isActive('settings') ? 'Settings' :
      this.context.router.isActive('bills') ? 'Bills' : '2buy.io';

    return (
      <div>
        <Navigation title={title} loggedIn={this.state.loggedIn} />
        <PageContainer>
          {this.props.children}
        </PageContainer>
      </div>
    );

  }
}
