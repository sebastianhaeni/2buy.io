import Api from './api';
import AuthConstants from '../constants/auth-constants';

class Auth {

  constructor(router){
    this.router = router;
  }

  login(email, pass) {
    if(localStorage.loggedIn) {
      return new Promise((resolve) => {
        resolve();
      });
    }

    return Api.login(email, pass)
      .then(this.handleResponse)
      .then(this.handleLoginSuccess, this.handleLoginFailure);
  }

  login3rdParty(type, token) {
    switch (type) {
    case AuthConstants.GOOGLE :
      return Api.googleLogin(token)
        .then((response) => {
          if(!response.Success){
            throw new Error('invalid login');
          }
        })
        .then(() => {
          localStorage.loggedIn = true;
          this.onChange(true);
        }, () => {
          this.onChange(false);
        });
    default :
      throw new Error('3rd party service ' + type + ' not implmented');
    }
  }

  logout() {
    localStorage.loggedIn = false;
    return Api.logout();
  }

  loggedIn() {
    return localStorage.loggedIn;
  }

  onChange() {}
}

const auth = new Auth();

export function requireAuth(nextState, transition) {
  if (!auth.loggedIn()) {
    transition.to('/', null, {
      nextPathname: nextState.location.pathname
    });
  }
}

export default auth;
