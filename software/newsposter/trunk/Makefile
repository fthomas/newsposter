# $Id$

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
	tar  -zcf $(DIRNAME).tar.gz  $(DIRNAME)
	tar  -jcf $(DIRNAME).tar.bz2 $(DIRNAME)
	zip  -9 -r $(DIRNAME).zip    $(DIRNAME)
	rm   -r $(DIRNAME)

clean:
	-rm var/error.log
	-rm var/feed_atom03.xml
	-rm var/feed_rss10.xml
	-rm var/feed_rss20.xml
	-rm -r doc/phpdoc

phpdoc:
	-rm -r doc/phpdoc
	phpdoc --directory include\
	 --target doc/phpdoc \
	 --title 'Newsposter API Documentation'\
	 --parseprivate on\
	 --output HTML:frames:earthli\
	 --sourcecode on\
	 --ignore testing.php
