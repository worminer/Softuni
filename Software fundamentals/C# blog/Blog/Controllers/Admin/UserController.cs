using Blog.Models;
using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Identity.EntityFramework;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Data.Entity;
using System.Net;
using Microsoft.AspNet.Identity.Owin;

namespace Blog.Controllers.Admin
{
    [Authorize(Roles = "Admin")]
    public class UserController : Controller
    {

        // GET: User
        public ActionResult Index()
        {
            return RedirectToAction("List");
        }

        //
        // GET: User/List
        public ActionResult List()
        {
            using (var database = new BlogDbContext())
            {
                var users = database.Users.ToList();

                var admins = GetAdminUserNames(users, database);
                ViewBag.Admins = admins;

                return View(users);
            }
        }


        private HashSet<string> GetAdminUserNames(List<ApplicationUser> users, BlogDbContext context)
        {
            var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(context));

            var admins = new HashSet<string>();

            foreach (var user in users)
            {
                if (userManager.IsInRole(user.Id, "Admin"))
                {
                    admins.Add(user.UserName);
                }
            }

            return admins;
        }

        //
        //GET: User/Edit
        public ActionResult Edit(string id)
        {
            //Validate id
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            using (var db = new BlogDbContext())
            {
                //Get user from dabase
                var user = db.Users.FirstOrDefault(u => u.Id.Equals(id));

                // Check if user exist
                if (user == null)
                {
                    return HttpNotFound();
                }

                // Create view model
                var models = new EditUserViewModel();
                models.Email = user.Email;
                models.FullName = user.FullName;
                models.Roles = GetUserRoles(user, db);

                // Pass the model to the view
                return View(models);
            }
        }

        //
        //POST: User/Edit
        [HttpPost]
        public ActionResult Edit(string id, EditUserViewModel model)
        {
            //Check if model is valid
            if (ModelState.IsValid)
            {
                using (var db = new BlogDbContext())
                {
                    //Get user from db
                    var user = db.Users.FirstOrDefault(u => u.Id == id);

                    //Check if exists
                    if (user == null)
                    {
                        return HttpNotFound();
                    }

                    //if pass is not empty, change pass
                    if (!string.IsNullOrEmpty(model.Password))
                    {
                        var hasher = new PasswordHasher();
                        var passHash = hasher.HashPassword(model.Password);
                        user.PasswordHash = passHash;
                    }

                    //Set user properties
                    user.Email = model.Email;
                    user.FullName = model.FullName;
                    user.UserName = model.Email;

                    this.SetUserRoles(model, user, db);

                    //Save
                    db.Entry(user).State = EntityState.Modified;
                    db.SaveChanges();
                }


                return RedirectToAction("List");
            }
            return View(model);
        }

        //
        //GET: User/Delete
        public ActionResult Delete(string id)
        {
            //Validate id
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            using (var db = new BlogDbContext())
            {
                //Get user from dabase
                var user = db.Users.FirstOrDefault(u => u.Id.Equals(id));

                // Check if user exist
                if (user == null)
                {
                    return HttpNotFound();
                }

                // Pass the model to the view
                return View(user);
            }
        }

        //
        //POST: User/Delete
        [HttpPost]
        [ActionName("Delete")]
        public ActionResult DeleteComfirmed(string id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            using (var database = new BlogDbContext())
            {
                var user = database.Users.Where(u => u.Id.Equals(id)).First();

                var userArticles = database.Articles.Where(a => a.Author.Id == user.Id);

                foreach (var article in userArticles)
                {
                    database.Articles.Remove(article);
                }

                database.Users.Remove(user);
                database.SaveChanges();

                return RedirectToAction("List");

            }

        }

        private void SetUserRoles(EditUserViewModel model, ApplicationUser user, BlogDbContext context)
        {
            var userManager = HttpContext.GetOwinContext().GetUserManager<ApplicationUserManager>();
            foreach (var role in model.Roles)
            {
                if (role.IsSelected && !userManager.IsInRole(user.Id,role.Name))
                {
                    userManager.AddToRole(user.Id, role.Name);
                }
                else if (!role.IsSelected && userManager.IsInRole(user.Id, role.Name))
                {
                    userManager.RemoveFromRole(user.Id, role.Name);
                }
            }
        }

        private List<Role> GetUserRoles(ApplicationUser user, BlogDbContext db)
        {
            //Create user manager
            var userManager = Request.GetOwinContext().GetUserManager<ApplicationUserManager>();

            //Get all aplication roles
            var roles = db.Roles.Select(r => r.Name).OrderBy(r => r).ToList();

            //For each applicaction role, check if the user has it
            var userRoles = new List<Role>();
            foreach (var roleName in roles)
            {
                Role role = new Role { Name = roleName };

                if (userManager.IsInRole(user.Id, roleName))
                {
                    role.IsSelected = true;
                }
                userRoles.Add(role);
            }

            //Return the list with all roles
            return userRoles;
        }

       

        
    }
}