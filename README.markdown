#Codeigniter Multi-server deployment Setup
##LiamR
*Revised: 2011/03/20

##Things to look at

###.gitignore
Ignores:

- Cache
- Logs
- Any modules
- .htaccess (root)
- app_version - deployment file with the commit data

###Things to set

- Unique deploy key (in deployment)





##Guides

###Setting up servers
first you have to manually ssh in and create a .git rep, then
add a remote repository - use the read-only to avoid needing to set/use ssh keys/ssh-agent
Then pull. (Might need to be a branch, or rcan you pull from master to begin).

	git init
	git remote add origin git://github.com/liamr/codeigniter_deploy.git
	git pull origin staging

###Deployment process
All development should take place on master - or any feature branch.
There are two branches used for distribution, staging and production. Commiting to these branches will push code to the staging and production servers. To deploy there is a two step process which must be adhered to. 

**To Deploy to staging you must merge from the *master* branch.**
The following code checks out the staging branch and then merges all changes from the master (the work branch) branch, then pushes the staging to origin (which is the github depo).

	git checkout staging
	git merge master
	git push origin staging

**To Deploy a production commit *you must merge from the staging branch*. Do not merge direct from master, as this is untested code.**
The following code is to take the latest pushed revision from staging and push to production

	git checkout production
	git merge staging
	git push origin production

**This is a two step approach. MASTER (development code) -> STAGING. STAGING -> PRODUCTION. **

Staging should be tested throughly before being added to the production branch.

**In case of an emergency**

If you pushed out code to PRODUCTION you shouldn't have you can rollback the previous commit.

/deployment/rollback/*key*/*commit id*





	

