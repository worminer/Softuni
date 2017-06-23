namespace Blog.Migrations
{
    using Microsoft.AspNet.Identity;
    using Microsoft.AspNet.Identity.EntityFramework;
    using Models;
    using System;
    using System.Data.Entity;
    using System.Data.Entity.Migrations;
    using System.Linq;

    public sealed class Configuration : DbMigrationsConfiguration<Blog.Models.BlogDbContext>
    {

        private void CreateRole(BlogDbContext context, string roleName)
        {
            var roleManger = new RoleManager<IdentityRole>(new RoleStore<IdentityRole>(context));
            var result = roleManger.Create(new IdentityRole(roleName));

            if (!result.Succeeded)
            {
                throw new Exception(String.Join(";", result.Errors));
            }
        }

        private void CreateUser(BlogDbContext context, string email, string fullName, string password)
        {
            //Create user menager
            var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(context));

            //Set user menager password validator
            userManager.PasswordValidator = new PasswordValidator
            {
                RequiredLength = 1,
                RequireDigit = false,
                RequireLowercase = false,
                RequireNonLetterOrDigit = false,
                RequireUppercase = false
            };

            //Create user object
            var admin = new ApplicationUser
            {
                UserName = email,
                FullName = fullName,
                Email = email
            };

            //create user
            var result = userManager.Create(admin, password);

            //validate results
            if (!result.Succeeded)
            {
                throw new Exception(String.Join(",", result.Errors));
            }
        }

        private void SetRoleToUser(BlogDbContext context, string email, string role)
        {
            var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(context));

            var user = context.Users.Where(u => u.Email == email).First();

            var result = userManager.AddToRole(user.Id, role);

            if (!result.Succeeded)
            {
                throw new Exception(string.Join(";", result.Errors));
            }
        }
        public Configuration()
        {
            AutomaticMigrationsEnabled = true;
            AutomaticMigrationDataLossAllowed = true;
        }

        protected override void Seed(Blog.Models.BlogDbContext context)
        {
            if (!context.Roles.Any())
            {
                this.CreateRole(context, "Admin");
                this.CreateRole(context, "User");
            }

            if (!context.Users.Any())
            {
                this.CreateUser(context, "admin@admin.com", "Admin", "123");
                this.SetRoleToUser(context, "admin@admin.com", "Admin");

                this.CreateUser(context, "user@user.com", "Admin", "123");
                this.SetRoleToUser(context, "user@user.com", "Admin");
            }
        }
    }
}
