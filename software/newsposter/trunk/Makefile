# $Id$

VERSION	 = `php -q tools/print_version.php`
REVISION = `svn info | grep "Last Changed Rev" | sed s/"Last Changed Rev: "//`
DIRNAME  = newsposter-$(VERSION)

misc:
	@echo "Newsposter Version: $(VERSION)"
	@echo "Last Changed Revision: $(REVISION)"
	@-svn log -v > doc/changelog.txt

dist: misc phpdoc
	svn  export . $(DIRNAME)
	cp   doc/changelog.txt $(DIRNAME)
	cp   -r doc/doxygen/html $(DIRNAME)/doc/doxygen/html
	rm   $(DIRNAME)/Makefile
	rm   $(DIRNAME)/doc/doxygen/Doxyfile
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
	-rm -r spool/feeds

phpdoc:
	-rm -r doc/phpdoc
	phpdoc --directory include\
	 --target doc/phpdoc \
	 --title 'Newsposter API Documentation'\
	 --parseprivate on\
	 --output HTML:frames:earthli\
	 --sourcecode on
