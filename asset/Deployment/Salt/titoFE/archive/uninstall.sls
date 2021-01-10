#Variables:
{% set HTMLPATH = '/var/www/html' %}
{% set GITREPO = 'https://github.com/vmeoc/Tito/' %}
{% set HTTPDCONF = '/etc/httpd/conf/httpd.conf' %}
{% set CODEVERSION = 'V1.5' %}
{% set PHPINIFILE = '/etc/php.ini' %}
#A modifier
{% set SQLSERVER = 'xxx' %}

install all nec packages:
  pkg.removed:
    - pkgs: 
      - git
      - httpd
      - php
      - php-mysql

{{ PHPINIFILE }}:
  file.absent

{{ HTTPDCONF }}:
  file.absent
