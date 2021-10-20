# git add *
# git commit -m "some changes"
# git push origin dev0

if [!$1]
then
	git add *;
	git commit -m "$1";
	git push origin dev0;
else
	git add *;
	git commit -m "some changes";
	git push origin dev0;
fi