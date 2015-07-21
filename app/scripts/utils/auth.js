import Api from './Api';

class Auth {

  login(email, pass) {
    if (localStorage.token) {
      this.onChange(true);
      return new Promise((resolve) => {
        resolve();
      });
    }
    return Api.login(email, pass).then((response) => {
      if (response.authenticated) {
        localStorage.token = response.token;
        this.onChange(true);
      } else {
        this.onChange(false);
      }
    });
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

export default auth;
