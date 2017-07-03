import Alt from '../alt';

class UserAction {
  constructor() {
    this.generateActions(
      'loginUserSuccess',
      'loginUserFail',
      'logoutUserSuccess'
    )
  }

  loginUser(data) {
    let request = {
      url: '/user/login',
      method: 'post',
      data: JSON.stringify(data),
      contentType: 'application/json'
    };
    $.ajax(request)
      .done(data => this.loginUserSuccess(data))
      .fail(err => this.loginUserFail(err.responseJSON));

    return true;
  }

  logoutUser() {
    let request = {
      url: '/user/logout',
      method: 'post'
    };
    $.ajax(request)
      .done(() => this.logoutUserSuccess());

    return true;
  }

}

export default Alt.createActions(UserAction);