VERSION=`php -q tools/print_version.php`
REVISION=`svn info | grep "Last Changed Rev" | sed s/"Last Changed Rev: "//`
DIRNAME=newsposter-$(VERSION)

misc:
	@echo Newsposter Version: $(VERSION)
	@echo Last Changed Revision: $(REVISION)
	svn log -v > ChangeLog
	svn export . $(DIRNAME)
	cp ChangeLog $(DIRNAME)

dist:
	make misc
	tar -zcf $(DIRNAME).tar.gz $(DIRNAME)
	tar -jcf $(DIRNAME).tar.bz2 $(DIRNAME)
	zip -9 -r $(DIRNAME).zip $(DIRNAME)
	rm -r $(DIRNAME)