# bank_account_manager

This is a training project to learn TDD and pratice Symfony and OOP


## Context:

The goal is to manage all your bank accounts, from all banks on only one platform.
More, this application will provide users fonctionnalities and clean interfaces which allow them to have better visibility of their expenses.


## Installation

1. Download the repository  
`git clone https://github.com/kikk01/bank_account_manager.git`

2. Update dependencies  
`composer update`

3. Update Javascript dependencies  
`yarn install --force`

4. Create BDD  
configure your .env.local then  
`php bin/console doctrine:database:create`

5. Update BDD  
`php bin/console doctrine:migrations:migrate`  
6. launch server  
`php bin/console server:start`

7. launch encore for javascript  
`./node_modules/.bin/encore dev-server`  

8. Create data (required for end to end test)  
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