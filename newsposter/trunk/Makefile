VERSION=`php -q tools/print_version.php`
REVISION=`svn info | grep "Last Changed Rev" | sed s/"Last Changed Rev: "//`
DIRNAME=newsposter-$(VERSION)

misc:
	@echo Newsposter Version: $(VERSION)
	@echo Last Changed Revision: $(REVISION)
	-svn log -v > ChangeLog

dist:
	make misc
	make doxygen
	svn export . $(DIRNAME)
	cp ChangeLog $(DIRNAME)
	cp -r doc/doxygen/html $(DIRNAME)/doc/doxygen/html
	rm $(DIRNAME)/Makefile
	rm $(DIRNAME)/doc/doxygen/Doxyfile
	tar -zcf $(DIRNAME).tar.gz $(DIRNAME)
	tar -jcf $(DIRNAME).tar.bz2 $(DIRNAME)
	zip -9 -r $(DIRNAME).zip $(DIRNAME)
	rm -r $(DIRNAME)

clean:
	-rm error.log
	-rm spool/mbox
	-rm spool/mbox.bak
	-rm spool/news.rss
	-rm spool/overview_fs
	-rm spool/overview_fs.bak
	-rm -r doc/doxygen/html

doxygen:
	-rm -r doc/doxygen/html
	doxygen doc/doxygen/Doxyfile
