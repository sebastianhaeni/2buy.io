import Api from './Api';
import AuthConstants from '../constants/AuthConstants';

class Auth {

  constructor(router){
    this.router = router;
  }

  login(email, pass) {
    //if (localStorage.token) {
    //  this.onChange(true);
    //  return new Promise((resolve) => {
    //    resolve();
    //  });
    //}
    return Api.login(email, pass).then(this.handleLoginSuccess);
  }

  login3rdParty(type, token) {
    switch (type) {
    case AuthConstants.GOOGLE :
      return Api.googleLogin(token).then(this.handleLoginSuccess);
    default :
      throw new Error('3rd party service ' + type + ' not implmented');
    }
  }

  handleLoginSuccess(response) {
    //localStorage.token = response.token;
    //this.onChange(true);

    // TODO
    //this.router.transitionTo('/app');
  }

  getToken() {
    return localStorage.token;
  }

  logout(cb) {
    delete localStorage.token;
    if (cb) {
      cb();
    }
    this.onChange(false);
  }

  loggedIn() {
    return !!localStorage.token;
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

export
default auth;
