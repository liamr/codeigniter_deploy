###Codeigniter Multi-server deployment Setup



##Things to look at

#.gitignore
Ignores:

* Cache
* Logs
* Any modules
* .htaccess (root)
* app_version - deployment file with the commit data


#Deployment process
All development should take place on master - or any feature branch.
There are two branches used for distribution, staging and production. Commiting to these branches will push code to the staging and production servers. To deploy there is a two step process which must be adhered to. 

1. To Deploy to staging you must merge from the *master* branch.
The following code checks out the staging branch and then merges all changes from the master (the work branch) branch, then pushes the staging to origin (which is the github depo).

	git checkout staging
	git merge master
	git push origin staging

2. To Deploy a production commit *you must merge from the staging branch. Do not merge direct from master, as this is untested code.*
The following code is to take the latest pushed revision from staging and push to production

	git checkout production
	git merge staging
	git push origin production

**This is a two step approach. MASTER (development code) -> STAGING. STAGING -> PRODUCTION. **

Staging should be tested throughly before being added to the production branch.

#In case of an emergency

If you pushed out code to PRODUCTION you shouldn't have you can rollback the previous commit.

	//On master branch
	git add .
	git commit -m "Added a bad change"
	git push origin master

	//merge to staging
	git checkout staging
	git merge master
	git push origin staging	

	

