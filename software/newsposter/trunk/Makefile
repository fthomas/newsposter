# $Id: Makefile 238 2004-09-27 17:00:52Z mrfrost $

VERSION	 = `php -q tools/print_version.php`
REVISION = `svn info | grep "Last Changed Rev" | sed s/"Last Changed Rev: "//`
DIRNAME  = newsposter-$(VERSION)

misc:
	@echo "Newsposter Version: $(VERSION)"
	@echo "Last Changed Revision: $(REVISION)"
	@-svn log -v > doc/ChangeLog.txt

dist: misc
	svn  export . $(DIRNAME)
	cp   doc/ChangeLog.txt $(DIRNAME)/doc/ChangeLog.txt
	rm   $(DIRNAME)/Makefile
	tar  -zcf $(DIRNAME).tar.gz  $(DIRNAME)
	tar  -jcf $(DIRNAME).tar.bz2 $(DIRNAME)
	zip  -9 -r $(DIRNAME).zip    $(DIRNAME)
	rm   -r $(DIRNAME)

clean:
	-rm var/error.log
	-rm var/mbox
	-rm var/mbox.bak
	-rm var/overview_fs
	-rm var/overview_fs.bak
	-rm var/feed_atom03.xml
	-rm var/feed_rss10.rdf
	-rm var/feed_rss20.rdf        

phpdoc:
	-rm -r doc/phpdoc
	phpdoc --directory include\
	 --target doc/phpdoc \
	 --title 'Newsposter API Documentation'\
	 --parseprivate on\
	 --output HTML:frames:earthli\
	 --sourcecode on
