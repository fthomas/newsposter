# $Id: Makefile 213 2004-09-13 03:28:24Z mrfrost $

VERSION	 = `php -q tools/print_version.php`
REVISION = `svn info | grep "Last Changed Rev" | sed s/"Last Changed Rev: "//`
DIRNAME  = newsposter-$(VERSION)

misc:
	@echo "Newsposter Version: $(VERSION)"
	@echo "Last Changed Revision: $(REVISION)"
	@-svn log -v > ChangeLog

dist:
	make misc
	svn  export . $(DIRNAME)
	cp   ChangeLog $(DIRNAME)
	rm   $(DIRNAME)/Makefile
	tar  -zcf $(DIRNAME).tar.gz  $(DIRNAME)
	tar  -jcf $(DIRNAME).tar.bz2 $(DIRNAME)
	zip  -9 -r $(DIRNAME).zip    $(DIRNAME)
	rm   -r $(DIRNAME)

clean:
	-rm error.log
	-rm spool/mbox
	-rm spool/mbox.bak
	-rm spool/news.rss
	-rm spool/overview_fs
	-rm spool/overview_fs.bak

