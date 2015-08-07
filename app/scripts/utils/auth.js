import Api from './api';
import AuthConstants from '../constants/auth-constants';

const auth = {

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
        });
    default :
      throw new Error('3rd party service ' + type + ' not implmented');
    }
  },

  logout() {
    localStorage.loggedIn = false;
    if(!gapi.auth2) {
      return new Promise((resolve) => {
        resolve();
      });
    }

    let auth2 = gapi.auth2.getAuthInstance();
    return auth2.signOut();
  },

  loggedIn() {
    return localStorage.loggedIn;
  },

  requireAuth(nextState, transition) {
    if (!auth.loggedIn()) {
      transition.to('/', null, {
        nextPathname: nextState.location.pathname
      });
    }
  }

};

export default auth;
