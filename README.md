# Static archive of the 2015 edition

Fetch async pages not parsed by curl 

    rake restore_ajax

Fetching extra missing pages

    cat programmation/ajax/* | grep -o -e "http://webaquebec.org/activite/[^\"]*" | xargs wget --page-requisites --html-extension --convert-links --no-verbose -x -e robots=off -P .