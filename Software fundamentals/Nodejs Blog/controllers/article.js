const Article = require('mongoose').model('Article');
const Category = require('mongoose').model('Category');

module.exports = {
  createGet: (req, res) => {
    if (!req.isAuthenticated()) {
      let returnUrl = '/article/create';
      req.session.returnUrl = returnUrl;

      res.redirect('/user/login');
      return;
    }
    Category.find({}).then(categories => {
      res.render('article/create',{categories:categories});
    })

  },

  createPost: (req, res) => {
    if (!req.isAuthenticated()) {
      let returnUrl = '/article/create';
      req.session.returnUrl = returnUrl;

      res.redirect('/user/login');
      return;
    }

    let articleArgs = req.body;

    let errorMsg = '';
    if (!articleArgs.title) {
      errorMsg = 'Invalid title!';
    } else if (!articleArgs.content) {
      errorMsg = 'Invalid content!';
    }

    if (errorMsg) {
      res.render('article/create', {error: errorMsg});
      return;
    }

    articleArgs.author = req.user.id;
    Article.create(articleArgs).then(article => {
        article.prepareInsert();
        res.redirect('/');
    }).catch((error) => {
      console.log(error.message);
    });
  },

  details: (req, res) => {
    let id = req.params.id;

    Article.findById(id).populate('author').then(article => {
      if (!req.user) {
        res.render('article/details', {article: article, isUserAuthorized: false});
        return;
      }

      req.user.isInRole('Admin').then(isAdmin => {
        let isUserAuthorized = isAdmin || req.user.isAuthor(article);

        res.render('article/details', {article: article, isUserAuthorized: isUserAuthorized});
      }).catch((error) => {
        console.log(error.message);
      });
    }).catch((error) => {
      console.log(error.message);
    });
  },

  editGet: (req, res) => {
    let id = req.params.id;

    if (!req.isAuthenticated()) {
      let returnUrl = `/article/edit/${id}`;
      req.session.returnUrl = returnUrl;

      res.redirect('/user/login');
      return;
    }

    Article.findById(id).then(article => {
      req.user.isInRole('Admin').then(isAdmin => {
        if (!isAdmin && !req.user.isAuthor(article)) {
          res.redirect('/');
          return;
        }
        Category.find({}).then(categories => {
          article.categories = categories;
        })
        res.render('article/edit', article)
      }).catch((error) => {
        console.log(error.message);
      });
    }).catch((error) => {
      console.log(error.message);
    });
  },

  editPost: (req, res) => {
    let id = req.params.id;

    if (!req.isAuthenticated()) {
      let returnUrl = `/article/edit/${id}`;
      req.session.returnUrl = returnUrl;

      res.redirect('/user/login');
      return;
    }

    let articleArgs = req.body;

    let errorMsg = '';
    if (!articleArgs.title) {
      errorMsg = 'Article title cannot be empty!';
    } else if (!articleArgs.content) {
      errorMsg = 'Article content cannot be empty!'
    }

    if (errorMsg) {
      res.render('article/edit', {error: errorMsg})
    } else {
      Article.findById(id).populate('category').then(article => {
        if(article.category.id !== articleArgs.category){
          article.category.articles.remove(article.id);
          article.category.save();
        }

        article.category = articleArgs.category;
        article.title = articleArgs.title;
        article.content = articleArgs.content;
        Category.findById(article.category).then(category => {
          if(category.articles.indexOf(article.id) === -1){
            category.articles.push(article.id);
            category.save();
          }
          res.redirect(`/article/details/${id}`);
        })

      })
    }
  },

  deleteGet: (req, res) => {
    let id = req.params.id;

    if (!req.isAuthenticated()) {
      let returnUrl = `/article/delete/${id}`;
      req.session.returnUrl = returnUrl;

      res.redirect('/user/login');
      return;
    }

    Article.findById(id).then(article => {
      req.user.isInRole('Admin').then(isAdmin => {
        if (!isAdmin && !req.user.isAuthor(article)) {
          res.redirect('/');
          return;
        }

        res.render('article/delete', article)
      }).catch((error) => {
        console.log(error.message);
      });
    }).catch((error) => {
      console.log(error.message);
    });
  },


  deletePost: (req, res) => {
    let id = req.params.id;

    if (!req.isAuthenticated()) {
      let returnUrl = `/article/delete/${id}`;
      req.session.returnUrl = returnUrl;

      res.redirect('/user/login');
      return;
    }
    Article.findById(id).then(article => {
      req.user.isInRole('Admin').then(isAdmin => {
        if (isAdmin || req.user.isAuthor(article)) {
          Article.findOneAndRemove({_id: id}).populate('author').then(article => {
            let author = article.author;

            let index = author.articles.indexOf(article.id);

            if (index < 0) {
              let errorMsg = 'Article was not found for that author!';
              res.render('article/delete', {error: errorMsg})
            } else {

              let count = 1;
              author.articles.splice(index, count);
              author.save().then((user) => {
                res.redirect('/');
              }).catch((error) => {
                console.log(error.message);
              });
            }
          }).catch((error) => {
            console.log(error.message);
          });
        }
        else {
          res.redirect('/');
        }


      }).catch((error) => {
        console.log(error.message);
      });
    })
  }
};