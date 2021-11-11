# bank_account_manager

This is a training project to learn TDD and pratice Symfony and OOP


## Context:

The goal is to manage all your bank accounts, from all banks on only one platform.
More, this application will provide users fonctionnalities and clean interfaces which allow them to have better visibility of their expenses.


## Installation

1. Download the repository  
`git clone https://github.com/kikk01/bank_account_manager.git`

2. Go to the repository
`cd bank_account_manager`

3. Update dependencies  
`composer update`

4. Update Javascript dependencies  
`yarn install --force`

5. Install encore
`yarn encore dev`

6. Create BDD  
configure your .env.local then  
`php bin/console doctrine:database:create`

7. Update BDD  
`php bin/console doctrine:migrations:migrate`  

8. launch server  
`symfony server:start`

9. launch encore for javascript  
`./node_modules/.bin/encore dev-server`  

10. Create data (required for end to end test)  
`composer prepare`


You are ready to visit the app :)  
You can test the app quickly with  
user : test@test.fr  
password : 00000000


## test with phpunit

1. Create BDD for test  
Create .env.test.local file at the root of the project add this line :  
`DATABASE_URL="sqlite:///%kernel.project_dir%/var/cache/test/test.db"`

2. launch test  
`./bin/phpunit`


## Contact me

Something wrong ? You like the project ? Any questions ?  
Please contact me and give me your feedback !  
[linkedin](https://www.linkedin.com/in/hugo-barsamian-7a2490127/) or  
<hugobar@live.fr>