VERSION=`php -q tools/print_version.php`
REVISION=`svn info | grep "Last Changed Rev"` | sed s/"Last Changed Rev: "//

all:
	@echo Newsposter Version: $(VERSION)
	@echo Last Changed Revision: $(REVISION)
	svn log -v > ChangeLog