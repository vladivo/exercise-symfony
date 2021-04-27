# Description
Hello! This is my very first Symfony project with some database, CRUD-API, Authentication, 
Authorisation and rudimentary frontend written with Angular Universal. 

The main idea was to learn the low-level basics of Symfony framework while creating a small content management system, 
but unfortunately I just hadn't enough time to implement such things like "Blog posts" or "Products".

Still it is functionally a quite complete piece of software where you have such content entities like 
`Account`, `Role` and `Permission` which are used to control access to the CRUD operations with themselves.

In any case, this is not a production-ready application, not the most efficient code and not the best architecture.
The goal of this project was to learn the (mostly) low-level basics of Symfony framework.

Considering the given time limit of approximately 100 hours, 
the end result is not completely unsatisfactory, I would say.

There are few important things which were not implemented/configured and therefore must be at least mentioned here:
1. Tests - unit, functional, regression, end-to-end.
2. CSRF-protection or Session-less API
3. Code style checkers
4. Static code analysis
5. Optimal stack configuration (currently it is an adjusted copy from another project)
6. Some essential features like search, pagination, etc.
7. Client-side validation and access checkers (the backend is currently responsible for everything)
8. The actual frontend is in general a piece of garbage and its only purpose is to make
   all things a little more "touchable" and manual testing a little less boring.

# Installation
In order to run this project locally you need Linux (developed with Ubuntu 20.10) or MacOS (tested with Catalina 10.15), 
`bash`, `git`, `docker`, `docker-compose`, and free ports - `80`, `3306`, `8025`. 

If you are using Linux (preferable, much faster) you might want to adjust the values of the
`APP_HOST_UID` and `APP_HOST_GID` variables in the `.env` file. 
Otherwise, all files created by `composer` and `yarn` will probably not belong to the host user.

1. Clone this repository

```bash
git clone https://github.com/vladivo/exercise-symfony.git
```

2. Change your working directory

```bash
cd exercise-symfony
```

3. Pull `database` and `mailhog` docker images

```bash
bin/stack pull
```

4. Build `php`, `node` and `nginx` images. It will take few minutes.

```bash
bin/stack build
```

5. Install composer dependencies

```bash
bin/composer install
```

6. Install node dependencies

```bash
bin/yarn install --frozen-lock
```

7. Now you can spin up the stack. Wait a little, the Angular development server is the heaviest service.

```bash
bin/stack up
```

- Please notice that if you want to restart the stack you have to put it down first.

```bash
bin/stack down && bin/stack up
```

8. The last step is to generate some data and to create the admin account
   (use another terminal window, because the stack must be up and running). 
   You can always use this command again in order to reset/re-install all data. 

```bash
bin/console application:install
```

Now you are ready to go. 
The application is available at port `80`, database at port `3306`, and the mailhog at port `8025`.
Open the site in browser, click through it and check whether everything is working as expected.

# Last, but not least
To the time of this commit, the backend seems quite stable to me and does everything as expected, 
but it is also flexible enough and gives you the ability to break all the things. 
For instance, the admin user can block own account, renaming of internal permissions will break the access to the 
corresponding entities, and removing the role entity will trigger automatic logout (Symfony does that)
if it was assigned to the current user.

Besides that, if you are still here and already ran all installation scripts, 
I hope very much that you'll also have some fun while messing around with the app. 

Cheers!
