const User = require('mongoose').model('User');
const Role = require('mongoose').model('Role');
const encryption = require('./../../utilities/encryption');

module.exports = {
    all: (req, res) => {
        User.find({}).then(users => {
            for (let user of users) {
                user.isInRole('Admin').then(isAdmin => {
                    user.isAdmin = isAdmin;
                });
            }

            res.render('admin/user/all', {
                subTitle: 'List of all Users!',
                users: users
            });
        })
    },

    editGet: (req, res) => {
        let id = req.params.id;

        User.findById(id).then(user => {
            Role.find({}).then(roles => {
                for (let role of roles) {
                    if (user.roles.indexOf(role.id) !== -1) {
                        role.isChecked = true;
                    }
                }

                res.render('admin/user/edit', {
                    subTitle: 'Edit information for ' + user.email + ' User!',
                    user: user, roles: roles
                });
            })
        })
    },

    editPost: (req, res) => {
        let id = req.params.id;
        let userArgs = req.body;

        User.findOne({email: userArgs.email, _id: {$ne: id}}).then(user => {
            let errorMsg = '';
            if (user) {
                errorMsg = 'User with the same username exists';
            } else if (!userArgs.email) {
                errorMsg = 'Email Cannot be empty';
            } else if (!userArgs.fullName) {
                errorMsg = 'Full Name cannot be empty';
            } else if (userArgs.password !== userArgs.confirmedPassword) {
                errorMsg = 'Passwords do nto match';
            }

            if (errorMsg) {
                userArgs.error = errorMsg;
                res.render(`admin/user/edit/${id}`, userArgs);
            } else {
                User.findById(id).then(user => {
                    if (userArgs.password) {
                        let passwordHash = encryption.hashPassword(userArgs.password, user.salt);
                        user.passwordHash = passwordHash;
                    }

                    Role.find({}).then(roles => {
                        let oldRoles = roles.filter(role => {
                            return user.roles.indexOf(role.id) !== -1;
                        });
                        for (let role of oldRoles) {
                            if (role.users.indexOf(id) !== -1) {
                                role.users.remove(user.id);
                                role.save();
                            }
                        }

                        if (!userArgs.roles) {
                            userArgs.roles = [];
                        }
                        let newRoles = roles.filter(role => {
                            return userArgs.roles.indexOf(role.name) !== -1;
                        });
                        for (let role of newRoles) {
                            if (role.users.indexOf(id) === -1) {
                                role.users.push(user.id);
                                role.save();
                            }
                        }

                        let newUserRoles = newRoles.map(role => {
                            return role.id
                        });
                        user.roles = newUserRoles;

                        user.email = userArgs.email;
                        user.fullName = userArgs.fullName;
                        user.save((err) => {
                            if (err) {
                                res.redirect('/');
                            }

                            res.redirect('/admin/user/all');
                        })
                    });
                })
            }
        })
    },

    deleteGet: (req, res) => {
        let id = req.params.id;

        User.findById(id).then(user => {
            res.render('admin/user/delete', {
                subTitle: 'Delete user ' + user.email + '!',
                userToDelete: user
            })
        });
    },

    deletePost: (req, res) => {
        let id = req.params.id;

        User.findOneAndRemove({_id: id}).then(user => {
            user.prepareDelete();
            res.redirect('/admin/user/all');
        })
    }
};
